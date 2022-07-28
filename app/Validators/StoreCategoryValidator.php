<?php

declare(strict_types=1);

namespace App\Validators;

class StoreCategoryValidator extends Validator
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'code' => 'required|max:255|unique:categories,code',
        ];
    }
}
