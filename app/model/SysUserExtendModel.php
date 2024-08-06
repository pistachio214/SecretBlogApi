<?php

namespace app\model;

use support\Model;

/**
 *
 */
class SysUserExtendModel extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sys_user_extend';

    /**
     * 转换兴趣爱好输出格式
     * @param $value
     * @return array
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-06 14:38:29
     */
    public function getHobbyAttribute($value): array
    {
        if ($value != null) {
            return json_decode($value);
        }

        return [];
    }
}
