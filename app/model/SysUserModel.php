<?php

namespace app\model;

/**
 * 系统用户模型
 */
class SysUserModel extends BaseModel
{

    protected $table = 'sys_user';

    public function getHidden(): array
    {
        $hidden = parent::getHidden();

        return array_merge(['password', 'type', 'status'], $hidden);
    }
}
