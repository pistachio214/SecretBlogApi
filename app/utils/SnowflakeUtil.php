<?php

namespace app\utils;

use Godruoyi\Snowflake\Snowflake;

class SnowflakeUtil
{

    public static function getId(): string
    {
        $snowflake = new Snowflake(getenv('DATACENTER_ID'), getenv('WORKER_ID'));
        return $snowflake->id();
    }
}