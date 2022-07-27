<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\Handler as ExceptionHandler;
use App\Http\Routes\Router;

class App
{
    protected static DB $db;

    public function __construct(protected Router $router, protected array $request)
    {
        static::$db = new DB(config('db'));
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        set_exception_handler([ExceptionHandler::class, 'handle']);

        echo $this->router->resolve($this->request['uri'], $this->request['method']);
    }
}
