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

    public function replyUser(): HasOne
    {
        return $this->hasOne(SysUserModel::class, 'id', 'reply_id');
    }

    public function receiveUser(): HasOne
    {
        return $this->hasOne(SysUserModel::class, 'id', 'receive_id');
    }

}
