<?php

namespace support;

use Illuminate\Database\Events\QueryExecuted;
use Webman\Bootstrap;
use Workerman\Worker;

class Sql implements Bootstrap
{
    public static function start(?Worker $worker)
    {
        Db::connection()->listen(function (QueryExecuted $queryExecuted) {
            if (isset($queryExecuted->sql) && $queryExecuted->sql != "select 1") {
                dump("[{$queryExecuted->time}] ms {$queryExecuted->sql}");
            }
        });
    }

}