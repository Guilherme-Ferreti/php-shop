<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\Handler as ExceptionHandler;
use App\Http\Routes\Router;

class App
{
    public function __construct(
        protected Router $router, 
        protected array $request,
    ) {}

    public function run(): void
    {
        set_exception_handler([ExceptionHandler::class , 'handle']);

        echo $this->router->resolve($this->request['uri'], $this->request['method']);
    }
}
