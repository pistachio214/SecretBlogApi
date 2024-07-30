<?php

namespace app\exception\handler;

use app\exception\ApiBusinessException;
use app\utils\R;
use support\Log;
use Throwable;
use Webman\Exception\ExceptionHandlerInterface;
use Webman\Http\Request;
use Webman\Http\Response;

class ApiExceptionHandler implements ExceptionHandlerInterface
{
    public function report(Throwable $exception)
    {
        if ($exception instanceof ApiBusinessException) {
            $original = $exception->getOriginalMessage();
            if ($original != null) {
                Log::error($original);
            }
        } else {
            Log::warning($exception->getMessage());
        }

    }

    public function render(Request $request, Throwable $exception): Response
    {
        if ($exception instanceof ApiBusinessException) {
            return R::error($exception->getMessage());
        }

        return R::error('错误信息');
    }


}