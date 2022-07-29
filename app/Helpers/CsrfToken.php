<?php

declare(strict_types=1);

namespace App\Helpers;

class CsrfToken
{
    private const SESSION_KEY = 'csrf_tokens';

    public const INPUT_NAME = 'csrf_token';

    public static function create(): string
    {
        $token = md5(uniqid((string) rand(), true));

        $sessionTokens = Session::get(self::SESSION_KEY, []);

        $sessionTokens[] = [
            'value' => $token,
            'time'  => time(),
        ];

        Session::set(self::SESSION_KEY, $sessionTokens);

        return '<input type="hidden" name="'.self::INPUT_NAME.'" value="'.$token.'">';
    }

    public static function validate(string $token): bool
    {
        $sessionTokens = Session::get(self::SESSION_KEY, []);

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
        Session::set(self::SESSION_KEY, []);
    }
}
