<?php

namespace app\middleware;

use app\model\SysUserModel;
use app\utils\R;
use support\Cache;
use Webman\Context;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class RequestApiAuthCheckMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
//        $token = $request->header('token');
//
//        if (empty($token)) {
//            return R::error('您需要先进行登陆后再进行操作');
//        }
//
//        if (!Cache::has($token)) {
//            return R::error("您的登陆信息已失效,请重新登录!");
//        }
//
//        $user = Cache::get($token);
//        if (!$user) {
//            return R::error("用户信息不存在,请重新登录!");
//        }

        $user = SysUserModel::find('1689541974618537987');
        Context::set("user", $user);

        return $handler($request);
    }

}
