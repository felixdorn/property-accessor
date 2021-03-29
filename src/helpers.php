<?php

namespace Felix\PropertyAccessor;

use Felix\PropertyAccessor\Exceptions\PropertyDoesNotExist;
use ReflectionParameter;

function access(object $object, $callback)
{
    $properties = [];

    if (is_callable($callback)) {
        $reflectedCallback = new \ReflectionFunction($callback);
        $properties        = array_map(fn (ReflectionParameter $parameter) => $parameter->getName(), $reflectedCallback->getParameters());
    }

    if (!is_callable($callback) && is_string($callback)) {
        $properties = [$callback];
    }

    if (is_array($callback)) {
        $properties = $callback;
    }

    $reflectedObject = new \ReflectionClass($object);

    $resolved = [];
    foreach ($properties as $property) {
        if (!$reflectedObject->hasProperty($property)) {
            throw new PropertyDoesNotExist("Property [$property] does not exist on the given object");
        }

        $property = $reflectedObject->getProperty($property);
        $property->setAccessible(true);
        $resolved[$property->getName()] = $property->getValue($object);
    }

    if (is_callable($callback)) {
        return $reflectedCallback->invokeArgs($resolved);
    }

    return count($resolved) === 1 ? $resolved[array_key_first($resolved)] : $resolved;
}
