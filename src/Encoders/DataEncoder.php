<?php

namespace Bredala\Data\Encoders;

use Bredala\Data\Data;
use InvalidArgumentException;

/**
 * Transforms an array of data into a Bredala\Data\Data objects
 */
class DataEncoder implements EncoderInterface
{
    private string $classname;

    /**
     * @param string $classname
     */
    public function __construct(string $classname)
    {
        if (!is_a($classname, Data::class, true)) {
            throw new InvalidArgumentException("$classname must extend " . Data::class);
        }

        $this->classname = $classname;
    }

    /**
     * @param Data|array|null $value
     * @return Data|null
     */
    public function encode($value)
    {
        if (!$value) {
            return null;
        }

        if (is_array($value)) {
            $classname = $this->classname;
            return new $classname($value);
        }

        if (is_object($value) && is_a($value, $this->classname)) {
            return $value;
        }

        return null;
    }

    /**
     * @param Data|array|null $value
     * @return array|null
     */
    public function decode($value)
    {
        if (!$value) {
            return null;
        }

        if (is_object($value) && is_a($value, $this->classname)) {
            return $value->export();
        }

        return is_array($value) ? $value : null;
    }
}
