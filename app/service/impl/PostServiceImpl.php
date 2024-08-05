<?php

namespace app\service\impl;

use app\exception\ApiBusinessException;
use app\model\HashtagsModel;
use app\model\PostFilesModel;
use app\model\PostHashtagsModel;
use app\model\PostLikeModel;
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
use Webman\Event\Event;

class PostServiceImpl implements PostService
{
    #[Inject]
    protected HashtagsModel $hashtagsModel;

    #[Inject]
    protected PostModel $postModel;

    #[Inject]
    protected PostFilesModel $postFilesModel;

    #[Inject]
    protected PostLikeModel $postLikeModel;

    #[Inject]
    protected PostHashtagsModel $postHashtagsModel;

    #[Inject]
    protected PostReplyMessageModel $postReplyMessageModel;

    /**
     * @throws ApiBusinessException
     */
    public function createPost(Request $request): void
    {
        $this->createPostAction($request, ['post_type' => 1]);
    }

    public function createSelfiePost(Request $request): void
    {
        $this->createPostAction($request, ['post_type' => 2]);
    }

    public function createAccompanyPost(Request $request): void
    {
        $this->createPostAction($request, ['post_type' => 4]);
    }

    public function createTopView(Request $request): void
    {
        $this->createPostAction($request, ['post_type' => 5]);
    }

    private function createPostAction(Request $request, array $option = []): void
    {
        $userContext = Context::get('user');

        Db::beginTransaction();
        try {
            $data = $request->only(['title', 'content']);

            $postModel = $this->postModel->newInstance();

            if (isset($option['post_type']) && in_array($option['post_type'], [4, 5])) {
                $postModel->title = $data['title'];
            }

            if (isset($data['content']) && !empty($data['content'])) {
                $postModel->content = $data['content'];
            }

            $postModel->user_id = $userContext->id;
            $postModel->type = 2;
            if (isset($option['post_type']) && !empty($option['post_type'])) {
                $postModel->post_type = $option['post_type'];
            } else {
                $postModel->post_type = 1;
            }

            $postModel->save();

            $date = date('Y-m-d H:i:s', time());
            $commonDate = [
                'created_at' => $date,
                'updated_at' => $date,
            ];

            $images = $request->post('images', []);
            if (is_array($images) && count($images) > 0) {
                $postFiles = [];
                foreach ($images as $image) {
                    $postFiles[] = array_merge([
                        'id' => SnowflakeUtil::getId(),
                        'post_id' => $postModel->id,
                        'url' => $image,
                        'type' => 1,
                    ], $commonDate);
                }

                if (count($postFiles) > 0) {
                    $this->postFilesModel->newInstance()->insert($postFiles);
                }
            }

            $tags = $request->post('hashtags', []);
            if (is_array($tags) && count($tags) > 0) {
                $postTags = [];
                foreach ($tags as $tag) {
                    $hashtagsModel = $this->hashtagsModel->newQuery()->firstOrCreate(['name' => $tag]);
                    $postTags[] = array_merge([
                        'id' => SnowflakeUtil::getId(),
                        'post_id' => $postModel->id,
                        'hashtags_id' => $hashtagsModel->id,
                    ], $commonDate);
                }

                if (count($postTags) > 0) {
                    $this->postHashtagsModel->newInstance()->insert($postTags);
                }
            }

            Event::dispatch('post.create.follow.up.work.event', $postModel);

            Db::commit();
        } catch (Throwable $exception) {
            Db::rollBack();
            throw new ApiBusinessException("发帖失败!请检查您的发贴信息是否合法！", $exception->getMessage());
        }
    }

    public function postDetail(string $id): ?Model
    {
        $data = $this->postModel->newQuery()
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
                'files' => function ($query) {
                    $query->select('post_id', 'url', 'type');
                }
            ])
            ->first();

        $userContext = Context::get('user');
        $isLike = $this->postLikeModel->newQuery()->where([
            'user_id' => $userContext->id,
            'post_id' => $id
        ])->exists();

        $data->is_like = $isLike;

        return $data;
    }

    /**
     * @throws Throwable
     */
    public function createPostReplyMessage(Request $request): void
    {
        $data = $request->only(['post_id', 'parent_id', 'receive_id', 'content', 'image']);

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

    /**
     * @throws Throwable
     */
    public function postLike(string $postId): void
    {
        $userContext = Context::get('user');

        $exists = $this->postLikeModel->newQuery()
            ->where([
                'user_id' => $userContext->id,
                'post_id' => $postId
            ])
            ->exists();

        throw_if($exists, ApiBusinessException::class, '您已点赞,请勿重复点赞', null);

        $postLikeModel = $this->postLikeModel->newInstance();
        $postLikeModel->user_id = $userContext->id;
        $postLikeModel->post_id = $postId;

        $postLikeModel->save();
    }


}