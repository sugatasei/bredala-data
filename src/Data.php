<?php

namespace Bredala\Data;

use JsonSerializable;

/**
 * Designed to be extends to help create
 * entities, models, ...
 */
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
    public function init(): static
    {
        return $this;
    }

    /**
     * Imports data
     *
     * @param array $data
     * @return static
     */
    public function import(array $data = []): static
    {
        foreach ($data as $property => $value) {
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

    /**
     * Get all properties
     *
     * @return array
     */
    final public function properties(): array
    {
        $key = $this::class . '::properties';

        if (!MicroCache::has($key)) {
            $properties = [];

            $reflect = new \ReflectionClass($this);
            $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

            foreach ($props as $prop) {
                if (!$prop->isStatic()) {
                    $properties[] = $prop->getName();
                }
            }

            MicroCache::set($key, $properties);
        }

        return MicroCache::get($key);
    }
}
