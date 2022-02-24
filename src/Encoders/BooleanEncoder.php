<?php

namespace Bredala\Data\Encoders;

class BooleanEncoder implements EncoderInterface
{
    public function encode($value)
    {
        return $value ? 1 : 0;
    }

    public function decode($value)
    {
        return $value ? true : false;
    }
}
