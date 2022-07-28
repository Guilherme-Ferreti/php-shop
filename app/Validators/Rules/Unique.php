<?php

namespace App\Validators\Rules;

use App\App;
use Rakit\Validation\Rule;

class Unique extends Rule
{
    public string $ruleName = 'unique';

    protected $message = "The value for the field :attribute already exists.";

    protected $fillableParams = ['table', 'column', 'except_id'];

    protected $requiredParams = ['table', 'column'];

    public function check(mixed $value): bool
    {
        $this->requireParameters($this->requiredParams);

        $table = $this->parameter('table');
        $column = $this->parameter('column');
        $except_id = (int) $this->parameter('except_id');

        $results = App::db()->select("SELECT COUNT($column) AS count FROM $table WHERE $column = :value AND id != :id", [
            ':value' => $value,
            ':id' => $except_id,
        ]);

        return (int) $results[0]['count'] === 0;
    }
}
