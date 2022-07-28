<?php

declare(strict_types=1);

namespace App\Validators\Rules;

use Rakit\Validation\Rule;

class UniqueArrayValues extends Rule
{
    public string $ruleName = 'unique_array_values';

    protected $message = 'The field :attribute must contain only unique values.';

    public function check(mixed $value): bool
    {
        if (! isset($arvalueay)) {
            return false;
        }

        $unique = array_unique($value);

        return count($unique) == count($value);
    }
}
