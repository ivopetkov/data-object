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
trait DataListToArrayTrait
{

    /**
     * Returns the list data converted as an array.
     * 
     * @param array $options Available options: ignoreReadonlyProperties
     * @return array The list data converted as an array.
     * @throws \InvalidArgumentException
     */
    public function toArray(array $options = []): array
    {
        $this->internalDataListUpdate();

        // Copied from DataObjectToArrayTrait. Do not modify here !!!
        $ignoreReadonlyProperties = array_search('ignoreReadonlyProperties', $options) !== false;
        $toArray = function ($object) use (&$toArray, $ignoreReadonlyProperties): array {
            $result = [];

            if ($object instanceof \ArrayObject) {
                $vars = (array) $object; // Needed for PHP 7.4.
                foreach ($vars as $name => $value) {
                    $result[$name] = null;
                }
            } else {
                $vars = get_object_vars($object);
                foreach ($vars as $name => $value) {
                    if ($name !== 'internalDataObjectData') {
                        $reflectionProperty = new \ReflectionProperty($object, $name);
                        if ($reflectionProperty->isPublic()) {
                            $result[$name] = null;
                        }
                    }
                }
            }
            if (isset($object->internalDataObjectData)) {
                foreach ($object->internalDataObjectData['p'] as $name => $value) {
                    if ($ignoreReadonlyProperties && isset($value[5])) { // readonly
                        continue;
                    }
                    $result[$name] = null;
                }
                foreach ($object->internalDataObjectData['d'] as $name => $value) {
                    $result[$name] = null;
                }
            }
            ksort($result);
            foreach ($result as $name => $null) {
                $value = $object instanceof \ArrayAccess ? $object[$name] : (isset($object->$name) ? $object->$name : null);
                if (is_object($value)) {
                    if (method_exists($value, 'toArray')) {
                        $result[$name] = $value->toArray();
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

        $result = [];
        foreach ($this->internalDataListData as $index => $object) {
            $object = $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, $index);
            if (method_exists($object, 'toArray')) {
                $result[] = $object->toArray();
            } else {
                $result[] = $toArray($object);
            }
        }
        return $result;
    }
}
