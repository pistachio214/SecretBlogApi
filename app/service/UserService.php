<?php

namespace app\service;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use support\Request;

interface UserService
{
    public function register(Request $request): void;

    public function getMineInfo(): ?Model;

    public function getMineInfoByUserId(string $userId): ?Model;

    public function getMineProfile(): LengthAwarePaginator;

    public function getMineProfileByUserId(string $userId): LengthAwarePaginator;

    public function getMineDynamic(): LengthAwarePaginator;

    public function getMineDynamicByUserId(string $userId): LengthAwarePaginator;

    public function editMine(Request $request): void;

    public function followAction(string $userId): void;

    public function unFollowAction(string $userId): void;
}