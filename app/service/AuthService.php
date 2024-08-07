<?php

namespace app\service;

use support\Request;

interface AuthService
{
    public function login(Request $request): array;

    public function refreshToken(): array;

    public function logout(): void;
}