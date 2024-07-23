<?php

namespace app\service;

use support\Log;

class MailerService
{
    public function mail($email, $content): void
    {
        Log::info($email);
        Log::info($content);
    }
}