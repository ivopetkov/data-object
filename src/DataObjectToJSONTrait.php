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
trait DataObjectToJSONTrait
{

    /**
     * Returns the object data converted as JSON
     * 
     * @return string The object data converted as JSON
     */
    public function toJSON(): string
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
            if (method_exists($value, 'toJSON')) {
                $result[$name] = $value->toJSON();
            } else {
                $result[$name] = json_encode($value);
            }
        }

        $json = '{';
        foreach ($result as $name => $value) {
            $json .= '"' . addcslashes($name, '"\\') . '":' . $value . ',';
        }
        $json = rtrim($json, ',');
        $json .= '}';

        return $json;
    }

}
