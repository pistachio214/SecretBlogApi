<?php

namespace app\model;

use app\utils\SnowflakeUtil;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use support\Model;

class BaseModel extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = true;

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = SnowflakeUtil::getId();
        });
    }

    /**
     * 访问器: 格式化 created_at日期
     * @param $value
     * @return string
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-26 11:44:19
     */
    public function getCreatedAtAttribute($value): string
    {
        return Carbon::parse($value)->tz(config('app.default_timezone'))->format('Y-m-d H:i:s');
    }

    /**
     * 访问器: 格式化 updated_at 日期
     * @param $value
     * @return string
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-26 11:44:38
     */
    public function getUpdatedAttribute($value): string
    {
        return Carbon::parse($value)->tz(config('app.default_timezone'))->format('Y-m-d H:i:s');
    }

    /**
     * 访问器: 格式化 deleted_at 日期
     * @param $value
     * @return string
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-26 11:44:38
     */
    public function getDeletedAttribute($value): string
    {
        return Carbon::parse($value)->tz(config('app.default_timezone'))->format('Y-m-d H:i:s');
    }


}