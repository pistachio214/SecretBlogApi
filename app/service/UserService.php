<?php

namespace app\service;

interface UserService
{
    public function followAction(string $userId): void;

    public function unFollowAction(string $userId): void;
}