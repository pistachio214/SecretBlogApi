<?php

namespace app\api\controller;

use app\service\AuthService;
use app\utils\R;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

class AuthController
{
    #[Inject]
    protected AuthService $authService;

    /**
     * App登录
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-07 15:49:28
     */
    public function login(Request $request): Response
    {
        return R::success($this->authService->login($request));
    }

    /**
     * 刷新令牌
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-07 15:49:42
     */
    public function refreshToken(): Response
    {
        return R::success($this->authService->refreshToken());
    }

    /**
     * 用户注销
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-07 15:57:09
     */
    public function logout(): Response
    {
        $this->authService->logout();
        return R::success();
    }

}
