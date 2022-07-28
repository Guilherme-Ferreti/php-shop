<?php

declare(strict_types=1);

namespace App\Validators;

class StoreProductValidator extends Validator
{
    protected const REDIRECT_TO = '/products';

    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
}
