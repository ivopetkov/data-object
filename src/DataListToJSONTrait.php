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
trait DataListToJSONTrait
{

    /**
     * Returns the list data converted as JSON.
     * 
     * @param array $options Available options: ignoreReadonlyProperties
     * @return string The list data converted as JSON.
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function toJSON(array $options = []): string
    {
        $this->internalDataListUpdate();

        // Copied from DataObjectToJSONTrait. Do not modify here !!!
        $ignoreReadonlyProperties = array_search('ignoreReadonlyProperties', $options) !== false;
        $toJSON = function ($object) use ($ignoreReadonlyProperties, $options): string {
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
            $propertiesToEncode = [];
            if (isset($object->internalDataObjectData)) {
                $propertiesToSkip = [];
                foreach ($object->internalDataObjectData['p'] as $name => $value) {
                    if ($ignoreReadonlyProperties && isset($value[5])) { // readonly
                        $propertiesToSkip[$name] = true;
                        continue;
                    }
                    $result[$name] = null;
                    if (isset($value[7])) { // encodeInJSON is set
                        $propertiesToEncode[$name] = true;
                    }
                }
                foreach ($object->internalDataObjectData['d'] as $name => $value) {
                    if (isset($propertiesToSkip[$name])) {
                        continue;
                    }
                    $result[$name] = null;
                }
            }
            ksort($result);
            foreach ($result as $name => $null) {
                $value = $object instanceof \ArrayAccess ? $object[$name] : (isset($object->$name) ? $object->$name : null);
                if (is_object($value) && method_exists($value, 'toJSON')) {
                    $result[$name] = $value->toJSON($options);
                } else {
                    if ($value instanceof \DateTime) {
                        $value = $value->format('c');
                    }
                    if (isset($propertiesToEncode[$name]) && $value !== null) {
                        if (is_string($value)) {
                            $value = 'data:;base64,' . base64_encode($value);
                        } else {
                            throw new \Exception('The value of the ' . $name . ' property cannot be JSON encoded. It must be of type string!');
                        }
                    }
                    $result[$name] = json_encode($value);
                    if ($result[$name] === false) {
                        throw new \Exception('JSON encode error (' . json_last_error_msg() . ') for: ' . print_r($value, true));
                    }
                }
            }
            $json = '';
            foreach ($result as $name => $value) {
                $json .= '"' . addcslashes($name, '"\\') . '":' . $value . ',';
            }
            $json = '{' . rtrim($json, ',') . '}';
            return $json;
        };

        $json = '';
        foreach ($this->internalDataListData as $index => $object) {
            $object = $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, $index);
            if (method_exists($object, 'toJSON')) {
                $json .= $object->toJSON($options) . ',';
            } else {
                $json .= $toJSON($object) . ',';
            }
        }
        $json = '[' . rtrim($json, ',') . ']';
        return $json;
    }
}
