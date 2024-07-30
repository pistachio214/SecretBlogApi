<?php

namespace app\api\controller;

use app\api\validate\TestTestValidate;
use app\model\PostReplyMessageModel;
use app\model\SysUserExtendModel;
use app\model\SysUserFilesModel;
use app\utils\R;
use support\Request;
use support\Response;
use Webman\Context;

class TestController
{

    public function test(Request $request): Response
    {
//        $userId = '1689541974618537989';

        return R::success($request->all());
    }

    private function createPostReplyMessage(): void
    {
        $userId = '1689541974618537989';
        $post_id = '1689541974618537988';

        for ($i = 0; $i < 20; $i++) {
            $postReplyMessageModel = new PostReplyMessageModel();

            $postReplyMessageModel->post_id = $post_id;
            $postReplyMessageModel->parent_id = 0;
            $postReplyMessageModel->user_id = $userId;
            $postReplyMessageModel->content = '第' . ($i + 1) . '次非常喜欢一句话,幸福是可以存储的❤️';

            $postReplyMessageModel->save();
        }


    }

    private function createUser(string $userId, array $file_data): void
    {
        $bg_image_key = array_rand($file_data);

        $sysUserExtendModel = new SysUserExtendModel();
        $sysUserExtendModel->user_id = $userId;
        $sysUserExtendModel->sex = 1;
        $sysUserExtendModel->signature = '以你三寸不烂之舌，吞我精兵两亿之多！';
        $sysUserExtendModel->bg_image = $file_data[$bg_image_key];

        $sysUserExtendModel->save();

        for ($i = 0; $i < 10; $i++) {
            $urlKey = array_rand($file_data);

            $sysUserFilesModel = new SysUserFilesModel();
            $sysUserFilesModel->user_id = $userId;
            $sysUserFilesModel->url = $file_data[$urlKey];
            $sysUserFilesModel->type = 1;

            $sysUserFilesModel->save();
        }


    }

    private function getImagesArray(): array
    {
        $file_path = "/Users/songyangpeng/Documents/temp/step_mimi.temp";
        if (file_exists($file_path)) {
            $fp = fopen($file_path, "r");
            $str = fread($fp, filesize($file_path));//指定读取大小，这里把整个文件内容读取出来
            fclose($fp);

            $key = "https:";
            $array = explode($key, $str);

            return array_map(function ($value) use ($key) {
                return $key . trim($value);
            }, array_slice($array, 5));
        }

        return [];
    }

}
