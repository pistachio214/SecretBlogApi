<?php

namespace app\service\impl;

use app\service\AppMainService;
use support\Log;

class AppMainServiceImpl implements AppMainService
{
    public function mainDynamicBannerList()
    {
        Log::info("这里就是贫血模式抽象出来的实现类");
    }
}