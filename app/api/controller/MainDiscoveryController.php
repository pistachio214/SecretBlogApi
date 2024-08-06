<?php

namespace app\api\controller;

use app\service\AppMainService;
use app\utils\R;
use DI\Attribute\Inject;
use support\Log;
use support\Request;
use support\Response;

/**
 * 热度控制器
 */
class MainDiscoveryController
{
    #[Inject]
    protected AppMainService $appMainService;

    /**
     * 热门头部话题列表
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-02 14:27:08
     */
    public function tagTopList(Request $request): Response
    {
        return R::success($this->appMainService->mainDiscoveryTopTagList());
    }

    /**
     * 话题带描述的列表
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-02 15:07:38
     */
    public function tagList(Request $request): Response
    {
        return R::success($this->appMainService->mainDiscoveryTagList());
    }

    /**
     * 获取话题下的帖子列表
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function postListByTopic(Request $request, string $id): Response
    {
        return R::success($this->appMainService->mainDiscoveryPostListByTag($id));
    }

    /**
     * 获取约伴下的列表
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-05 15:41:33
     */
    public function postListByAccompany(Request $request): Response
    {
        return R::success($this->appMainService->mainDiscoveryPostListByAccompany());
    }

    /**
     * 加入约伴活动
     * @param string $id
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-05 16:04:12
     */
    public function joinAccompany(string $id): Response
    {
        $this->appMainService->mainDiscoveryJoinAccompany($id);
        return R::success();
    }

    /**
     * 约伴活动下的已加入人员列表
     * @param string $id
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 10:09:03
     */
    public function userListByAccompany(string $id): Response
    {
        return R::success($this->appMainService->mainDiscoveryUserListByAccompany($id));
    }

    /**
     * 看法界面的帖子列表
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 10:35:24
     */
    public function postListByTopView(Request $request): Response
    {
        $keyword = $request->get('keyword');
        return R::success($this->appMainService->mainDiscoveryPostListByTopView($keyword));
    }
}
