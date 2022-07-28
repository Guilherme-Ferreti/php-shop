<?php

declare(strict_types=1);

namespace App\Validators;

class StoreProductValidator extends Validator
{
    protected const REDIRECT_TO = '/products/create';

    public function rules(): array
    {
        return [
            'name'        => 'required|max:255',
            'sku'         => 'required|max:255',
            'price'       => 'required|numeric',
            'quantity'    => 'required|integer',
            'description' => 'nullable|max:255',
            'categories'  => 'nullable|array',
        ];
    }
}
