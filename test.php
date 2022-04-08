<?php


use Bredala\Data\ArrayHelper;

include __DIR__ . '/vendor/autoload.php';


$ary = ArrayHelper::prefixKeys([
    'id' => 1,
    'name' => 'John Doe',
    'city' => 'London'
], 'user_');

print_r($ary);
