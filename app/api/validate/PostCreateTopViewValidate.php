<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class PostCreateTopViewValidate extends Validate
{
    protected $rule = [
        'title' => 'require|max:25',
        'images' => 'array'
    ];

    protected $message = [
        'title.require' => '约伴标题不能为空',
        'title.max' => '约伴标题最多不能超过25个字',
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