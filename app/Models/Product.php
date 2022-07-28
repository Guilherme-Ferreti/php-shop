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

    public static function create(array $attributes): self
    {
        $product = new Self($attributes);

        App::db()->beginTransaction();

        $product->save();

        App::db()->commit();

        return $product;
    }

    public function save(): bool
    {
        $saved = $this->db->query(
            'INSERT INTO products (name, sku, price, quantity, description) 
                VALUES (:name, :sku, :price, :quantity, :description)', 
            [
                'name'        => $this->name,
                'sku'         => $this->sku,
                'price'       => $this->price * 100,
                'quantity'    => $this->quantity,
                'description' => $this->description,
            ]
        );

        if ($saved) {
            $this->id = $this->db->lastInsertId();
        }

        return $saved;
    }

    public function price(): float
    {
        return $this->price / 100;
    }
}
