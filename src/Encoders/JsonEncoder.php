<?php

namespace Bredala\Data\Encoders;

class JsonEncoder implements EncoderInterface
{
    public function encode($value)
    {
        return json_encode($value);
    }

    public function decode($value)
    {
        return json_decode($value, true);
    }
}
