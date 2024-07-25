<?php

namespace app\service\impl;

use app\model\AppBannerModel;
use app\service\AppMainService;

use Illuminate\Database\Eloquent\Collection;
use DI\Attribute\Inject;

class AppMainServiceImpl implements AppMainService
{
    #[Inject]
    protected AppBannerModel $appBannerModel;

    public function mainDynamicBannerList(): Collection
    {
        return $this->appBannerModel->where(['type' => 1])
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'remarks', 'image', 'arguments', 'created_at']);
    }
}