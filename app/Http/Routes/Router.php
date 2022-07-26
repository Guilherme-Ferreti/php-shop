<?php

declare(strict_types=1);

namespace App\Http\Routes;

use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

class Router
{
    public function resolve(string $requestUri, string $requestMethod)
    {
        $requestUri = rawurldecode(explode('?', $requestUri)[0]);

        $result = $this->registerRoutes()->dispatch($requestMethod, $requestUri);

        return $this->handleRouteResult($result);
    }

    private function registerRoutes(): Dispatcher
    {
        return \FastRoute\simpleDispatcher(function (RouteCollector $router) { 
            require_once __DIR__ . '/web.php';
        });
    }

    private function handleRouteResult(array $routeInfo)
    {
        if ($routeInfo[0] === Dispatcher::METHOD_NOT_ALLOWED) {
            throw new MethodNotAllowedException();
        }

        if ($routeInfo[0] === Dispatcher::FOUND) {
            $class  = $routeInfo[1][0];
            $method = $routeInfo[1][1];

            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new RouteNotFoundException();
    }
}
