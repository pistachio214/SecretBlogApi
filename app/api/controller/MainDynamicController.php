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

    public function banner(Request $request): Response
    {
        return R::SUCCESS($this->appMainService->mainDynamicBannerList());
    }

}
