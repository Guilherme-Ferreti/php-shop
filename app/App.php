<?php

declare(strict_types=1);

namespace App;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

class App
{
    public function __construct(protected array $request, protected Config $config)
    {
    }

    public function run(): void
    {
        $dispatcher = $this->registerRoutes();

        $routeInfo = $this->dispatch($dispatcher);

        $this->handleRouteResult($routeInfo);
    }

    private function registerRoutes(): Dispatcher
    {
        return \FastRoute\simpleDispatcher(function (RouteCollector $router) { 
            require_once __DIR__ . '/Http/Routes/web.php';
        });
    }

    private function dispatch(Dispatcher $dispatcher): array
    {
        $httpMethod = $this->request['method'];
        $uri = $this->request['uri'];

        if ($pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        return $dispatcher->dispatch($httpMethod, $uri);
    }

    private function handleRouteResult(array $routeInfo): void
    {
        match ($routeInfo[0]) {
            Dispatcher::NOT_FOUND => '',           // Throw Not Found Exception
            Dispatcher::METHOD_NOT_ALLOWED => '', // Throw Method Not Allowed Exception
            Dispatcher::FOUND => '',
        };
    }
}
