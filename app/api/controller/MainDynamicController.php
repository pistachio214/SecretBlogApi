<?php

namespace app\api\controller;

use app\service\AppMainService;
use app\utils\R;
use DI\Attribute\Inject;

use support\Request;
use support\Response;

/**
 * 首页控制器
 */
class MainDynamicController
{
    #[Inject]
    protected AppMainService $appMainService;

    /**
     * 首页推荐 - 轮播列表
     *
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-26 15:01:58
     */
    public function bannerList(Request $request): Response
    {
        return R::success($this->appMainService->mainDynamicRecommendBannerList());
    }

    /**
     * 首页推荐 - 帖子列表
     *
     * @param Request $request
     * @return Response
     */
    public function postList(Request $request): Response
    {
        return R::success($this->appMainService->mainDynamicRecommendPostList($request->get('keyword')));
    }

    /**
     * 首页关注 - 帖子列表
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-02 10:56:47
     */
    public function postFollowList(Request $request): Response
    {
        return R::success($this->appMainService->mainDynamicFollowPostList($request->get('keyword')));
    }

    /**
     * 首页自拍 - 数据列表
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-02 11:43:13
     */
    public function selfieList(Request $request): Response
    {
        return R::success($this->appMainService->mainDynamicSelfiePostList($request->get('keyword')));
    }


}
