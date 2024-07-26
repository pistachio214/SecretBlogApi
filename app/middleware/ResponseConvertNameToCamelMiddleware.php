<?php

namespace app\middleware;

use app\dto\LengthAwarePaginatorDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use stdClass;
use support\Log;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class ResponseConvertNameToCamelMiddleware implements MiddlewareInterface
{
    public function process(Request $request, callable $handler): Response
    {
        $response = $handler($request);

        $body = json_decode($response->rawBody());

        // 转化下分页数据的格式
        $body_data = $this->convertToLengthAwarePaginator($body->data);

        if (isset($body_data) && !empty($body_data)) {
            Log::info("进来没: " . json_encode($body_data));
            $body->data = $this->convertToCamelCaseRecursive($body_data);

            $response->withBody(json_encode($body));
        }

        return $response;
    }

    private function convertToLengthAwarePaginator($variable): mixed
    {
        $target = unserialize($variable);

        if ($target instanceof LengthAwarePaginator) {
            return new LengthAwarePaginatorDto($target);
        }

        return json_decode(json_encode($target));

    }

    private function convertToCamelCaseRecursive($variable): stdClass|array
    {
        if (is_array($variable)) {
            $newArray = [];
            foreach ($variable as $key => $value) {
                $camelCaseKey = $this->toCamelCase($key);
                if (is_array($value) || is_object($value)) {
                    $newArray[$camelCaseKey] = $this->convertToCamelCaseRecursive($value);
                } else {
                    $newArray[$camelCaseKey] = $value;
                }
            }
            return $newArray;
        } elseif (is_object($variable)) {
            $newObject = new stdClass();
            foreach (get_object_vars($variable) as $key => $value) {
                $camelCaseKey = $this->toCamelCase($key);
                if (is_array($value) || is_object($value)) {
                    $newObject->$camelCaseKey = $this->convertToCamelCaseRecursive($value);
                } else {
                    $newObject->$camelCaseKey = $value;
                }
            }
            return $newObject;
        } else {
            // 如果不是数组或对象，直接返回原值
            return $variable;
        }
    }

    private function toCamelCase($str): string
    {
        // 将字符串从下划线分隔转换为小驼峰格式
        $parts = explode('_', $str);
        $camelCase = '';
        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $part = ucfirst($part);
            }
            $camelCase .= $part;
        }
        return $camelCase;
    }

}
