<?php

declare(strict_types=1);

namespace App\Http\Routes;

use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;
use App\Http\Middlewares\SessionMiddleware;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

class Router
{
    protected array $middlewares = [
        SessionMiddleware::class,
    ];

    public function resolve(string $requestUri, string $requestMethod)
    {
        $this->runMiddlewares($this->middlewares);

        $requestUri = rawurldecode(explode('?', $requestUri)[0]);

        $result = $this->registerRoutes()->dispatch($requestMethod, $requestUri);

        return $this->handleRouteResult($result);
    }

    private function runMiddlewares(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            $class = new $middleware();

            call_user_func($class);
        }
    }

    private function registerRoutes(): Dispatcher
    {
        return \FastRoute\simpleDispatcher(function (RouteCollector $router) {
            require_once config('routes.path');
        });
    }

    private function handleRouteResult(array $routeInfo)
    {
        if ($routeInfo[0] === Dispatcher::METHOD_NOT_ALLOWED) {
            throw new MethodNotAllowedException();
        }

        if ($routeInfo[0] === Dispatcher::FOUND) {
            [$class, $method, $middlewares] = $this->parseRouteInfo($routeInfo[1]);

            if (class_exists($class)) {
                $class = new $class();

                if (method_exists($class, $method)) {
                    $this->runMiddlewares($middlewares);

                    return call_user_func_array([$class, $method], []);
                }
            }
        }

        throw new RouteNotFoundException();
    }

    private function parseRouteInfo(array $routeInfo): array
    {
        if (isset($routeInfo['controller'])) {
            $class = $routeInfo['controller'][0] ?? '';
            $method = $routeInfo['controller'][1] ?? '';
            $middlewares = $routeInfo['middlewares'] ?? [];
        } else {
            $class = $routeInfo[0] ?? '';
            $method = $routeInfo[1] ?? '';
            $middlewares = [];
        }

        return [$class, $method, $middlewares];
    }
}
