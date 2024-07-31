<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class PostCreatePostReplyMessageValidate extends Validate
{
    protected $rule = [
        'post_id' => 'require',
        'parent_id' => 'require',
        'receive_id' => 'require',
        'content' => 'require|max:200'
    ];

    protected $message = [
        'post_id.require' => '秘贴信息是必填项',
        'parent_id.require' => '发送对象是必填项',
        'receive_id.require' => '接收对象是必填项',
        'content.require' => '回帖信息是必填项',
        'content.max' => '回帖最多不能超过200个字',
    ];

    /**
     * @throws Throwable
     */
    public function __construct(Request $request)
    {
        throw_unless($this->check($request->all()), ApiBusinessException::class, $this->getError());
    }
}