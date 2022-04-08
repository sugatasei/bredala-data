<?php

namespace Bredala\Data\Encoders;

class JsonEncoder implements EncoderInterface
{
    /**
     * @param mixed $value
     * @return string|null
     */
    public function encode($value)
    {
        if ($value === null) {
            return null;
        }

        return json_encode($value);
    }

    /**
     * @param string|null $value
     * @return mixed
     */
    public function decode($value)
    {
        if ($value === null) {
            return null;
        }

        return json_decode($value, true);
    }
}
