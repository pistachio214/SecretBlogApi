<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class PostLikeValidate extends Validate
{
    protected $rule = [
        'post_id' => 'require',
    ];

    protected $message = [
        'post_id.require' => '秘贴信息是必填项',
    ];

    /**
     * @throws Throwable
     */
    public function __construct(Request $request)
    {
        throw_unless($this->check($request->all()), ApiBusinessException::class, $this->getError());
    }
}