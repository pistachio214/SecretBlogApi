<?php

namespace app\service\impl;

use app\model\AppBannerModel;
use app\model\PostModel;
use app\service\AppMainService;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use DI\Attribute\Inject;

class AppMainServiceImpl implements AppMainService
{
    #[Inject]
    protected AppBannerModel $appBannerModel;

    #[Inject]
    protected PostModel $postModel;

    public function mainDynamicBannerList(): Collection
    {
        return $this->appBannerModel->newQuery()
            ->where(['type' => 1])
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'remarks', 'image', 'arguments', 'created_at']);
    }

    public function mainDynamicPostList(int $page): LengthAwarePaginator
    {
        return $this->postModel->newQuery()
            ->with([
                'users' => function ($query) {
                    $query->select('id', 'nickname', 'avatar');
                }
            ])
            ->orderByDesc('created_at')
            ->paginate(15, ['*'], 'page', $page);
    }


}