<?php

namespace app\model;

use app\utils\SnowflakeUtil;
use DateTimeInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use support\Model;

class BaseModel extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = true;

    /**
     * 不可写字段
     * @var string[]
     */
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 模型隐藏字段
     * @var string[]
     */
    protected $hidden = ['updated_at', 'deleted_at'];

//    public static function createModelInstance(): static
//    {
//        // 注意这里使用了 late static binding
//        return new static();
//    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = SnowflakeUtil::getId();
        });
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }

}