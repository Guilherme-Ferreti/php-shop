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

        return array_map(function (mixed $item) use ($classname) {
            if (is_array($item)) {
                return new $classname($item);
            }

            if ($item instanceof $classname) {
                return $item;
            }

            return $item;
        }, $items);
    }
}
