<?php

namespace Bredala\Data;

/**
 * Micro caching tools
 * Store data during script execution only
 */
final class MicroCache
{
    private static array $data = [];

    public static function has(string $key): bool
    {
        return array_key_exists($key, self::$data);
    }

    /**
     * Gets data from key
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        return self::$data[$key] ?? null;
    }

    /**
     * Stores data by key
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, mixed $value): void
    {
        self::$data[$key] = $value;
    }

    /**
     * Deletes data by key
     *
     * @param string $key
     */
    public static function del(string $key): void
    {
        self::$data[$key] = null;
        unset(self::$data[$key]);
    }
}
