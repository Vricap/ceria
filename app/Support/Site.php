<?php

namespace App\Support;

class Site
{
    /**
     * Ambil satu nilai setting, dengan default opsional.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return config("site.settings.{$key}", $default);
    }

    /**
     * Ambil semua setting sebagai array key => value.
     */
    public static function all(): array
    {
        return config('site.settings', []);
    }
}
