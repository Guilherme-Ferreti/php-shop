<?php

declare(strict_types=1);

namespace App\Helpers;

class CsrfToken
{
    public const CSRF_TOKEN_KEY = 'csrf_tokens';

    public static function create(): string
    {
        $token = md5(uniqid((string) rand(), true));

        $sessionTokens = Session::get(self::CSRF_TOKEN_KEY, []);

        $sessionTokens[] = [
            'value' => $token,
            'time'  => time(),
        ];

        Session::set(self::CSRF_TOKEN_KEY, $sessionTokens);

        return '<input type="hidden" name="csrf_token" value="'.$token.'">';
    }

    public static function validate(string $token): bool
    {
        $sessionTokens = Session::get(self::CSRF_TOKEN_KEY, []);

        $maxTime = config('csrf_token.max_time');

        foreach ($sessionTokens as $sessionToken) {
            if ($token === $sessionToken['value'] && ($sessionToken['time'] + $maxTime) >= time()) {
                return true;
            }
        }

        return false;
    }

    public static function clear(): void
    {
        Session::set(self::CSRF_TOKEN_KEY, []);
    }
}
