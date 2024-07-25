<?php

namespace app\api\controller;

use app\service\AppMainService;
use app\utils\R;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

class MainDynamicController
{

    #[Inject]
    protected AppMainService $appMainService;

    /**
     * APP主页推荐模块 - 轮播数据
     *
     * @param Request $request
     * @return Response
     */
    public function banner(Request $request): Response
    {
        $this->appMainService->mainDynamicBannerList();
        return R::SUCCESS();
    }

}
