<?php

declare(strict_types=1);

namespace App\Validators\Rules;

use Rakit\Validation\Rule;

class UniqueArrayValues extends Rule
{
    public string $ruleName = 'unique_array_values';

    protected $message = 'The field :attribute must contain only unique values.';

    public function check($array): bool
    {
        $unique = array_unique($array);

        return count($unique) == count($array);
    }
}
