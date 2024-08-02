<?php

namespace app\api\controller;

use app\service\AppMainService;
use app\utils\R;
use DI\Attribute\Inject;
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

    //TODO 获取话题下的帖子列表
    public function postList(Request $request, string $id): Response
    {
        return R::success($this->appMainService->mainDiscoveryPostListByTag($id));
    }
}
