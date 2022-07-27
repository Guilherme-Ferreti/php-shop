<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;

class HomeController
{
    public function index(): View
    {
        return View::make('dashboard.html');
    }
}
