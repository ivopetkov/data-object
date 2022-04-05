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
trait DataObjectFromJSONTrait
{

    /**
     * Creates an object and fills its properties from the JSON specified.
     * 
     * @param string $data The data used for the object properties.
     * @return object Returns a newly constructed object.
     */
    static public function fromJSON(string $data)
    {
        $class = get_called_class();
        $object = new $class();
        $object->__fromJSON($data);
        return $object;
    }

    /**
     * Internal function that fills the current object with the properties specified.
     * 
     * @param string $data The data used for the object properties.
     * @throws \Exception
     */
    public function __fromJSON(string $data): void
    {
        $data = json_decode($data, true);
        $hasArrayAccess = $this instanceof \ArrayAccess;
        foreach ($data as $name => $value) {
            $currentValue = null;
            $currentValueIsSet = false;
            $isReadOnly = false;
            if (isset($this->internalDataObjectData['p'][$name])) {
                $propertyDefinition = $this->internalDataObjectData['p'][$name];
                $valueIsSet = false;
                if (isset($propertyDefinition[6])) { // type
                    $type = $propertyDefinition[6];
                    $isNullable = $type[0] === '?';
                    if ($isNullable) {
                        $type = substr($type, 1);
                    }
                } else {
                    $type = null;
                    $isNullable = true;
                }
                if (isset($propertyDefinition[5])) { // readonly
                    $currentValue = $this->$name;
                    $currentValueIsSet = true;
                    $isReadOnly = true;
                } elseif (isset($propertyDefinition[1])) { // init
                    $currentValue = $this->$name;
                    $currentValueIsSet = true;
                } elseif ($type !== null && $type !== 'array' && $type !== 'float' && $type !== 'int' && $type !== 'string') {
                    if ($value !== null) {
                        if (class_exists($type)) {
                            if (is_callable([$type, 'fromJSON'])) {
                                if (is_array($value)) {
                                    $value = call_user_func([$type, 'fromJSON'], json_encode($value));
                                    $valueIsSet = true;
                                } else {
                                    throw new \Exception('Cannot assing value of type ' . gettype($value) . ' to an object!');
                                }
                            } else {
                                $currentValue = new $type();
                                $currentValueIsSet = true;
                            }
                        } else {
                            throw new \Exception('Cannot find class named ' . $type . ' for property ' . $name . '!');
                        }
                    } else {
                        if ($isNullable) {
                            $value = null;
                            $valueIsSet = true;
                        } else {
                            throw new \Exception('The property ' . $name . ' value cannot be null!');
                        }
                    }
                }
                if (!$currentValueIsSet && isset($propertyDefinition[0])) { // default init
                    $currentValue = $this->$name;
                }
                if (!$valueIsSet && is_object($currentValue)) {
                    if (method_exists($currentValue, '__fromJSON')) {
                        $currentValue->__fromJSON(json_encode($value));
                    } elseif ($type === 'DateTime') {
                        $currentValue->setTimestamp(is_numeric($value) ? $value : strtotime($value));
                    } else {
                        if (is_array($value)) {
                            $_hasArrayAccess = $currentValue instanceof \ArrayAccess;
                            foreach ($value as $_name => $_value) {
                                if ($_hasArrayAccess) {
                                    $currentValue[$_name] = $_value;
                                } else {
                                    $currentValue->$_name = $_value;
                                }
                            }
                        } else {
                            throw new \Exception('Cannot assing value of type ' . gettype($value) . ' to an object!');
                        }
                    }
                    $value = $currentValue;
                }
                if (isset($propertyDefinition[7])) { // encodeInJSON is set
                    if ($value !== null && substr($value, 0, 13) === 'data:;base64,') {
                        $value = base64_decode(substr($value, 13));
                    }
                }
            }
            if (!$isReadOnly) {
                if ($hasArrayAccess) {
                    $this[$name] = $value;
                } else {
                    $this->$name = $value;
                }
            }
        }
    }
}
