# bredala-data

PHP modeling and data manipulation tools.

## Data

`Data` is designed to be extends to help create entities, models, ...

`Data` implements `JsonSerializable` for all public non static properties.

## MicroCache

Micro-caching tools. Store data only during the script execution.

````php
use Bredala\Data\MicroCache;

if (null === ($foo = MicroCache::get('foo'))) {
    $foo = 'bar';
    MicroCache::set('foo', $foo);
}
````

Special use : the value can be null

````php
use Bredala\Data\MicroCache;

if (null === ($nullable = MicroCache::get('nullable')) && !MicroCache::has('nullable')) {
    $nullable = null;
    MicroCache::set('nullable', $nullable);
}
````

## ArrayHelper

### Extract part of array

Creates an array from another array keeping only certain keys.

````php
use Bredala\Data\ArrayHelper;

$arry = ArrayHelper::extract([
    'id' => 1,
    'name' => 'John Doe',
    'city' => 'London'
], ['id', 'name']);
````

### Extract part of array

Creates an array from another array keeping only certain keys.

````php
use Bredala\Data\ArrayHelper;

$ary = ArrayHelper::extract([
    'id' => 1,
    'name' => 'John Doe',
    'city' => 'London'
], ['id', 'name']);
````

### Rename keys

Rename a keys from an array

````php
use Bredala\Data\ArrayHelper;

$ary = ArrayHelper::renameKeys([
    'id' => 1,
    'name' => 'John Doe',
    'city' => 'London'
], [
    'id' => 'user_id'
]);
````

### Add prefix to keys

````php
use Bredala\Data\ArrayHelper;

$ary = ArrayHelper::addPrefix([
    'id' => 1,
    'name' => 'John Doe',
    'city' => 'London'
], 'user_');
````

### Remove prefix to keys

````php
use Bredala\Data\ArrayHelper;

$ary = ArrayHelper::removePrefix([
    'user_id' => 1,
    'user_name' => 'John Doe',
    'user_city' => 'London'
], 'user_');
````

## Encoder/Decoder

Encoders helps to transform PHP data to storage type.
Decoders helps to tranform data from storage to PHP type.

Encoders & Decoders are usefull inside adapters.

- `BooleanEncoder` Encode/Decode 0-1 integer to/from PHP boolean
- `DataEncoder` Encode/Decode array to/from `Data` object
- `DataListEncoder` : Encode/Decode array of array to/from array of `Data` objects
- `DateTimeEncoder` :  Encode/Decode date with string representation to/from PHP DateTime objects
- `JsonEncoder`
- `TimestampEncoder` : Encode/Decode date with string representation to/from PHP Unix Timestamp
