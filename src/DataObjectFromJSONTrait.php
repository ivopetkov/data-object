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
trait DataObjectFromJSONTrait
{

    /**
     * Creates an object and fills its properties from the array specified.
     * 
     * @param array $data The data used for the object properties.
     * @return object
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
     * @param array $data
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
            if (isset($this->internalDataObjectData['p' . $name])) {
                $valueIsSet = false;
                $propertyData = $this->internalDataObjectData['p' . $name];
                if (isset($propertyData[5])) { // readonly
                    $currentValue = $this->$name;
                    $currentValueIsSet = true;
                    $isReadOnly = true;
                } elseif (isset($propertyData[1])) { // init
                    $currentValue = $this->$name;
                    $currentValueIsSet = true;
                } elseif (isset($propertyData[6])) { // type
                    $type = $propertyData[6];
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
                    }
                }
                if (!$currentValueIsSet && isset($propertyData[0])) { // default init
                    $currentValue = $this->$name;
                }
                if (!$valueIsSet && is_object($currentValue)) {
                    if (method_exists($currentValue, '__fromJSON')) {
                        $currentValue->__fromJSON(json_encode($value));
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
