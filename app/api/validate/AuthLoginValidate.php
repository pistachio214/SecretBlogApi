<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class AuthLoginValidate extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require|min:8',
    ];

    protected $message = [
        'username.require' => '账号信息是必填项',
        'password.require' => '密码信息是必填项',
        'password.min' => '密码信息最小长度为8位',
    ];

    /**
     * @throws Throwable
     */
    public function __construct(Request $request)
    {
        throw_unless($this->check($request->all()), ApiBusinessException::class, $this->getError());
    }
}