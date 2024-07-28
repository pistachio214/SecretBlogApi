<?php

namespace app\api\controller;

use app\model\PostFilesModel;
use app\model\PostModel;
use app\model\SysUserFilesModel;
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
        $userId = '1689541974618537986';

        $userFilesModel = new SysUserFilesModel();
        $userFilesModel->user_id = $userId;
        $userFilesModel->url = 'https://source.cengceng.chat/fbottle/2024-04-09-Image_1712420254324.jpg';
        $userFilesModel->type = 1;

        $userFilesModel->save();

        return R::success();
    }

}
