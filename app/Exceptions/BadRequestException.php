<?php

declare(strict_types=1);

namespace App\Exceptions;

class BadRequestException extends \Exception
{
    protected $message = '400 Method Not Allowed';
}
