<?php

declare(strict_types=1);

namespace App\Collections;

use App\Attributes\MapItemsIntoClass;

abstract class Collection implements \IteratorAggregate, \ArrayAccess
{
    protected array $items = [];

    public function __construct(array $items = [])
    {
        if (count($items) > 0) {
            $items = $this->resolveCustomItemMap($items);
        }

        $this->items = $items;
    }

    private function resolveCustomItemMap(array $items): array
    {
        $reflectionClass = new \ReflectionClass(static::class);

        $reflectionAttributes = $reflectionClass->getAttributes(MapItemsIntoClass::class);

        if (count($reflectionAttributes) < 1) {
            return $items;
        }

        return $reflectionAttributes[0]->newInstance()->mapItems($items);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public function filter(callable $callback): static
    {
        $filteredItems = [];

        foreach ($this->items as $item) {
            if ($callback($item)) {
                $filteredItems[] = $item;
            }
        }

        return new static($filteredItems);
    }

    public function pluck(string $key): GenericCollection
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $item->{$key};
        }

        return new GenericCollection($items);
    }

    public function implode(array|string $separator = ''): string
    {
        return implode($separator, $this->items);
    }

    public function all(): array
    {
        return $this->items;
    }
}
