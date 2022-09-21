<?php

namespace Bredala\Data\Encoders;

use DateTime;

class DateTimeEncoder implements EncoderInterface
{
    private string $format;

    public function __construct(string $format = 'Y-m-d H:i:s')
    {
        $this->format = $format;
    }

    /**
     * @param DateTime|null $value
     * @return string|null
     */
    public function encode($value)
    {
        if ($value === null) {
            return $value;
        }
        return $value->format($this->format);
    }

    /**
     * @param string|null $value
     * @return DateTime|null
     */
    public function decode($value)
    {
        if ($value === null) {
            return $value;
        }
        return new DateTime($value);
    }
}
