<?php

namespace Bredala\Data;

use Bredala\Data\Reflection\Reflection;
use JsonSerializable;

/**
 * Designed to be extends to help create
 * entities, models, ...
 */
abstract class Model implements JsonSerializable
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
     * @param array $input
     * @return static
     */
    public function import(array $input = []): static
    {
        $properties = Reflection::getInstance(static::class)->properties();
        foreach ($input as $name => $value) {
            if (($property = $properties[$name] ?? null) && $property->isImportable()) {
                $this->{$name} = $value;
            }
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
        $output = [];
        foreach (Reflection::getInstance(static::class)->properties() as $name => $property) {
            if ($property->isExportable()) {
                $output[$name] = $this->{$name};
            }
        }
        return [];
    }

    /**
     * Json serializer
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->export();
    }

    // -------------------------------------------------------------------------
}
