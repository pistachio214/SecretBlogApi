<?php

namespace app\service\impl;

use app\model\AppBannerModel;
use app\model\PostModel;
use app\service\AppMainService;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use DI\Attribute\Inject;

class AppMainServiceImpl implements AppMainService
{
    #[Inject]
    protected AppBannerModel $appBannerModel;

    #[Inject]
    protected PostModel $postModel;

    public function mainDynamicBannerList(): Collection
    {
        return $this->appBannerModel->newQuery()
            ->where(['type' => 1])
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'remarks', 'image', 'arguments', 'created_at']);
    }

    public function mainDynamicPostList(string $title = null): LengthAwarePaginator
    {
        return $this->postModel->newQuery()
            ->when($title, function ($query) use ($title) {
                return $query->where('title', 'like', "%$title%");
            })
            ->with([
                'users' => function ($query) {
                    $query->select('id', 'nickname', 'avatar')
                        ->with(['userExtend' => function ($q) {
                            $q->select('user_id', 'signature');
                        }]);
                },
                'images' => function ($query) {
                    $query->where('type', 1)->select('post_id', 'url')->orderBy('created_at');
                }
            ])
            ->orderByDesc('created_at')
            ->paginate(15);
    }


}