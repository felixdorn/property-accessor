<?php

namespace Felix\PropertyAccessor;

use Felix\PropertyAccessor\Exceptions\PropertyDoesNotExist;
use ReflectionFunction;
use ReflectionParameter;

/**
 * @param string|string[]|\Closure $callback
 *
 * @return array|mixed
 *
 * @throws PropertyDoesNotExist
 * @throws \ReflectionException
 */
function access(object $object, $callback)
{
    $properties = [];

    if ($callback instanceof \Closure) {
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

    if ($callback instanceof \Closure) {
        // $reflectedCallback could be used there but my IDE and the code linter don't want to.
        return (new ReflectionFunction($callback))->invokeArgs($resolved);
    }

    return count($resolved) === 1 ? $resolved[array_key_first($resolved)] : $resolved;
}
