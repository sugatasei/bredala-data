<?php

namespace Bredala\Data\Encoders;

class TimestampEncoder implements EncoderInterface
{
    private string $format;

    public function __construct(string $format = 'Y-m-d H:i:s')
    {
        $this->format = $format;
    }

    /**
     * @param int|null $value
     * @return string|null
     */
    public function encode($value)
    {
        if ($value === null) {
            return $value;
        }
        return date($this->format, (int) $value);
    }

    /**
     * @param string|null $value
     * @return int|null
     */
    public function decode($value)
    {
        if ($value === null) {
            return $value;
        }
        return strtotime($value);
    }
}
