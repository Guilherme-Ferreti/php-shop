<?php

namespace App\View;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class Functions extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('csrf_token', 'csrf_token'),
        ];
    }
}
