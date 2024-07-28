<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 系统用户模型
 */
class SysUserModel extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_user';

    public function getHidden(): array
    {
        $hidden = parent::getHidden();

        return array_merge(['password', 'type', 'status'], $hidden);
    }

    public function userExtend(): HasOne
    {
        return $this->hasOne(SysUserExtendModel::class, 'user_id', 'id');
    }

    public function userFiles(): HasMany
    {
        return $this->hasMany(SysUserFilesModel::class, 'user_id', 'id');
    }
}
