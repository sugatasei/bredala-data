<?php

namespace Bredala\Data\Encoders;

/**
 * Transforms an array of data into an array of Bredala\Data\Data objects
 */
class DataListEncoder implements EncoderInterface
{
    private DataEncoder $encoder;

    /**
     * @param string $classname
     */
    public function __construct(string $classname)
    {
        $this->encoder = new DataEncoder($classname);
    }

    /**
     * @param array|null $value
     * @return array
     */
    public function encode($value)
    {
        if (!$value || !is_array($value)) {
            return [];
        }

        $out = [];
        foreach ($value as $k => $v) {
            if (($v = $this->encoder->encode($v))) {
                $out[$k] = $v;
            }
        }

        return $out;
    }

    /**
     * @param array|null $value
     * @return array
     */
    public function decode($value)
    {
        if (!$value || !is_array($value)) {
            return [];
        }

        $out = [];
        foreach ($value as $k => $v) {
            if (($v = $this->encoder->decode($v))) {
                $out[$k] = $v;
            }
        }

        return $out;
    }
}
