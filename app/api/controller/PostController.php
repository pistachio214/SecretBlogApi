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
        return R::success();
    }

    public function detail(Request $request, string $id): Response
    {
        return R::success($this->postService->postDetail($id));
    }

    public function replyMessage(Request $request, string $id): Response
    {
        return R::success($this->postService->postReplyMessage($id));
    }

}
