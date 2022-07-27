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
}
