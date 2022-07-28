<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\View\View;

interface RenderableException
{
    public function render(): View;
}
