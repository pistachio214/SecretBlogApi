<?php

namespace app\service\impl;

use app\model\PostModel;
use app\model\PostReplyMessageModel;
use app\service\PostService;
use DI\Attribute\Inject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostServiceImpl implements PostService
{
    #[Inject]
    protected PostModel $postModel;

    #[Inject]
    protected PostReplyMessageModel $postReplyMessageModel;

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

    public function postReplyMessage(string $id): LengthAwarePaginator
    {
        return $this->postReplyMessageModel->newQuery()
            ->where([
                'post_id' => $id,
                'parent_id' => 0,
            ])
            ->with([
                'user' => function ($query) {
                    $query->select('id', 'nickname', 'avatar');
                },
            ])
            ->select('id', 'user_id', 'content', 'image', 'like_number', 'reply_number', 'created_at')
            ->orderByDesc('like_number')
            ->orderByDesc('created_at')
            ->paginate(15);
    }


}