<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class PostCreateSelfieValidate extends Validate
{
    protected $rule = [
        'content' => 'require|max:300',
        'images' => 'require|array'
    ];

    protected $message = [
        'content.require' => '帖子内容是必填项',
        'content.max' => '帖子内容最多不能超过300个字',
        'images.require' => '图片为必传项',
        'images.array' => '图片传递必须为数组格式'
    ];

    /**
     * @throws Throwable
     */
    public function __construct(Request $request)
    {
        throw_unless($this->check($request->all()), ApiBusinessException::class, $this->getError());
    }
}