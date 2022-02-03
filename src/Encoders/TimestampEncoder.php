<?php

namespace Bredala\Data\Encoders;

class TimestampEncoder implements EncoderInterface
{
    private string $format;

    public function __construct(string $format = 'Y-m-d H:i:s')
    {
        $this->format = $format;
    }

    public function encode($value)
    {
        return date($this->format, (int) $value);
    }

    public function decode($value)
    {
        return strtotime($value);
    }
}
