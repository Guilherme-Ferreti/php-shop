<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use FastRoute\RouteCollector;

/** @var RouteCollector $router */

$router->get('/', [HomeController::class, 'index']);
