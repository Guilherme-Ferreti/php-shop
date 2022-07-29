<?php

declare(strict_types=1);

namespace App\Enums;

enum HttpMethodEnum: string
{
    case GET = 'GET';

    case POST = 'POST';

    case PATCH = 'PATCH';

    case PUT = 'PUT';

    case DELETE = 'DELETE';
}
