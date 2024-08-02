<?php

namespace app\service;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AppMainService
{
    public function mainDynamicRecommendBannerList(): Collection;

    public function mainDynamicRecommendPostList(string $title = null): LengthAwarePaginator;

    public function mainDynamicFollowPostList(string $title = null): LengthAwarePaginator;
}