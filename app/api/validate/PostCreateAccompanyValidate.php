<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class PostCreateAccompanyValidate extends Validate
{
    protected $rule = [
        'title' => 'require|max:25',
        'content' => 'require|max:300',
        'images' => 'require|array'
    ];

    protected $message = [
        'title.require' => '约伴标题不能为空',
        'title.max' => '约伴标题最多不能超过25个字',
        'content.require' => '约伴标题内容是必填项',
        'content.max' => '约伴内容最多不能超过300个字',
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