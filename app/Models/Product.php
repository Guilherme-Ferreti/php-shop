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

    public static function find(int $id): ?self
    {
        $rows = App::db()->select('SELECT * FROM products WHERE id = :id', [
            'id' => $id,
        ]);

        if (count($rows) < 1) {
            return null;
        }

        return new self($rows[0]);
    }

    public function insert(): bool
    {
        $inserted = $this->db->query(
            'INSERT INTO products (name, sku, price, quantity, description) 
                VALUES (:name, :sku, :price, :quantity, :description)',
            [
                'name'        => $this->name,
                'sku'         => $this->sku,
                'price'       => $this->price,
                'quantity'    => $this->quantity,
                'description' => $this->description,
            ]
        );

        if ($inserted) {
            $this->id = $this->db->lastInsertId();
        }

        return $inserted;
    }

    public function update(): bool
    {
        return $this->db->query(
            '
            UPDATE products SET 
                name = :name, 
                sku = :sku,
                price = :price,
                quantity = :quantity,
                description = :description,
                updated_at = :updated_at 
            WHERE
                id = :id',
            [
                'id'          => $this->id,
                'sku'         => $this->sku,
                'name'        => $this->name,
                'price'       => $this->price,
                'quantity'    => $this->quantity,
                'description' => $this->description,
                'updated_at'  => now(),
            ]
        );
    }

    public function delete(): bool
    {
        return $this->db->query('DELETE FROM products WHERE id = :id', [
            'id' => $this->id,
        ]);
    }

    public function loadCategories(): self
    {
        $this->categories = Category::getAllWhereProductIdIn($this->id);

        return $this;
    }

    public function syncCategories(array $categoriesIds): bool
    {
        $this->db->query('DELETE FROM category_product WHERE product_id = :id', [':id' => $this->id]);

        $query = 'INSERT INTO category_product (category_id, product_id) VALUES ';

        foreach ($categoriesIds as $categoryId) {
            $query .= "($categoryId, {$this->id}),";
        }

        $query = rtrim($query, ',');

        return $this->db->query($query);
    }

    public function price(): float
    {
        return $this->price / 100;
    }
}
