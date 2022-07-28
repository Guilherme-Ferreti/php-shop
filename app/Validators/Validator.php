<?php

declare(strict_types=1);

namespace App\Validators;

use App\Exceptions\ValidationException;
use App\Helpers\Session;
use App\Http\Middlewares\SaveLastRouteMiddleware;
use App\Models\Model;
use Rakit\Validation\ErrorBag;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator as BaseValidator;

abstract class Validator
{
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
            $this->handleFailure();
        }

        return $this->getValidatedData();
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

    private function handleFailure(): void
    {
        $lastRoute = Session::get(SaveLastRouteMiddleware::LAST_ROUTE_KEY, '/');

        throw new ValidationException($this, $lastRoute);
    }

    public function errors(): ErrorBag
    {
        return $this->validation->errors();
    }

    public function getValidatedData(): array
    {
        return $this->validation->getValidatedData();
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
