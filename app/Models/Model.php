<?php

declare(strict_types=1);

namespace App\Models;

use App\App;
use App\DB;

abstract class Model
{
    protected DB $db;

    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->db = App::db();

        $this->setAttributes($attributes);
    }

    public function setAttributes(array $attributes = [])
    {
        foreach ($attributes as $attribute => $value) {
            $this->{$attribute} = $value;
        }

        return $this;
    }

    public function __set($attribute, $value)
    {
        $method = 'set' . ucfirst($attribute) . 'Attribute';

        if (method_exists($this, $method)) {
            return $this->$method($value);
        }

        return $this->attributes[$attribute] = $value;
    }

    public function __get($attribute)
    {
        $method = 'get' . ucfirst($attribute) . 'Attribute';

        if (method_exists($this, $method)) {
            return $this->$method();
        }

        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        }
    }

    public function __isset(string $property): bool
    {
        return property_exists(static::class, $property)
            || isset($this->attributes[$property]);
    }
}
