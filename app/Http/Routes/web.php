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
$router->get('/categories/create', [CategoryController::class, 'create']);
$router->get('/categories/{id:\d+}/edit', [CategoryController::class, 'edit']);
$router->post('/categories', ['controller' => [CategoryController::class, 'store'], 'middlewares' => [CsrfMiddleware::class]]);
$router->put('/categories/{id:\d+}', ['controller' => [CategoryController::class, 'update'], 'middlewares' => [CsrfMiddleware::class]]);
$router->delete('/categories/{id:\d+}', ['controller' => [CategoryController::class, 'destroy'], 'middlewares' => [CsrfMiddleware::class]]);

$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/create', [ProductController::class, 'create']);
$router->get('/products/{id:\d+}/edit', [ProductController::class, 'edit']);
$router->post('/products', ['controller' => [ProductController::class, 'store'], 'middlewares' => [CsrfMiddleware::class]]);
$router->put('/products/{id:\d+}', ['controller' => [ProductController::class, 'update'], 'middlewares' => [CsrfMiddleware::class]]);
$router->delete('/products/{id:\d+}', ['controller' => [ProductController::class, 'destroy'], 'middlewares' => [CsrfMiddleware::class]]);
