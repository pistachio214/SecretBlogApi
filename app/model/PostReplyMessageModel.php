<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\HasOne;

class PostReplyMessageModel extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_reply_message';
    
    public function user(): HasOne
    {
        return $this->hasOne(SysUserModel::class, 'id', 'user_id');
    }

}
