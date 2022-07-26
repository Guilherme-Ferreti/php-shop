<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class Handler
{
    public static function handle(Exception $e): void
    {
        // Log exception

        // Render default error view
    }
}
