<?php

declare(strict_types=1);

namespace App\Models;

use App\App;
use App\Collections\ProductCollection;

class Product extends Model
{
    public static function randomOrder(int $limit = 15): ProductCollection
    {
        $rows = App::db()->select('SELECT * FROM products ORDER BY RAND() LIMIT :limit', [
            ':limit' => $limit,
        ]);

        return new ProductCollection($rows);
    }

    public static function count(): int
    {
        $rows = App::db()->select('SELECT COUNT(id) as count FROM products');

        return $rows[0]['count'];
    }

    public static function all(string $orderBy = 'id', string $orderDirection = 'asc'): ProductCollection
    {
        $rows = App::db()->select("SELECT * FROM products ORDER BY $orderBy $orderDirection");

        return new ProductCollection($rows);
    }

    public function price(): float
    {
        return $this->price / 100;
    }
}
