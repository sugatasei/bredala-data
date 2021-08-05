<?php

namespace Bredala\Data;

class Entity implements \JsonSerializable
{
    private array $mapping = [];
    private array $values = [];

    // -------------------------------------------------------------------------
    // Data
    // -------------------------------------------------------------------------

    public function __construct(array $data = [])
    {
        $this->mapping();
        $this->import($data);
    }

    /**
     * Init mapping
     */
    protected function mapping()
    {
        return;
    }

    /**
     * Default values
     */
    protected function default()
    {
        return;
    }

    /**
     * Add element to mapping
     *
     * @param string $key
     * @param string $classname
     * @param boolean $isArray
     */
    protected function map(string $key, string $classname, $isArray = false)
    {
        $this->mapping[$key] = [$classname, $isArray];
    }

    // -------------------------------------------------------------------------
    // Data
    // -------------------------------------------------------------------------

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->default();

        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * @param array $keys
     * @return array
     */
    public function export(): array
    {
        return json_decode(json_encode($this), true);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, $value)
    {
        $this->values[$key] = self::nestedObject($this->mapping[$key] ?? null, $value);
        return $this;
    }

    /**
     * @param string $key
     * @return Entity|null or mixed
     */
    public function get(string $key)
    {
        return $this->values[$key] ?? null;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function has(string $key): bool
    {
        return $this->get($key) === null;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function is(string $key, $value): bool
    {
        return $this->get($key) === $value;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function not(string $key, $value): bool
    {
        return $this->get($key) !== $value;
    }

    /**
     * @param Entity $data
     * @return boolean
     */
    public function hasChanges(Entity $data): bool
    {
        return $this->export() === $data->export();
    }

    public function diff(Entity $original)
    {
        $export = $this->export();
        $original = $original->export();

        if ($original === $export) {
            return [];
        }

        return self::arrayRecursiveDiff($export, $original);
    }

    public function changes(Entity $original): array
    {
        $export = $this->export();
        $original = $original->export();

        if ($original === $export) {
            return [];
        }

        $diff = self::arrayRecursiveDiff($export, $original);
        return DataMapper::extract($export, array_keys($diff));
    }

    public function jsonSerialize()
    {
        $values = [];
        foreach ($this->values as $key => $value) {
            $values[$key] = $value;
        }

        return $values;
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Converts array to Entity depending to the mapping
     *
     * @param array|null $mapping
     * @return mixed
     * @param mixed $value
     */
    private static function nestedObject(?array $mapping, $value)
    {
        if (!$mapping || !$value || !is_array($value)) {
            return $value;
        }

        [$classname, $isArray] = $mapping;

        // Array of object
        if ($isArray) {
            foreach ($value as $k => $v) {
                if ($v && is_array($v)) {
                    $value[$k] = new $classname($v);
                }
            }
        } else {
            $value = new $classname($value);
        }

        return $value;
    }

    /**
     * Returns recursive difference of two arrays
     *
     * @param array $original
     * @param array $compare
     */
    private static function arrayRecursiveDiff(array $original, array $compare): array
    {
        $out = [];

        foreach ($original as $key => $value) {
            if (array_key_exists($key, $compare)) {
                if (is_array($value)) {
                    if (($diff = self::arrayRecursiveDiff($value, $compare[$key]))) {
                        $out[$key] = $diff;
                    }
                } else {
                    if ($value != $compare[$key]) {
                        $out[$key] = $value;
                    }
                }
            } else {
                $out[$key] = $value;
            }
        }
        return $out;
    }

    // -------------------------------------------------------------------------
}
