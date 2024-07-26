<?php

namespace app\api\controller;

use app\model\PostFilesModel;
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
        $PostFilesModel = new PostFilesModel();

        $PostFilesModel->post_id = '1689541974618537988';
        $PostFilesModel->url = 'https://wx2.sinaimg.cn/mw690/007bEUcdgy1hqv1gxpu9oj30xc0wwn6w.jpg';
        $PostFilesModel->type = 1;

        $PostFilesModel->save();

        return R::success();
    }

}
