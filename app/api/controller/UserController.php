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

    /**
     * 关注用户
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-02 11:23:21
     */
    public function follow(Request $request): Response
    {
        $this->userService->followAction($request->input('follow_user_id'));
        return R::success();
    }

    /**
     * 取消关注
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-02 11:23:31
     */
    public function unFollow(Request $request): Response
    {
        $this->userService->unFollowAction($request->input('follow_user_id'));
        return R::success();
    }

}
