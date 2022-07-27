<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class Handler
{
    protected static array $dontReport = [
        MethodNotAllowedException::class,
        RouteNotFoundException::class,
    ];

    public static function handle(Exception $e): void
    {
        static::logException($e);

        if (config('app.debug') === true) {
            throw $e;
        }

        // Render default error view
    }

    public static function logException(Exception $e): void
    {
        if (! in_array($e::class, static::$dontReport)) {
            logger()->error($e);
        }
    }
}
