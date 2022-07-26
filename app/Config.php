<?php

declare(strict_types=1);

namespace App;

class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host'     => $env['DB_HOST'],
                'port'     => $env['DB_PORT'],
                'user'     => $env['DB_USERNAME'],
                'pass'     => $env['DB_PASSWORD'],
                'database' => $env['DB_DATABASE'],
                'driver'   => $env['DB_DRIVER'] ?? 'mysql',
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}
