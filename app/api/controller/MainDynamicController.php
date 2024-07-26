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

    public function bannerList(Request $request): Response
    {
        return R::success($this->appMainService->mainDynamicBannerList());
    }

    public function postList(Request $request): Response
    {
        return R::success($this->appMainService->mainDynamicPostList($request->get('title')));
    }
}
