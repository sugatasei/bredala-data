<?php

namespace Bredala\Data\Reflection;

use ReflectionClass;

/**
 * Get & Store class informations
 */
final class Reflection
{
    private static array $cache = [];

    private string $classname;
    private ?array $properties = null;
    private ?array $methods = null;

    /**
     * @param string $classname
     */
    protected function __construct(string $classname)
    {
        $this->classname = $classname;
    }

    /**
     * @param string $classname
     * @return static
     */
    public static function getInstance(string $classname): static
    {
        if (!isset(self::$cache[$classname])) {
            self::$cache[$classname] = new static($classname);
        }

        return self::$cache[$classname];
    }

    /**
     * @return Property[]
     */
    public function properties(): array
    {
        if ($this->properties === null) {
            $this->properties = [];
            foreach ($this->reflectionClass()->getProperties() as $property) {
                $this->properties[$property->getName()] = new Property($property);
            }
        }

        return $this->properties;
    }

    /**
     * @return Method[]
     */
    public function methods(): array
    {
        if ($this->methods === null) {
            $this->methods = [];
            foreach ($this->reflectionClass()->getMethods() as $method) {
                $this->methods[$method->getName()] = new Method($method);
            }
        }

        return $this->methods;
    }

    /**
     * @return ReflectionClass
     */
    private function reflectionClass(): ReflectionClass
    {
        return new ReflectionClass($this->classname);
    }
}
