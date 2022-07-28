<?php

declare(strict_types=1);

namespace App\Validators;

class StoreProductValidator extends Validator
{
    public function rules(): array
    {
        return [
            'name'         => 'required|max:255',
            'sku'          => 'required|max:255|unique:products,sku',
            'price'        => 'required|numeric',
            'quantity'     => 'required|integer|min:1',
            'description'  => 'nullable|max:255',
            'categories'   => 'nullable|array|unique_array_values',
            'categories.*' => 'integer|exists:categories,id',
        ];
    }
}
