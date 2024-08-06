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
     * 获取用户本身信息
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 14:52:36
     */
    public function mine(): Response
    {
        return R::success($this->userService->getMineInfo());
    }

    /**
     * 获取特定用户的信息
     * @param string $id
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 14:56:33
     */
    public function mineByUserId(string $id): Response
    {
        return R::success($this->userService->getMineInfoByUserId($id));
    }

    /**
     * 获取用户本身资料
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 14:53:20
     */
    public function profile(): Response
    {
        return R::success($this->userService->getMineProfile());
    }

    /**
     * 获取特定用户的资料
     * @param string $id
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 14:57:06
     */
    public function profileByUserId(string $id): Response
    {
        return R::success($this->userService->getMineProfileByUserId($id));
    }

    /**
     * 获取用户本身动态
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 14:53:27
     */
    public function dynamic(): Response
    {
        return R::success($this->userService->getMineDynamic());
    }

    /**
     * 获取特定用户的动态
     * @param string $id
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 14:58:06
     */
    public function dynamicByUserId(string $id): Response
    {
        return R::success($this->userService->getMineDynamicByUserId($id));
    }

    // TODO 编辑用户
    public function edit(Request $request): Response
    {
        return R::success();
    }

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
