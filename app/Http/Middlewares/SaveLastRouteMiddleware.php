<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use App\Helpers\Session;
use App\Interfaces\Middleware;

class SaveLastRouteMiddleware implements Middleware
{
    public const LAST_ROUTE_KEY = 'last_route';

    public const CURRENT_ROUTE_KEY = 'current_route';

    public function __invoke(): void
    {
        Session::set(self::LAST_ROUTE_KEY, Session::get(self::CURRENT_ROUTE_KEY, '/'));

        Session::set(self::CURRENT_ROUTE_KEY, $_SERVER['REQUEST_URI']);
    }
}
