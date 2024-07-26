<?php

namespace app\service;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AppMainService
{
    /**
     * 首页推荐 - 轮播列表
     * @return Collection
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-26 15:01:58
     */
    public function mainDynamicBannerList(): Collection;


    //TODO 首页推荐 - 帖子列表
    public function mainDynamicPostList(int $page): LengthAwarePaginator;
}