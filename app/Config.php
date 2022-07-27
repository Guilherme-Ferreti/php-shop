<?php

declare(strict_types=1);

namespace App;

class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $root = dirname(__FILE__, 2);

        $this->config = [
            'app' => [
                'env'   => $env['APP_ENV'],
                'debug' => $env['APP_DEBUG'],
            ],

            'db' => [
                'host'     => $env['DB_HOST'],
                'port'     => $env['DB_PORT'],
                'user'     => $env['DB_USERNAME'],
                'pass'     => $env['DB_PASSWORD'],
                'database' => $env['DB_DATABASE'],
                'driver'   => $env['DB_DRIVER'] ?? 'mysql',
            ],

            'routes' => [
                'path' => "$root/app/Http/Routes/web.php",
            ],

            'logs' => [
                'path' => "$root/logs/",
            ],

            'view' => [
                'path' => "$root/views",
                
                'options' => [
                    'cache'            => "$root/cache/",
                    'auto_reload'      => true,
                    'strict_variables' => true,
                    'extension'        => '.html',
                ],
            ],
        ];
    }

    public function get(string $key): mixed
    {
        $config = $this->config;

        foreach (explode('.', $key) as $key) {
            $config = $config[$key] ?? null;

            if (! $config) {
                return null;
            }
        }

        return $config;
    }
}
