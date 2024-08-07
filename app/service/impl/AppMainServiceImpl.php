<?php

namespace app\service\impl;

use app\exception\ApiBusinessException;
use app\model\AppBannerModel;
use app\model\HashtagsModel;
use app\model\PostAccompanyPartnerModel;
use app\model\PostHashtagsModel;
use app\model\PostModel;
use app\model\SysUserFollowModel;
use app\service\AppMainService;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use DI\Attribute\Inject;
use Throwable;
use Webman\Context;

class AppMainServiceImpl implements AppMainService
{
    #[Inject]
    protected AppBannerModel $appBannerModel;

    #[Inject]
    protected PostModel $postModel;

    #[Inject]
    protected PostHashtagsModel $postHashtagsModel;

    #[Inject]
    protected PostAccompanyPartnerModel $postAccompanyPartnerModel;

    #[Inject]
    protected SysUserFollowModel $sysUserFollowModel;

    #[Inject]
    protected HashtagsModel $hashtagsModel;

    public function mainDynamicRecommendBannerList(): Collection
    {
        return $this->appBannerModel->newQuery()
            ->select(['id', 'title', 'remarks', 'image', 'arguments', 'created_at'])
            ->where(['type' => 1])
            ->orderByDesc('created_at')
            ->get();
    }

    public function mainDynamicRecommendPostList(string $keyword = null): LengthAwarePaginator
    {
        return $this->postList(['keyword' => $keyword]);
    }

    public function mainDynamicFollowPostList(string $keyword = null): LengthAwarePaginator
    {
        $userContext = Context::get('user');

        $userIds = $this->sysUserFollowModel->newQuery()
            ->where(['user_id' => $userContext->id])
            ->pluck("follow_user_id")
            ->toArray();

        return $this->postList(['keyword' => $keyword], $userIds);
    }

    public function mainDynamicSelfiePostList(string $keyword = null): LengthAwarePaginator
    {
        $search = ['keyword' => $keyword, 'post_type' => 2];

        return $this->postList($search);
    }

    private function postList(array $search = [], array $userIds = [], array $postIds = []): LengthAwarePaginator
    {
        return $this->postModel->newQuery()
            ->when(isset($search['keyword']) && !empty($search['keyword']), function ($query) use ($search) {
                $keyword = $search['keyword'];
                return $query->where('content', 'like', "%$keyword%");
            })
            ->when(isset($search['post_type']) && !empty($search['post_type']), function ($query) use ($search) {
                $postType = $search['post_type'];
                return $query->where(['post_type' => $postType]);
            })
            ->when(count($userIds) > 0, function ($query) use ($userIds) {
                return $query->whereIn('user_id', $userIds);
            })
            ->when(count($postIds) > 0, function ($query) use ($postIds) {
                return $query->whereIn('id', $postIds);
            })
            ->where(['status' => 1])
            ->with([
                'users' => function ($query) {
                    $query->select('id', 'nickname', 'avatar')
                        ->with([
                            'userExtend' => function ($q) {
                                $q->select('user_id', 'signature');
                            }
                        ]);
                },
                'files' => function ($query) {
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

    public function mainDiscoveryTopTagList(): Collection
    {
        return $this->hashtagsModel->newQuery()
            ->get(['id', 'name', 'image', 'description', 'created_at']);
    }

    public function mainDiscoveryTagList(): Collection
    {
        return $this->hashtagsModel->newQuery()
            ->where('description', '!=', '')
            ->get(['id', 'name', 'image', 'description', 'created_at']);
    }

    public function mainDiscoveryPostListByTag(string $tagId, string $keyword = null): LengthAwarePaginator
    {
        $postIds = $this->postHashtagsModel->newQuery()
            ->where(['hashtags_id' => $tagId])
            ->pluck("post_id")
            ->toArray();

        return $this->postList(['keyword' => $keyword], [], $postIds);
    }

    public function mainDiscoveryPostListByAccompany(string $keyword = null): LengthAwarePaginator
    {
        $search = ['keyword' => $keyword, 'post_type' => 4];

        return $this->postList($search);
    }

    /**
     * @throws Throwable
     */
    public function mainDiscoveryJoinAccompany(string $id): void
    {
        $userContext = Context::get('user');

        $exists = $this->postAccompanyPartnerModel->newQuery()
            ->where([
                'user_id' => $userContext->id,
                'post_id' => $id
            ])
            ->exists();

        throw_if($exists, ApiBusinessException::class, '您已加入该约伴活动,请勿重复加入');

        $postAccompanyPartnerModel = $this->postAccompanyPartnerModel->newInstance();

        $postAccompanyPartnerModel->user_id = $userContext->id;
        $postAccompanyPartnerModel->post_id = $id;

        $postAccompanyPartnerModel->save();
    }

    public function mainDiscoveryUserListByAccompany(string $id): Collection
    {
        return $this->postAccompanyPartnerModel->newQuery()
            ->where('post_id', $id)
            ->with([
                'users' => function ($query) {
                    $query->select(['id', 'nickname', 'avatar']);
                }
            ])
            ->select(['id', 'user_id', 'organizer'])
            ->get();
    }

    public function mainDiscoveryPostListByTopView(string $keyword = null): LengthAwarePaginator
    {
        $search = ['keyword' => $keyword, 'post_type' => 5];

        return $this->postList($search);
    }


}