<?php

namespace Bredala\Data;

use Bredala\Data\Encoders\DataEncoder;
use Bredala\Data\Encoders\DataListEncoder;
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
        if (!($mapper = Cache::get(static::class . '::mapper'))) {
            $mapper = new DataMapper();
            foreach ($this->mapping() as $property => $classname) {
                if (is_array($classname)) {
                    $mapper->map($property, new DataListEncoder($classname[0]));
                } else {
                    $mapper->map($property, new DataEncoder($classname));
                }
            }
            Cache::set(static::class . '::mapper', $mapper);
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
        if (null === ($poperties = Cache::get(static::class . '::properties'))) {
            $reflect = new \ReflectionClass($this);
            $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

            $poperties = [];
            foreach ($props as $prop) {
                if (!$prop->isStatic()) {
                    $poperties[] = $prop->getName();
                }
            }

            Cache::set(static::class . '::properties', $poperties);
        }

        return $poperties;
    }
}
