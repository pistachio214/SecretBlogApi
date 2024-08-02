<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 帖子模型
 */
class PostModel extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';

    /**
     * 关联用户模型
     * @return HasOne
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-26 15:00:01
     */
    public function users(): HasOne
    {
        return $this->hasOne(SysUserModel::class, 'id', 'user_id');
    }

    /**
     * 关联附件模型
     * @return HasMany
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-26 20:02:31
     */
    public function images(): HasMany
    {
        return $this->hasMany(PostFilesModel::class, 'post_id', 'id');
    }

    /**
     * 关联话题模型
     * @return BelongsToMany
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-08-02 10:55:35
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(HashtagsModel::class, 'post_hashtags', 'post_id', 'hashtags_id');
    }
}
