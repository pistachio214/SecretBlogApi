<?php

namespace app\model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostFilesModel extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_files';
}
