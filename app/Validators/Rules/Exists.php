<?php

namespace App\Validators\Rules;

use App\App;
use Rakit\Validation\Rule;

class Exists extends Rule
{
    public string $ruleName = 'exists';

    protected $message = "The value for the field :attribute was not found.";

    protected $fillableParams = ['table', 'column'];

    protected $requiredParams = ['table', 'column'];

    public function check(mixed $value): bool
    {
        $this->requireParameters($this->requiredParams);

        $table = $this->parameter('table');
        $column = $this->parameter('column');

        $rows = App::db()->select("SELECT count($column) AS count FROM $table WHERE $column = :value", [
            ':value' => $value,
        ]);

        return ((int) $rows[0]['count']) > 0;
    }
}
