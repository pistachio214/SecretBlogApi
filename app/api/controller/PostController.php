<?php

namespace app\api\controller;

use app\service\PostService;
use app\utils\R;
use DI\Attribute\Inject;
use support\Log;
use support\Request;
use support\Response;

class PostController
{
    #[Inject]
    protected PostService $postService;

    /**
     * 发帖
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-29 15:48:09
     */
    public function create(Request $request): Response
    {
        $this->postService->createPost($request);
        return R::success();
    }

    /**
     * 发自拍贴
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-02 11:51:53
     */
    public function createSelfie(Request $request): Response
    {
        $this->postService->createSelfiePost($request);
        return R::success();
    }

    /**
     * 发约伴贴
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-05 14:32:05
     */
    public function createAccompany(Request $request): Response
    {
        $this->postService->createAccompanyPost($request);
        return R::success();
    }

    /**
     * 发看法贴
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 10:07:00
     */
    public function createTopView(Request $request): Response
    {
        $this->postService->createTopView($request);
        return R::success();
    }

    /**
     * 帖子基本详情
     * @param Request $request
     * @param string $id
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-29 13:36:19
     */
    public function detail(string $id): Response
    {
        return R::success($this->postService->postDetail($id));
    }

    /**
     * 回帖信息
     * @param Request $request
     *
     * @return Response
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-30 23:33:21
     */
    public function createReplyMessage(Request $request): Response
    {
        $this->postService->createPostReplyMessage($request);
        return R::success();
    }

    /**
     * 回帖信息列表
     * @param Request $request
     * @param string $id
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-29 14:08:56
     */
    public function replyMessage(Request $request, string $id): Response
    {
        $parentId = $request->get('parent_id', 0);
        return R::success($this->postService->postReplyMessage($id, $parentId));
    }

    /**
     * 帖子点赞
     * @param Request $request
     * @return Response
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-31 10:53:22
     */
    public function like(Request $request): Response
    {
        $this->postService->postLike($request->input('post_id'));
        return R::success();
    }

}
