<?php

namespace app\utils;

use  support\Response;

class R
{

    public static function success(mixed $data = null, int $code = 200, string $message = 'Successful'): Response
    {
        return json([
            'code' => $code,
            'message' => $message,
            'data' => $data != null ? serialize($data) : null
        ]);
    }

    public static function error(string $message = 'Failure', int $code = 500, mixed $data = null): Response
    {
        return json([
            'code' => $code,
            'message' => $message,
            'data' => $data != null ? serialize($data) : null
        ]);
    }
}