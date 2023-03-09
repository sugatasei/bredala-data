<?php

namespace Bredala\Data\Reflection;

use ReflectionProperty;

/**
 * Get & Store class informations
 */
final class Property
{
    const IS_PRIVATE = 1;
    const IS_PROTECTED = 2;
    const IS_PUBLIC = 3;

    public readonly string $name;
    public readonly int $type;
    public readonly bool $isStatic;
    public readonly bool $isReadonly;

    public function __construct(ReflectionProperty $property)
    {
        $this->name = $property->getName();

        if ($property->isPublic()) {
            $this->type = self::IS_PUBLIC;
        } elseif ($property->isProtected()) {
            $this->type = self::IS_PRIVATE;
        } else {
            $this->type = self::IS_PRIVATE;
        }

        $this->isStatic = $property->isStatic();
        $this->isReadonly = $property->isReadOnly();
    }

    public function isImportable(): bool
    {
        return !$this->isStatic && !$this->isReadonly;
    }

    public function isExportable(): bool
    {
        return $this->type === self::IS_PUBLIC && !$this->isStatic;
    }
}
