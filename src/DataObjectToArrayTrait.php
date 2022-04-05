<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * 
 */
trait DataObjectToArrayTrait
{

    /**
     * Returns the object data converted as an array.
     * 
     * @param array $options Available options: ignoreReadonlyProperties, properties=>[]
     * @return array The object data converted as an array.
     */
    public function toArray(array $options = []): array
    {
        // Copied to DataList. Copy there when the function is modified !!!
        $ignoreReadonlyProperties = array_search('ignoreReadonlyProperties', $options) !== false;
        $propertiesToReturn = isset($options['properties']) ? $options['properties'] : null;
        if ($propertiesToReturn !== null && !is_array($propertiesToReturn)) {
            throw new \Exception('The properties option must be of type array!');
        }
        $excludeProperty = function (string $name) use ($propertiesToReturn): bool {
            if ($propertiesToReturn === null) {
                return false;
            }
            return array_search($name, $propertiesToReturn) === false;
        };
        $toArray = function ($object) use (&$toArray, $ignoreReadonlyProperties, $excludeProperty, $options): array {
            $result = [];

            if ($object instanceof \ArrayObject) {
                $vars = (array) $object; // Needed for PHP 7.4.
                foreach ($vars as $name => $value) {
                    if ($excludeProperty($name)) {
                        continue;
                    }
                    $result[$name] = null;
                }
            } else {
                $vars = get_object_vars($object);
                foreach ($vars as $name => $value) {
                    if ($excludeProperty($name)) {
                        continue;
                    }
                    if ($name !== 'internalDataObjectData') {
                        $reflectionProperty = new \ReflectionProperty($object, $name);
                        if ($reflectionProperty->isPublic()) {
                            $result[$name] = null;
                        }
                    }
                }
            }
            if (isset($object->internalDataObjectData)) {
                $readonlyPropertiesToSkip = [];
                foreach ($object->internalDataObjectData['p'] as $name => $value) {
                    if ($excludeProperty($name)) {
                        continue;
                    }
                    if ($ignoreReadonlyProperties && isset($value[5])) { // readonly
                        $readonlyPropertiesToSkip[$name] = true;
                        continue;
                    }
                    $result[$name] = null;
                }
                foreach ($object->internalDataObjectData['d'] as $name => $value) {
                    if ($excludeProperty($name)) {
                        continue;
                    }
                    if (isset($readonlyPropertiesToSkip[$name])) {
                        continue;
                    }
                    $result[$name] = null;
                }
            }
            ksort($result);
            foreach ($result as $name => $null) {
                $value = $object instanceof \ArrayAccess ? $object[$name] : (isset($object->$name) ? $object->$name : null);
                if (is_object($value)) {
                    if (method_exists($value, 'toArray')) {
                        $result[$name] = $value->toArray($options);
                    } else {
                        if ($value instanceof \DateTime) {
                            $result[$name] = $value->format('c');
                        } else {
                            $propertyVars = $toArray($value);
                            foreach ($propertyVars as $propertyVarName => $propertyVarValue) {
                                if (is_object($propertyVarValue)) {
                                    $propertyVars[$propertyVarName] = $toArray($propertyVarValue);
                                }
                            }
                            $result[$name] = $propertyVars;
                        }
                    }
                } else {
                    $result[$name] = $value;
                }
            }
            return $result;
        };
        return $toArray($this);
    }
}
