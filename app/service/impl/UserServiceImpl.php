<?php

namespace app\service\impl;

use app\exception\ApiBusinessException;
use app\model\SysUserFollowModel;
use app\model\SysUserModel;
use app\service\UserService;
use DI\Attribute\Inject;
use Throwable;
use Webman\Context;

class UserServiceImpl implements UserService
{
    #[Inject]
    protected SysUserModel $sysUserModel;

    #[Inject]
    protected SysUserFollowModel $sysUserFollowModel;

    /**
     * @throws Throwable
     */
    public function followAction(string $userId): void
    {
        $followExists = $this->sysUserModel->newQuery()
            ->where(['id' => $userId, 'type' => 2, 'status' => 1])
            ->exists();
        throw_unless($followExists, ApiBusinessException::class, '关注的用户不存在');

        $userContext = Context::get('user');
        $exists = $this->sysUserFollowModel->newQuery()
            ->where([
                'user_id' => $userContext->id,
                'follow_user_id' => $userId
            ])
            ->exists();

        throw_if($exists, ApiBusinessException::class, '该用户已关注,请勿重复关注');

        $sysUserFollowModel = $this->sysUserFollowModel->newInstance();
        $sysUserFollowModel->user_id = $userContext->id;
        $sysUserFollowModel->follow_user_id = $userId;

        $sysUserFollowModel->save();
    }

    /**
     * @throws Throwable
     */
    public function unFollowAction(string $userId): void
    {
        $userContext = Context::get('user');
        $exists = $this->sysUserFollowModel->newQuery()
            ->where([
                'user_id' => $userContext->id,
                'follow_user_id' => $userId
            ])
            ->exists();
        throw_unless($exists, ApiBusinessException::class, '您未关注该用户,请勿进行此操作');

        $this->sysUserFollowModel->newQuery()
            ->where([
                'user_id' => $userContext->id,
                'follow_user_id' => $userId
            ])
            ->delete();
    }


}