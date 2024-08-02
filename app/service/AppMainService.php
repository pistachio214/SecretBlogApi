<?php

namespace app\service;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AppMainService
{
    /**
     * 首页推荐 - 轮播列表
     *
     * @return Collection
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-26 15:01:58
     */
    public function mainDynamicRecommendBannerList(): Collection;


    /**
     * 首页推荐 - 帖子列表
     *
     * @param string|null $title
     * @return LengthAwarePaginator
     */
    public function mainDynamicRecommendPostList(string $title = null): LengthAwarePaginator;

    /**
     * 首页关注 - 帖子列表
     * @param string|null $title
     * @return LengthAwarePaginator
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-02 10:56:47
     */
    public function mainDynamicFollowPostList(string $title = null): LengthAwarePaginator;
}