<?php

namespace Core;

use Core\Traits\Queryable;
use ReflectionClass;
use ReflectionProperty;

abstract class Model
{
    use Queryable;

    public int $id;

    public function toArray(): array
    {
        $properties = [];

        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($props as $prop) {
            if (in_array($prop->getName(), ['tableName', 'commands'])) {
                continue;
            }

            $properties[$prop->getName()] = $prop->getValue($this);
        }

        return $properties;
    }
}