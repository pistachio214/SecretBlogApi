<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class PostCreateValidate extends Validate
{
    protected $rule = [
        'content' => 'require|max:300',
    ];

    protected $message = [
        'content.require' => '帖子内容是必填项',
        'content.max' => '帖子标题最多不能超过300个字',
    ];

    /**
     * @throws Throwable
     */
    public function __construct(Request $request)
    {
        throw_unless($this->check($request->all()), ApiBusinessException::class, $this->getError());
    }
}