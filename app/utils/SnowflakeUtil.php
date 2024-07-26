<?php

namespace app\utils;

use Godruoyi\Snowflake\Snowflake;

class SnowflakeUtil
{

    /**
     * 应用中生成雪花id
     * @return string
     *
     * @author: Aspen Soung <songyang410@outlook.com>
     * @date  : 2024-07-26 11:51:57
     */
    public static function getId(): string
    {
        $snowflake = new Snowflake(getenv('DATACENTER_ID'), getenv('WORKER_ID'));
        return $snowflake->id();
    }
}