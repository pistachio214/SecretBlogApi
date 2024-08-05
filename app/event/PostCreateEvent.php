<?php

namespace app\event;

use app\model\PostAccompanyPartnerModel;
use app\model\PostModel;
use DI\Attribute\Inject;

class PostCreateEvent
{

    #[Inject]
    protected PostAccompanyPartnerModel $postAccompanyPartnerModel;

    public function createFollowUpWork(PostModel $postModel): void
    {
        if ($postModel->post_type == 4) {
            $postAccompanyPartnerModel = $this->postAccompanyPartnerModel->newInstance();

            $postAccompanyPartnerModel->user_id = $postModel->user_id;
            $postAccompanyPartnerModel->post_id = $postModel->id;
            $postAccompanyPartnerModel->organizer = 1;

            $postAccompanyPartnerModel->save();
        }
    }
}