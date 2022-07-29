<?php

declare(strict_types=1);

namespace App\Helpers;

class Session
{
    public const FLASH_KEY = 'flash_session';

    public const SERIALIZE = ['errorBag'];

    public static function set(string $key, mixed $value): void
    {
        if (in_array($key, self::SERIALIZE)) {
            $value = serialize($value);
        }

        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (! isset($_SESSION[$key])) {
            return $default;
        }

        $value = $_SESSION[$key];

        if (in_array($key, self::SERIALIZE)) {
            $value = unserialize($value);
        }

        return $value;
    }

    public static function getAll(): array
    {
        return $_SESSION;
    }

    public static function setFlash(string $key, mixed $value): void
    {
        if (in_array($key, self::SERIALIZE)) {
            $value = serialize($value);
        }

        $_SESSION[self::FLASH_KEY][$key] = $value;
    }

    public static function getFlash(string $key, mixed $default = null): mixed
    {
        if (! isset($GLOBALS[self::FLASH_KEY][$key])) {
            return $default;
        }

        $value = $GLOBALS[self::FLASH_KEY][$key];

        unset($GLOBALS[self::FLASH_KEY][$key]);

        if (in_array($key, self::SERIALIZE)) {
            $value = unserialize($value);
        }

        return $value;
    }

    public static function clearFlash(): void
    {
        unset($_SESSION[self::FLASH_KEY]);
    }
}
