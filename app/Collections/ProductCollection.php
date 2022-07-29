<?php

declare(strict_types=1);

namespace App\Collections;

use App\Attributes\MapItemsIntoClass;
use App\Models\Category;
use App\Models\Product;

#[MapItemsIntoClass(Product::class)]
class ProductCollection extends Collection
{
    public function loadCategories(): self
    {
        $productIds = array_map(fn (Product $product) => $product->id, $this->items);

        $categories = Category::getAllWhereProductIdIn($productIds);

        foreach ($this->items as $product) {
            $product->categories = $categories->filter(fn (Category $category) => $category->product_id == $product->id);
        }

        return $this;
    }
}
