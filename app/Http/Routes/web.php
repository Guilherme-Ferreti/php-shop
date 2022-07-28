<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Middlewares\CsrfMiddleware;
use FastRoute\RouteCollector;

/** @var RouteCollector $router */

$router->get('/', [HomeController::class, 'index']);

$router->get('/categories', [CategoryController::class, 'index']);

$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/create', [ProductController::class, 'create']);
$router->post('/products', ['controller' => [ProductController::class, 'store'], 'middlewares' => [CsrfMiddleware::class]]);
