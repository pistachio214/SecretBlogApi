<?php

namespace app\api\controller;

use app\service\UserService;
use app\utils\R;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

class UserController
{
    #[Inject]
    protected UserService $userService;

    public function follow(Request $request): Response
    {
        $this->userService->followAction($request->input('follow_user_id'));
        return R::success();
    }

    public function unFollow(Request $request): Response
    {
        $this->userService->unFollowAction($request->input('follow_user_id'));
        return R::success();
    }

}
