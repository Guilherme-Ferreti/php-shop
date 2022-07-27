<?php

declare(strict_types=1);

namespace App\Collections;

use App\Attributes\MapItemsIntoClass;
use App\Models\Category;

#[MapItemsIntoClass(Category::class)]
class CategoryCollection extends Collection
{
}
