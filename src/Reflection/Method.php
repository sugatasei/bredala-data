<?php

namespace Bredala\Data\Reflection;

use ReflectionMethod;

/**
 * Get & Store class informations
 */
final class Method
{
    const IS_PRIVATE = 1;
    const IS_PROTECTED = 2;
    const IS_PUBLIC = 3;

    public readonly string $name;
    public readonly int $type;
    public readonly bool $isStatic;

    public function __construct(ReflectionMethod $method)
    {
        $this->name = $method->getName();

        if ($method->isPublic()) {
            $this->type = self::IS_PUBLIC;
        } elseif ($method->isProtected()) {
            $this->type = self::IS_PRIVATE;
        } else {
            $this->type = self::IS_PRIVATE;
        }

        $this->isStatic = $method->isStatic();
    }
}
