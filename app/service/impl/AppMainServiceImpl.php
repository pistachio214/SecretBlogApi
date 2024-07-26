<?php

namespace app\service\impl;

use app\model\AppBannerModel;
use app\service\AppMainService;

use app\utils\SnowflakeUtil;
use Illuminate\Database\Eloquent\Collection;
use DI\Attribute\Inject;

class AppMainServiceImpl implements AppMainService
{
    #[Inject]
    protected AppBannerModel $appBannerModel;

    public function mainDynamicBannerList(): Collection
    {
//        $create_data_model = new AppBannerModel();
//        $create_data_model->id = SnowflakeUtil::getId();
//        $create_data_model->title = '首页轮播10';
//        $create_data_model->type = 1;
//        $create_data_model->remarks = '备注首页轮播1';
//        $create_data_model->image = 'http://192.168.2.109:9000/sexy-talk/index_banner.png';
//        $create_data_model->arguments = null;

//        $create_data = [
//            'id' => SnowflakeUtil::getId(),
//            'title' => '首页轮播1',
//            'type' => 1,
//            'remarks' => '备注首页轮播1',
//            'image' => 'http://192.168.2.109:9000/sexy-talk/index_banner.png',
//            'arguments' => null
//        ];

//        $create_data_model->save();

        return $this->appBannerModel->newQuery()
            ->where(['type' => 1])
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'remarks', 'image', 'arguments', 'created_at']);
    }

    public function deleteBanner(string $id): void
    {
        $this->appBannerModel->newQuery()->where(['id' => $id])->delete();
    }


}