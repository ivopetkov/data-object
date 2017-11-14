<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * 
 */
trait DataObjectToArrayTrait
{

    /**
     * Returns the object data converted as an array
     * 
     * @return array The object data converted as an array
     */
    public function toArray(): array
    {
        $result = [];

        $objectProperties = get_object_vars($this);
        foreach ($objectProperties as $name => $value) {
            if ($name !== 'internalDataObjectData') {
                $reflectionProperty = new \ReflectionProperty($this, $name);
                if ($reflectionProperty->isPublic()) {
                    $result[$name] = null;
                }
            }
        }

        if (isset($this->internalDataObjectData)) {
            foreach ($this->internalDataObjectData as $name => $value) {
                $result[substr($name, 1)] = null;
            }
        }

        ksort($result);
        foreach ($result as $name => $null) {
            $value = $this->$name;
            if (method_exists($value, 'toArray')) {
                $result[$name] = $value->toArray();
            } else {
                $result[$name] = $value;
            }
        }

        return $result;
    }

}
