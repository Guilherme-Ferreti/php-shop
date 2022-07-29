<?php

declare(strict_types=1);

namespace App\Actions;

use App\App;
use App\Models\Product;

class UpdateProductAction
{
    public function __invoke(Product $product, array $attributes): Product|false
    {
        App::db()->beginTransaction();

        $attributes['price'] = $attributes['price'] * 100;

        if (! $product->setAttributes($attributes)->update()) {
            return false;
        }

        $product->syncCategories($attributes['categories']);

        App::db()->commit();

        return $product;
    }
}
