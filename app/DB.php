<?php

declare(strict_types=1);

namespace App;

use PDO;

class DB
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        $defaultOptions = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ];

        $this->pdo = new PDO(
            $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
            $config['user'],
            $config['pass'],
            $config['options'] ?? $defaultOptions
        );
    }

    public function select(string $query, array $parameters = []): array
    {
        $statement = $this->pdo->prepare($query);

        return $statement->execute($parameters)
            ? $statement->fetchAll()
            : [];
    }

    public function query(string $query, array $parameters = []): bool
    {
        return $this->pdo->prepare($query)?->execute($parameters);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }
}
