<?php

namespace app\service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use support\Request;

interface PostService
{

    /**
     * 发帖
     * @param Request $request
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-29 15:48:09
     */
    public function createPost(Request $request): void;

    /**
     * 帖子基本详情
     * @param string $id
     * @return Model|null
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-29 13:36:19
     */
    public function postDetail(string $id): ?Model;

    /**
     * 回帖信息
     * @param Request $request
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-30 23:33:21
     */
    public function createPostReplyMessage(Request $request): void;

    /**
     * 回帖信息列表
     * @param string $postId
     * @param string $parentId
     * @return LengthAwarePaginator
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-29 14:08:56
     */
    public function postReplyMessage(string $postId, string $parentId): LengthAwarePaginator;

    /**
     * 帖子点赞
     * @param string $postId
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-31 10:53:22
     */
    public function postLike(string $postId): void;

}