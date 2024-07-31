<?php

namespace app\service\impl;

use app\exception\ApiBusinessException;
use app\model\PostFilesModel;
use app\model\PostModel;
use app\model\PostReplyMessageModel;
use app\service\PostService;
use app\utils\SnowflakeUtil;
use DI\Attribute\Inject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use support\Db;
use support\Log;
use support\Request;
use Throwable;
use Webman\Context;

class PostServiceImpl implements PostService
{
    #[Inject]
    protected PostModel $postModel;

    #[Inject]
    protected PostFilesModel $postFilesModel;

    #[Inject]
    protected PostReplyMessageModel $postReplyMessageModel;

    /**
     * @throws ApiBusinessException
     */
    public function createPost(Request $request): void
    {
        $userContext = Context::get('user');

        Db::beginTransaction();
        try {
            $data = $request->only(['title', 'content']);

            $postModel = $this->postModel->newInstance();

            $postModel->title = $data['title'];
            $postModel->content = $data['content'];
            $postModel->user_id = $userContext->id;
            $postModel->type = 2;

            $postModel->save();

            $images = $request->post('images');
            if (is_array($images) && count($images) > 0) {
                $postFile = [];
                foreach ($images as $image) {
                    $postFile[] = [
                        'id' => SnowflakeUtil::getId(),
                        'post_id' => $postModel->id,
                        'url' => $image,
                        'type' => 1,
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'updated_at' => date('Y-m-d H:i:s', time()),
                    ];
                }

                if (count($postFile) > 0) {
                    $this->postFilesModel->newInstance()->insert($postFile);
                }
            }

            Db::commit();
        } catch (Throwable $exception) {
            Db::rollBack();
            throw new ApiBusinessException("发帖失败!请检查您的发贴信息是否合法！", $exception->getMessage());
        }
    }

    public function postDetail(string $id): ?Model
    {
        return $this->postModel->newQuery()
            ->where('id', $id)
            ->with([
                'users' => function ($query) {
                    $query->select('id', 'nickname', 'avatar')
                        ->with([
                            'userExtend' => function ($q) {
                                $q->select('user_id', 'sex', 'signature', 'signature');
                            }
                        ]);
                },
                'images' => function ($query) {
                    $query->select('post_id', 'url', 'type');
                }
            ])
            ->first();
    }

    /**
     * @throws Throwable
     */
    public function createPostReplyMessage(Request $request): void
    {
        $data = $request->only(['post_id', 'parent_id', 'receive_id', 'content', 'image']);

        Log::info(json_encode($data));

        $postExists = $this->postModel->newQuery()->where(['id' => $data['post_id']])->exists();
        throw_unless($postExists, ApiBusinessException::class, '秘贴不存在,请刷新重新进入', null);

        $userContext = Context::get('user');

        $postReplyMessageModel = $this->postReplyMessageModel->newInstance();

        $postReplyMessageModel->post_id = $data['post_id'];
        $postReplyMessageModel->parent_id = $data['parent_id'] ?: 0;
        $postReplyMessageModel->reply_id = $userContext->id;
        $postReplyMessageModel->receive_id = $data['receive_id'] ?: null;
        $postReplyMessageModel->content = $data['content'];
        $postReplyMessageModel->image = $data['image'] ?? null;

        $postReplyMessageModel->save();
    }

    public function postReplyMessage(string $postId, string $parentId): LengthAwarePaginator
    {
        return $this->postReplyMessageModel->newQuery()
            ->where([
                'post_id' => $postId,
                'parent_id' => $parentId,
                'status' => 1,
            ])
            ->with([
                'replyUser' => function ($query) {
                    $query->select('id', 'nickname', 'avatar');
                },
                'receiveUser' => function ($query) {
                    $query->select('id', 'nickname', 'avatar');
                },
            ])
            ->select('id', 'parent_id', 'reply_id', 'receive_id', 'content', 'image', 'like_number', 'reply_number', 'created_at')
            ->orderByDesc('like_number')
            ->orderByDesc('created_at')
            ->paginate(15);
    }


}