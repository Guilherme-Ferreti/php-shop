<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use App\Exceptions\BadRequestException;
use App\Helpers\CsrfToken;

class CsrfMiddleware
{
    public function __invoke(): void
    {
        $token = $_POST[CsrfToken::INPUT_NAME] ?? null;

        if (! $token || ! CsrfToken::validate($token)) {
            // throw new BadRequestException('Invalid CSRF Token provided.');
        }

        CsrfToken::clear();
    }
}
