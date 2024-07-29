<?php

namespace app\service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostService
{

    // TODO 发帖
    public function createPost();

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
     * @param string $id
     * @return LengthAwarePaginator
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-29 14:08:56
     */
    public function postReplyMessage(string $id): LengthAwarePaginator;


}