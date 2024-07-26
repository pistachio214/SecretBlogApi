<?php

namespace app\service;

use Illuminate\Database\Eloquent\Collection;

interface AppMainService
{
    public function mainDynamicBannerList(): Collection;

    public function deleteBanner(string $id): void;
}