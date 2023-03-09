<?php

include __DIR__ . '/vendor/autoload.php';


class T
{
    public string $name = 'name';
}


$reflection = new ReflectionClass(T::class);
$property = $reflection->getProperty('name');
