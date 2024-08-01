<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class UserFollowValidate extends Validate
{
    protected $rule = [
        'follow_user_id' => 'require',
    ];

    protected $message = [
        'follow_user_id.require' => '关注用户的信息是必填项',
    ];

    /**
     * @throws Throwable
     */
    public function __construct(Request $request)
    {
        throw_unless($this->check($request->all()), ApiBusinessException::class, $this->getError());
    }
}