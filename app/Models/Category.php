<?php

declare(strict_types=1);

namespace App\Models;

use App\App;
use App\Collections\CategoryCollection;

class Category extends Model
{
    public static function all(string $orderBy = 'id', string $orderDirection = 'asc'): CategoryCollection
    {
        $rows = App::db()->select("SELECT * FROM categories ORDER BY $orderBy $orderDirection");

        return new CategoryCollection($rows);
    }

    public static function getAllWhereProductIdIn(int|array $ids): CategoryCollection
    {
        $rows = App::db()->select('
            SELECT 
                categories.*,
                category_product.product_id AS product_id
            FROM
                categories
                    INNER JOIN
                    category_product ON categories.id = category_product.category_id
            WHERE 
                category_product.product_id IN (' . implode(', ', (array) $ids) . ')
        ');

        return new CategoryCollection($rows);
    }

    public function insert(): bool
    {
        $inserted = $this->db->query('INSERT INTO categories (name, code) VALUES (:name, :code)', [
            'name' => $this->name,
            'code' => $this->code,
        ]);

        if ($inserted) {
            $this->id = $this->db->lastInsertId();
        }

        return $inserted;
    }
}
