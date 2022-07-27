<?php

declare(strict_types=1);

namespace App\Exceptions;

use Throwable;

class Handler
{
    protected static array $dontReport = [
        MethodNotAllowedException::class,
        RouteNotFoundException::class,
    ];

    public static function handle(Throwable $e): void
    {
        static::logException($e);

        if (config('app.debug') === true) {
            throw $e;
        }

        // Render default error view
    }

    public static function logException(Throwable $e): void
    {
        if (! in_array($e::class, static::$dontReport)) {
            logger()->error($e);
        }
    }
}
