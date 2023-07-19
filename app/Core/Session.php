<?php declare(strict_types=1);

namespace App\Core;

class Session
{
    public static function get($key, $default = null)
    {
        return $_SESSION['flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    public static function put(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function has($key): bool
    {
        return (bool)static::get($key);
    }

    public static function flash(string $key, $value): void
    {
       $_SESSION['flash'][$key] = $value;
    }

    public static function unflash()
    {
        unset($_SESSION['flash']);
    }

    public static function destroy()
    {
        $_SESSION = [];
        session_destroy();
    }

}