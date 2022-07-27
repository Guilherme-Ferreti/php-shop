<?php

declare(strict_types=1);

namespace App\Attributes;

#[\Attribute]
class MapItemsIntoClass
{
    public function __construct(protected string $classname)
    {
    }

    public function mapItems(array $items): array
    {
        $classname = $this->classname;

        return array_map(fn (array $item) => new $classname($item), $items);
    }
}
