<?php

namespace app\api\controller;

use app\utils\R;
use support\Request;
use support\Response;

class MainDynamicController
{
    /**
     * APP主页推荐模块 - 轮播数据
     *
     * @param Request $request
     * @return Response
     */
    public function banner(Request $request): Response
    {
        return R::ERROR();
    }

}
