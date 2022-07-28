<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Interfaces\RenderableException;
use App\View\View;

class Handler
{
    protected static array $dontReport = [
        BadRequestException::class,
        MethodNotAllowedException::class,
        RouteNotFoundException::class,
        ValidationException::class,
    ];

    public static function handle(\Throwable $e): void
    {
        static::logException($e);

        if ($e instanceof ValidationException) {
            header("Location: $e->redirectTo");

            exit();
        }

        http_response_code(is_http_status_code($e->getCode()) ? $e->getCode() : 500);

        echo $e instanceof RenderableException
            ? $e->render()
            : View::make('errors/500.html');
    }

    public static function logException(\Throwable $e): void
    {
        if (! in_array($e::class, static::$dontReport)) {
            logger()->error($e);
        }
    }
}
