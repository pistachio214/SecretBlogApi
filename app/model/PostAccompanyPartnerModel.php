<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasOne;

class PostAccompanyPartnerModel extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_accompany_partner';

    public function users(): HasOne
    {
        return $this->hasOne(SysUserModel::class, 'id', 'user_id');
    }

}
