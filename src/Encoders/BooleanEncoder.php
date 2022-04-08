<?php

namespace Bredala\Data\Encoders;

class BooleanEncoder implements EncoderInterface
{
    /**
     * @param bool $value
     * @return int
     */
    public function encode($value)
    {
        return $value ? 1 : 0;
    }

    /**
     * @param int $value
     * @return null
     */
    public function decode($value)
    {
        return $value ? true : false;
    }
}
