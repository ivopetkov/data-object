<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

use IvoPetkov\DataList;

/**
 * 
 */
trait DataObjectTrait
{

    /**
     * An array containing the registered properties and the data set
     * 
     * @var array 
     */
    private $internalDataObjectData = null;

    /**
     * 
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $exists = null;
        $value = $this->internalDataObjectMethodGetPropertyValue($offset, $exists);
        if (!$exists) {
            throw new \Exception('Undefined index: ' . $offset);
        }
        return $value;
    }

    /**
     * 
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (!is_null($offset)) {
            $this->internalDataObjectMethodSetPropertyValue($offset, $value);
        }
    }

    /**
     * 
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return $this->internalDataObjectMethodIsPropertyValueSet($offset);
    }

    /**
     * 
     * @param string $offset
     */
    public function offsetUnset($offset): void
    {
        $this->internalDataObjectMethodUnsetPropertyValue($offset);
    }

    /**
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $exists = null;
        $value = $this->internalDataObjectMethodGetPropertyValue($name, $exists);
        if (!$exists) {
            throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $name);
        }
        return $value;
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value): void
    {
        $this->internalDataObjectMethodSetPropertyValue($name, $value);
    }

    /**
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset($name): bool
    {
        return $this->internalDataObjectMethodIsPropertyValueSet($name);
    }

    /**
     * 
     * @param string $name
     */
    public function __unset($name): void
    {
        $this->internalDataObjectMethodUnsetPropertyValue($name);
    }

    /**
     * 
     */
    private function internalDataObjectInitialize(): void
    {
        if (!isset($this->internalDataObjectData['properties'])) {
            $this->internalDataObjectData['properties'] = [];
        }
        if (!isset($this->internalDataObjectData['data'])) {
            $this->internalDataObjectData['data'] = [];
        }
    }

    /**
     * 
     * @param string $name
     * @param bool $exists
     * @return mixed
     */
    private function internalDataObjectMethodGetPropertyValue($name, &$exists)
    {
        if ($this->internalDataObjectData === null) {
            $this->internalDataObjectInitialize();
        }
        $exists = true;
        if (isset($this->internalDataObjectData['properties'][$name])) {
            if (isset($this->internalDataObjectData['properties'][$name][1])) { // get exists
                return call_user_func($this->internalDataObjectData['properties'][$name][1]);
            }
            if (array_key_exists($name, $this->internalDataObjectData['data'])) {
                return $this->internalDataObjectData['data'][$name];
            }
            if (isset($this->internalDataObjectData['properties'][$name][0])) { // init exists
                $this->internalDataObjectData['data'][$name] = call_user_func($this->internalDataObjectData['properties'][$name][0]);
                return $this->internalDataObjectData['data'][$name];
            }
            return null;
        }
        if (array_key_exists($name, $this->internalDataObjectData['data'])) {
            return $this->internalDataObjectData['data'][$name];
        }
        $exists = false;
        return null;
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     */
    private function internalDataObjectMethodSetPropertyValue($name, $value)
    {
        if ($this->internalDataObjectData === null) {
            $this->internalDataObjectInitialize();
        }
        if (isset($this->internalDataObjectData['properties'][$name])) {
            if ($this->internalDataObjectData['properties'][$name][4]) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($this->internalDataObjectData['properties'][$name][2])) { // set exists
                $this->internalDataObjectData['data'][$name] = call_user_func($this->internalDataObjectData['properties'][$name][2], $value);
                if ($this->internalDataObjectData['data'][$name] === null) {
                    unset($this->internalDataObjectData['data'][$name]);
                }
                return;
            }
        }
        $this->internalDataObjectData['data'][$name] = $value;
    }

    /**
     * 
     * @param string $name
     * @return boolean
     */
    private function internalDataObjectMethodIsPropertyValueSet($name): bool
    {
        if ($this->internalDataObjectData === null) {
            $this->internalDataObjectInitialize();
        }
        if (isset($this->internalDataObjectData['properties'][$name])) {
            $exists = null;
            $value = $this->internalDataObjectMethodGetPropertyValue($name, $exists);
            return $value !== null;
        }
        return isset($this->internalDataObjectData['data'][$name]);
    }

    /**
     * 
     * @param string $name
     */
    private function internalDataObjectMethodUnsetPropertyValue($name): void
    {
        if ($this->internalDataObjectData === null) {
            $this->internalDataObjectInitialize();
        }
        if (isset($this->internalDataObjectData['properties'][$name])) {
            if ($this->internalDataObjectData['properties'][$name][4]) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($this->internalDataObjectData['properties'][$name][3])) { // unset exists
                $this->internalDataObjectData['data'][$name] = call_user_func($this->internalDataObjectData['properties'][$name][3]);
                return;
            }
        }
        if (array_key_exists($name, $this->internalDataObjectData['data'])) {
            unset($this->internalDataObjectData['data'][$name]);
        }
    }

    /**
     * Defines a new property
     * 
     * @param string $name The property name
     * @param array $options The property options ['get'=>callable, 'set'=>callable]
     * @throws \Exception
     */
    protected function defineProperty(string $name, array $options = [])
    {
        if (isset($options['init']) && !is_callable($options['init'])) {
            throw new \Exception('The options init attribute must be of type callable');
        }
        if (isset($options['get']) && !is_callable($options['get'])) {
            throw new \Exception('The options get attribute must be of type callable');
        }
        if (isset($options['set']) && !is_callable($options['set'])) {
            throw new \Exception('The options set attribute must be of type callable');
        }
        if (isset($options['unset']) && !is_callable($options['unset'])) {
            throw new \Exception('The options unset attribute must be of type callable');
        }
        if (isset($options['readonly']) && !is_bool($options['readonly'])) {
            throw new \Exception('The options readonly attribute must be of type boolean');
        }
        if ($this->internalDataObjectData === null) {
            $this->internalDataObjectInitialize();
        }
        $this->internalDataObjectData['properties'][$name] = [
            isset($options['init']) ? \Closure::bind($options['init'], $this) : null,
            isset($options['get']) ? \Closure::bind($options['get'], $this) : null,
            isset($options['set']) ? \Closure::bind($options['set'], $this) : null,
            isset($options['unset']) ? \Closure::bind($options['unset'], $this) : null,
            isset($options['readonly']) && $options['readonly'] === true, // readonly
        ];
    }

    /**
     * Returns the object data converted as an array
     * 
     * @return array The object data converted as an array
     */
    public function toArray(): array
    {
        $result = [];
        if ($this->internalDataObjectData !== null) {
            foreach ($this->internalDataObjectData['properties'] as $name => $temp) {
                $exists = null;
                $value = $this->internalDataObjectMethodGetPropertyValue($name, $exists);
                if ($value instanceof \IvoPetkov\DataObject || $value instanceof DataList) {
                    $result[$name] = $value->toArray();
                } else {
                    $result[$name] = $value;
                }
            }
            foreach ($this->internalDataObjectData['data'] as $name => $value) {
                if (array_key_exists($name, $result) === false) {
                    if ($value instanceof \IvoPetkov\DataObject || $value instanceof DataList) {
                        $result[$name] = $value->toArray();
                    } else {
                        $result[$name] = $value;
                    }
                }
            }
            ksort($result);
        }

        return $result;
    }

    /**
     * Returns the object data converted as JSON
     * 
     * @return string The object data converted as JSON
     */
    public function toJSON(): string
    {
        return json_encode($this->toArray());
    }

}
