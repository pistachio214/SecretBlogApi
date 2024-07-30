<?php

namespace app\middleware;

use ReflectionClass;
use ReflectionException;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class RequestValidateMiddleware implements MiddlewareInterface
{
    /**
     * 注意：在PHP 8.0及以上版本中，newInstance()已被弃用，应使用newInstanceWithoutConstructor()或new直接实例化
     * @throws ReflectionException
     */
    public function process(Request $request, callable $handler): Response
    {
        $controller = $request->controller;
        $action = $request->action;

        if ($controller != '' && $action != '') {
            $validateClassName = $this->buildValidateName($controller, $action);
            if ($validateClassName != '' && class_exists($validateClassName)) {
                // 获取类的反射对象  
                $reflectionClass = new ReflectionClass($validateClassName);

                // 如果类有构造函数且需要参数，则可能需要手动处理或使用newInstanceArgs()
                $reflectionClass->newInstanceArgs([
                    $request
                ]);
            }
        }

        return $handler($request);
    }

    private function buildValidateName(string $controller, string $action): string
    {
        $position = strpos($controller, "controller");
        if ($position !== false) {
            $validatePath = substr($controller, 0, $position) . "validate\\";
        } else {
            return "";
        }

        $controllerSuffix = config('app.controller_suffix');
        $controllerExplode = explode("\\", $controller);
        $controllerName = last($controllerExplode);
        if (!str_contains($controllerName, $controllerSuffix)) {
            return "";
        }
        $controllerName = str_replace($controllerSuffix, '', $controllerName);

        $validateValidateFolder = config('app.validate_folder');

        return $validatePath . ucfirst($controllerName) . ucfirst($action) . ucfirst($validateValidateFolder);
    }

}
