<?php

declare(strict_types=1);

namespace App\Collections;

use App\Attributes\MapItemsIntoClass;
use App\Models\Product;

#[MapItemsIntoClass(Product::class)]
class ProductCollection extends Collection
{
}
