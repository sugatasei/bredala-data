<?php

namespace Bredala\Data;

class Cache
{
    public static array $data = [];

    public static function set(string $name, $value)
    {
        self::$data[$name] = $value;
    }

    public static function get(string $name)
    {
        return self::$data[$name] ?? null;
    }

    public static function del(string $name)
    {
        self::set($name, null);
    }
}
