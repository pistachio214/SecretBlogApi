<?php

namespace app\middleware;

use app\exception\ApiBusinessException;
use Tinywan\Jwt\Exception\JwtTokenException;
use Tinywan\Jwt\JwtToken;
use Webman\Context;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class RequestApiAuthCheckMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        try {
            $token = JwtToken::verify();

            $extend = $token['extend'];
            $user = (object)[
                'id' => $extend['id'],
                'nickname' => $extend['nickname'],
                'username' => $extend['username'],
                'client' => $extend['client'],
            ];
            Context::set("user", $user);

            return $handler($request);
        } catch (JwtTokenException $jwtTokenException) {
            throw new ApiBusinessException($jwtTokenException->getMessage(), null, $jwtTokenException->getCode());
        }
    }

}
