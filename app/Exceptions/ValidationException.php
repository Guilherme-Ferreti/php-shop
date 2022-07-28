<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Helpers\Session;
use App\Validators\Validator;

class ValidationException extends \Exception
{
    protected $message = 'The provided inputs are invalid.';

    protected $code = 422;

    public function __construct(private Validator $validator, public string $redirectTo)
    {
        $this->flashErrorBagAndValidatedInputs();
    }

    private function flashErrorBagAndValidatedInputs(): void
    {
        $data = [
            'error_bag' => $this->validator->errors(),
            ...$this->validator->getValidatedData(),
        ];

        foreach ($data as $key => $value) {
            Session::setFlash($key, $value);
        }
    }
}
