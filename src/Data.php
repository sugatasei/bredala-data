<?php

namespace Bredala\Data;

use Bredala\Data\Encoders\DataEncoder;
use Bredala\Data\Encoders\DataListEncoder;
use Bredala\Data\Encoders\EncoderInterface;
use JsonSerializable;

class Data implements JsonSerializable
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->init();
        $this->import($data);
    }

    /**
     * Initialize data
     */
    public function init()
    {
    }

    /**
     * Mapping declaration
     *
     * @return array
     */
    public function mapping(): array
    {
        return [];
    }

    /**
     * Imports data
     *
     * @param array $data
     * @return static
     */
    public function import(array $data = []): static
    {
        if (!($mapper = self::get('map'))) {
            $mapper = new DataMapper();
            foreach ($this->mapping() as $property => $encoder) {
                if ($encoder instanceof EncoderInterface) {
                    $mapper->map($property, $encoder);
                } elseif (is_array($encoder)) {
                    $mapper->map($property, new DataListEncoder($encoder[0]));
                } else {
                    $mapper->map($property, new DataEncoder($encoder));
                }
            }
            self::set('map', $mapper);
        }

        foreach ($mapper->encode($data) as $property => $value) {
            $this->{$property} = $value;
        }

        return $this;
    }

    /**
     * Exports data
     *
     * @return array
     */
    public function export(): array
    {
        $data = [];
        foreach ($this->properties() as $property) {
            $data[$property] = $this->{$property};
        }

        return $data;
    }

    /**
     * Alias of export
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->export();
    }

    final public function properties(): array
    {
        if (null === ($poperties = self::get('properties'))) {
            $reflect = new \ReflectionClass($this);
            $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

            $poperties = [];
            foreach ($props as $prop) {
                if (!$prop->isStatic()) {
                    $poperties[] = $prop->getName();
                }
            }

            self::set('properties', $poperties);
        }

        return $poperties;
    }

    /**
     * Gets data from cache
     *
     * @param string $name
     * @return mixed
     */
    public static function get(string $name)
    {
        return Cache::get(self::cacheKey($name));
    }

    /**
     * Caches a data
     *
     * @param string $name
     * @param mixed $value
     */
    public static function set(string $name, $value)
    {
        Cache::set(self::cacheKey($name), $value);
    }

    /**
     * Deletes a cache entry
     *
     * @param string $name
     */
    public static function del(string $name)
    {
        Cache::del(self::cacheKey($name));
    }

    /**
     * Builds the cache key
     *
     * @param string $name
     * @return string
     */
    private static function cacheKey(string $name): string
    {
        return static::class . '::' . $name;
    }
}
