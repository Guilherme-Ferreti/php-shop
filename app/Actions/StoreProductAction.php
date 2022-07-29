<?php

declare(strict_types=1);

namespace App\Actions;

use App\App;
use App\Models\Product;

class StoreProductAction
{
    public function __invoke(array $attributes): Product|false
    {
        App::db()->beginTransaction();

        $attributes['price'] = $attributes['price'] * 100;

        $product = new Product($attributes);

        if (! $product->insert()) {
            return false;
        }

        $product->syncCategories($attributes['categories']);

        App::db()->commit();

        return $product;
    }
}
