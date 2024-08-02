<?php

namespace app\service;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AppMainService
{
    public function mainDynamicRecommendBannerList(): Collection;

    public function mainDynamicRecommendPostList(string $keyword = null): LengthAwarePaginator;

    public function mainDynamicFollowPostList(string $keyword = null): LengthAwarePaginator;

    public function mainDynamicSelfiePostList(string $keyword = null): LengthAwarePaginator;

    public function mainDiscoveryTopTagList(): Collection;

    public function mainDiscoveryTagList(): Collection;

    public function mainDiscoveryPostListByTag(string $tagId, string $keyword = null): LengthAwarePaginator;
}