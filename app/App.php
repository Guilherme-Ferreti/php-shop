<?php

declare(strict_types=1);

namespace App;

use App\Http\Routes\Router;

class App
{
    public function __construct(
        protected Router $router, 
        protected array $request, 
        protected Config $config
    ) {}

    public function run(): void
    {
        echo $this->router->resolve($this->request['uri'], $this->request['method']);
    }
}
