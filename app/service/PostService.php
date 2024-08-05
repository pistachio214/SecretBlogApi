<?php

namespace app\service;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use support\Request;

interface PostService
{
    public function createPost(Request $request): void;

    public function createSelfiePost(Request $request): void;

    public function createAccompanyPost(Request $request): void;

    public function createTopView(Request $request): void;

    public function postDetail(string $id): ?Model;

    public function createPostReplyMessage(Request $request): void;

    public function postReplyMessage(string $postId, string $parentId): LengthAwarePaginator;

    public function postLike(string $postId): void;

}