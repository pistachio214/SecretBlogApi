<?php

namespace app\service\impl;

use app\model\AppBannerModel;
use app\model\PostModel;
use app\model\SysUserFollowModel;
use app\service\AppMainService;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use DI\Attribute\Inject;
use Webman\Context;

class AppMainServiceImpl implements AppMainService
{
    #[Inject]
    protected AppBannerModel $appBannerModel;

    #[Inject]
    protected PostModel $postModel;

    #[Inject]
    protected SysUserFollowModel $sysUserFollowModel;

    public function mainDynamicRecommendBannerList(): Collection
    {
        return $this->appBannerModel->newQuery()
            ->where(['type' => 1])
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'remarks', 'image', 'arguments', 'created_at']);
    }

    public function mainDynamicRecommendPostList(string $title = null): LengthAwarePaginator
    {
        return $this->postList($title);
    }

    public function mainDynamicFollowPostList(string $title = null): LengthAwarePaginator
    {
        $userContext = Context::get('user');

        $userIds = $this->sysUserFollowModel->newQuery()
            ->where(['user_id' => $userContext->id])
            ->pluck("follow_user_id")
            ->toArray();

        return $this->postList($title, $userIds);
    }

    private function postList(string $title = null, array $userIds = []): LengthAwarePaginator
    {
        $sevenDaysAgo = Carbon::now(config('app.default_timezone'))->subDay(7);

        return $this->postModel->newQuery()
            ->when(!empty($title), function ($query) use ($title) {
                return $query->where('title', 'like', "%$title%");
            })
            ->when(count($userIds) > 0, function ($query) use ($userIds) {
                return $query->whereIn('user_id', $userIds);
            })
            ->where(['status' => 1])
            ->where('created_at', '>=', $sevenDaysAgo)
            ->with([
                'users' => function ($query) {
                    $query->select('id', 'nickname', 'avatar')
                        ->with([
                            'userExtend' => function ($q) {
                                $q->select('user_id', 'signature');
                            }
                        ]);
                },
                'images' => function ($query) {
                    $query->where('type', 1)->select('post_id', 'url')
                        ->orderBy('created_at');
                },
                'tags' => function ($query) {
                    $query->select('name');
                }
            ])
            ->orderByDesc('hot_num')
            ->orderByDesc('review_num')
            ->orderByDesc('like_num')
            ->orderByDesc('created_at')
            ->paginate(15);
    }


}