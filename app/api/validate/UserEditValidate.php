<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class UserEditValidate extends Validate
{
    protected $rule = [
        'nickname' => 'require|max:20',
        'sex' => 'in:0,1,2',
        'signature' => 'max:100',
        'hobby' => 'array'
    ];

    protected $message = [
        'nickname.require' => '昵称为必填项',
        'nickname.max' => '昵称最大长度为20',
        'sex.in' => '性别字段不合法',
        'signature.max' => '个人签名最大长度为100',
        'hobby.array' => '兴趣爱好格式不合法'
    ];

    /**
     * @throws Throwable
     */
    public function __construct(Request $request)
    {
        throw_unless($this->check($request->all()), ApiBusinessException::class, $this->getError());
    }
}