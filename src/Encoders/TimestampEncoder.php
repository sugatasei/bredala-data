<?php

namespace Bredala\Data\Encoders;

class TimestampEncoder implements EncoderInterface
{
    public function encode($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

    public function decode($value)
    {
        return strtotime($value);
    }
}
