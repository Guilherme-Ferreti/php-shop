<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Interfaces\RenderableException;
use App\View\View;

class RouteNotFoundException extends \Exception implements RenderableException
{
    protected $code = 404;

    protected $message = '404 Not Found';

    public function render(): View
    {
        return View::make('errors/404.html');
    }
}
