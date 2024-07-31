<?php

namespace app\api\controller;

use app\service\PostService;
use app\utils\R;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

class PostController
{
    #[Inject]
    protected PostService $postService;

    public function create(Request $request): Response
    {
        $this->postService->createPost($request);
        return R::success();
    }

    public function detail(Request $request, string $id): Response
    {
        return R::success($this->postService->postDetail($id));
    }

    public function createReplyMessage(Request $request): Response
    {
        $this->postService->createPostReplyMessage($request);
        return R::success();
    }

    public function replyMessage(Request $request, string $id): Response
    {
        $parentId = $request->get('parent_id', 0);
        return R::success($this->postService->postReplyMessage($id, $parentId));
    }

}
