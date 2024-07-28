<?php

namespace app\api\controller;

use app\model\PostFilesModel;
use app\model\PostModel;
use app\utils\R;
use DI\Attribute\Inject;
use support\Request;
use support\Response;

class TestController
{
    #[Inject]
    protected PostFilesModel $postFilesModel;

    public function test(Request $request): Response
    {
        $userId = '1689541974618537988';

        $postModel = new PostModel();
        $postModel->user_id = $userId;
        $postModel->title = '后入的时候，屁股翘起来，腰怎么沉下去的';
        $postModel->type = 1;
        $postModel->content = '男朋友总说我腰僵硬，让我趴下去点，这样他插得更深～';
        $postModel->save();

        $PostFilesModel = new PostFilesModel();

        $PostFilesModel->post_id = $postModel->id;
        $PostFilesModel->url = 'https://wx2.sinaimg.cn/mw690/007bEUcdgy1hqv1gxpu9oj30xc0wwn6w.jpg';
        $PostFilesModel->type = 1;

        $PostFilesModel->save();

        return R::success();
    }

}
