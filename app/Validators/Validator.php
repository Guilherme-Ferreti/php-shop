<?php

declare(strict_types=1);

namespace App\Validators;

use App\Exceptions\ValidationException;
use App\Models\Model;
use Rakit\Validation\ErrorBag;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator as BaseValidator;

abstract class Validator
{
    protected const REDIRECT_TO = '/';

    protected Validation $validation;

    protected Model $model;

    public function ignore(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function validate(array $inputs): array
    {
        $validator = new BaseValidator();

        $this->addCustomRules($validator);

        $this->validation = $validator->make($this->sanitize($inputs), $this->rules());

        $this->validation->setAliases($this->aliases());
        $this->validation->setMessages($this->messages());

        $this->validation->validate();

        if ($this->validation->fails()) {
            throw new ValidationException($this, static::REDIRECT_TO);
        }

        return $this->validation->getValidData();
    }

    protected function addCustomRules(BaseValidator $validator): void
    {
        $files = scandir(__DIR__ . '/Rules');

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $classname = __NAMESPACE__ . '\\Rules\\'. str_replace('.php', '', $file);

            $class = new $classname();

            $validator->addValidator($class->ruleName, $class);
        }
    }

    public function errors(): ErrorBag
    {
        return $this->validation->errors();
    }

    protected function sanitize(array $inputs): array
    {
        return $inputs;
    }

    protected function aliases(): array
    {
        return [];
    }

    protected function messages(): array
    {
        return [];
    }

    abstract protected function rules(): array;
}
