<?php

namespace app\api\validate;

use app\exception\ApiBusinessException;
use support\Request;
use think\Validate;
use Throwable;

class PostCreateValidate extends Validate
{

    protected $rule = [
        'title' => 'require|max:25',
        'content' => 'require|max:300',
    ];

    protected $message = [
        'title.require' => '帖子标题是必填项',
        'title.max' => '帖子标题最多不能超过25个字',
        'content.require' => '帖子内容是必填项',
        'content.max' => '帖子标题最多不能超过25个字',
    ];

    /**
     * @throws Throwable
     */
    public function verify(Request $request): void
    {
        throw_unless($this->check($request->all()), ApiBusinessException::class, $this->getError());
    }
}