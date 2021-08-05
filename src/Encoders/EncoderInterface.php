<?php

namespace Bredala\Data\Encoders;

/**
 * Interface EncoderInterface
 */
interface EncoderInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function encode($value);

    /**
     * @param mixed $value
     * @return mixed
     */
    public function decode($value);
}
