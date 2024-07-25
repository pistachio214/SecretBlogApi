<?php

namespace app\utils;

use  support\Response;

class R
{

    public static function SUCCESS(mixed $data = null, int $code = 200, string $message = 'Access successful'): Response
    {
        return json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function ERROR(string $message = 'Access failure', int $code = 500, mixed $data = null): Response
    {
        return json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}