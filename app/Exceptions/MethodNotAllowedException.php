<?php

declare(strict_types=1);

namespace App\Exceptions;

class MethodNotAllowedException extends \Exception
{
    protected $message = '405 Method Not Allowed';
}
