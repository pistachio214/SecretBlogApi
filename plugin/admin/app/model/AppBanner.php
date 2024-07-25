<?php

namespace plugin\admin\app\model;

use plugin\admin\app\model\Base;

/**
 * @property integer $id 编号(主键)
 * @property string $title 标题
 * @property integer $type 轮播的位置
 * @property string $remarks 备注
 * @property string $image 轮播图地址
 * @property string $arguments 跳转参数
 * @property mixed $created_at 创建时间
 * @property mixed $updated_at 更新时间
 * @property mixed $deleted_at
 */
class AppBanner extends Base
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_banner';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    
    
}
