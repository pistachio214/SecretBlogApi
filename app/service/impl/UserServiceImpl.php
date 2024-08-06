<?php

namespace app\service\impl;

use app\exception\ApiBusinessException;
use app\model\PostFilesModel;
use app\model\PostModel;
use app\model\SysUserExtendModel;
use app\model\SysUserFollowModel;
use app\model\SysUserModel;
use app\service\PostService;
use app\service\UserService;
use DI\Attribute\Inject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use support\Db;
use support\Request;
use Throwable;
use Webman\Context;

class UserServiceImpl implements UserService
{
    #[Inject]
    protected SysUserModel $sysUserModel;

    #[Inject]
    protected SysUserExtendModel $sysUserExtendModel;

    #[Inject]
    protected SysUserFollowModel $sysUserFollowModel;

    #[Inject]
    protected PostModel $postModel;

    #[Inject]
    protected PostFilesModel $postFilesModel;

    public function getMineInfo(): ?Model
    {
        $userContext = Context::get("user");

        return $this->findSysUserInfo($userContext->id);
    }

    public function getMineInfoByUserId(string $userId): ?Model
    {
        return $this->findSysUserInfo($userId);
    }

    public function getMineProfile(): LengthAwarePaginator
    {
        $userContext = Context::get("user");

        return $this->findSysUserProfile($userContext->id);
    }

    public function getMineProfileByUserId(string $userId): LengthAwarePaginator
    {
        return $this->findSysUserProfile($userId);
    }

    public function getMineDynamic(): LengthAwarePaginator
    {
        $userContext = Context::get("user");

        return $this->findSysUserDynamic($userContext->id);
    }

    public function getMineDynamicByUserId(string $userId): LengthAwarePaginator
    {
        return $this->findSysUserDynamic($userId);
    }

    private function findSysUserDynamic(string $userId): LengthAwarePaginator
    {
        return $this->postModel->newQuery()
            ->where(['user_id' => $userId, 'status' => 1])
            ->select(['id', 'title', 'content', 'post_type', 'created_at'])
            ->with([
                'files' => function ($query) {
                    $query->where('type', 1)->select('post_id', 'url')
                        ->orderBy('created_at')->limit(1);
                },
            ])
            ->paginate(15);
    }

    private function findSysUserProfile(string $userId): LengthAwarePaginator
    {
        return $this->postFilesModel->newQuery()
            ->leftJoin('post', 'post.id', '=', 'post_files.post_id')
            ->where([
                'post.user_id' => $userId,
                'post.status' => 1,
            ])
            ->select(['post_files.id', 'post_files.url', 'post_files.type', 'post_files.created_at'])
            ->paginate(15);
    }

    private function findSysUserInfo(string $userId): ?Model
    {
        return $this->sysUserModel->newQuery()
            ->where(['id' => $userId, 'type' => 2, 'status' => 1])
            ->select(['id', 'nickname', 'avatar'])
            ->addSelect([
                DB::raw(
                    '(select count(*) from `post` where `user_id` = ' . $userId . ') as dynamic_number'
                ),
                DB::raw(
                    '(select sum(`like_num`) from `post` where `user_id` = ' . $userId . ') as like_number'
                ),
                DB::raw(
                    '(select count(*) from `sys_user_follow` where `follow_user_id` = ' . $userId . ') as fans_number'
                )
            ])
            ->with([
                'userExtend' => function ($query) {
                    $query->select(['user_id', 'sex', 'signature', 'bg_image', 'hobby']);
                }
            ])
            ->first();
    }

    /**
     * @throws Throwable
     */
    public function editMine(Request $request): void
    {
        $userContext = Context::get('user');

        $sysUserModel = $this->sysUserModel->newQuery()
            ->where(['id' => $userContext->id, 'type' => 2, 'status' => 1])
            ->first();

        throw_unless($sysUserModel, ApiBusinessException::class, '用户不存在');

        Db::beginTransaction();
        try {
            $sysUserModel->nickname = $request->input('nickname');
            $sysUserModel->avatar = $request->input('avatar');

            $sysUserModel->save();

            $hobby = $request->input('hobby', []);

            $this->sysUserExtendModel->newQuery()
                ->updateOrCreate([
                    'user_id' => $userContext->id
                ], [
                    'sex' => $request->input('sex', 2),
                    'signature' => $request->input('signature', ''),
                    'bg_image' => $request->input('bg_image', null),
                    'hobby' => json_encode($hobby)
                ]);

            Db::commit();
        } catch (Throwable $exception) {
            Db::rollBack();
            throw new ApiBusinessException("更新失败!", $exception->getMessage());
        }
    }

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