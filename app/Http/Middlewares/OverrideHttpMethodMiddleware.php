<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use App\Enums\HttpMethodEnum;
use App\Interfaces\Middleware;

class OverrideHttpMethodMiddleware implements Middleware
{
    public function __invoke(): void
    {
        if (isset($_POST['_METHOD']) && HttpMethodEnum::tryFrom($_POST['_METHOD'])) {
            $_SERVER['REQUEST_METHOD'] = $_POST['_METHOD'];
        }
    }
}
