<?php

use app\event\PostCreateEvent;

return [
    'post.create.follow.up.work.event' => [PostCreateEvent::class, 'createFollowUpWork'],
];
