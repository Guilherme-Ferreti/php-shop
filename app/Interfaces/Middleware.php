<?php

declare(strict_types=1);

namespace App\Interfaces;

interface Middleware
{
    public function __invoke(): void;
}
