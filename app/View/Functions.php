<?php

declare(strict_types=1);

namespace App\View;

use App\Helpers\CsrfToken;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class Functions extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('create_csrf_token', [CsrfToken::class, 'create']),
        ];
    }
}
