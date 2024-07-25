<?php

namespace app\model;

use support\Model;

class AppBannerModel extends Model
{
    protected $connection = 'mysql';
    
    protected $table = 'app_banner';

    protected $primaryKey = 'id';

    public $timestamps = true;

}
