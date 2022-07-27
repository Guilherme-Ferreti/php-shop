<?php

declare(strict_types=1);

namespace App\Collections;

use App\Attributes\MapItemsIntoClass;
use ReflectionClass;

abstract class Collection implements \IteratorAggregate
{
    private array $items = [];

    public function __construct(array $items = [])
    {
        if (count($items)) {
            $items = $this->resolveCustomItemMap($items);
        }

        $this->items = $items;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    private function resolveCustomItemMap(array $items): array
    {
        $reflectionClass = new ReflectionClass(static::class);

        $reflectionAttributes = $reflectionClass->getAttributes(MapItemsIntoClass::class);

        if (! count($reflectionAttributes) < 1) {
            return $items;
        }

        return $reflectionAttributes[0]->newInstance()->mapItems($items);
    }
}
