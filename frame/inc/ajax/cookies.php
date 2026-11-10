<?php

class Cookies
{

    public const LIFETIME = 60 * 60 * 24 * 30;

    static function set($name, $value, $time = self::LIFETIME): bool
    {
        $value = is_bool($value) ? ($value ? '1' : '0') : (string) $value;
        $saved = setcookie($name, $value, [
            'expires' => time() + $time,
            'path' => '/',
            'secure' => is_ssl(),
            'httponly' => false,
            'samesite' => 'Lax',
        ]);
        if ($saved) {
            if ($time > 0) $_COOKIE[$name] = $value;
            else unset($_COOKIE[$name]);
        }
        return $saved;
    }

    static function delete($name): bool
    {
        return self::set($name, '', -3600);
    }

    static function update($name, $value): bool
    {
        return self::set($name, $value);
    }

    static function get($name): ?string
    {
        $value = $_COOKIE[$name] ?? null;
        return is_string($value) ? $value : null;
    }
}
