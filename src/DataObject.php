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
class DataObject implements \ArrayAccess
{

    /**
     * The object data
     * 
     * @var array 
     */
    private $data = [];

    /**
     * The registered object properties
     * 
     * @var array 
     */
    private $properties = [];

    /**
     * Constructs a new data object
     * 
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->initialize();
        $this->data = $data;
    }

    /**
     * 
     */
    protected function initialize()
    {
        
    }

    /**
     * 
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getPropertyValue($offset);
    }

    /**
     * 
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if (!is_null($offset)) {
            $this->setPropertyValue($offset, $value);
        }
    }

    /**
     * 
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return $this->isPropertyValueSet($offset);
    }

    /**
     * 
     * @param string $offset
     */
    public function offsetUnset($offset): void
    {
        $this->unsetPropertyValue($offset);
    }

    /**
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getPropertyValue($name);
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value): void
    {
        $this->setPropertyValue($name, $value);
    }

    /**
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset($name): bool
    {
        return $this->isPropertyValueSet($name);
    }

    /**
     * 
     * @param string $name
     */
    public function __unset($name): void
    {
        $this->unsetPropertyValue($name);
    }

    /**
     * 
     * @param string $name
     * @return mixed
     */
    private function getPropertyValue($name)
    {
        if (isset($this->properties[$name]) && isset($this->properties[$name][1])) { // get exists
            return call_user_func($this->properties[$name][1]);
        }
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            if (isset($this->properties[$name]) && isset($this->properties[$name][0])) { // init exists
                $this->data[$name] = call_user_func($this->properties[$name][0]);
                return $this->data[$name];
            }
            return null;
        }
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     */
    private function setPropertyValue($name, $value)
    {
        if (isset($this->properties[$name])) {
            if ($this->properties[$name][4]) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($this->properties[$name][2])) { // set exists
                $this->data[$name] = call_user_func($this->properties[$name][2], $value);
                return;
            }
        }
        $this->data[$name] = $value;
    }

    /**
     * 
     * @param string $name
     * @return boolean
     */
    private function isPropertyValueSet($name): bool
    {
        return isset($this->properties[$name]) || array_key_exists($name, $this->data);
    }

    /**
     * 
     * @param string $name
     */
    private function unsetPropertyValue($name): void
    {
        if (isset($this->properties[$name])) {
            if ($this->properties[$name][4]) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($this->properties[$name][3])) { // unset exists
                $this->data[$name] = call_user_func($this->properties[$name][3]);
                if ($this->data[$name] === null) {
                    unset($this->data[$name]);
                }
                return;
            }
        }
        if (array_key_exists($name, $this->data)) {
            unset($this->data[$name]);
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
        $this->properties[$name] = [
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
        foreach ($this->properties as $name => $temp) {
            $value = $this->getPropertyValue($name);
            if ($value instanceof \IvoPetkov\DataObject || $value instanceof \IvoPetkov\DataList) {
                $result[$name] = $value->toArray();
            } else {
                $result[$name] = $value;
            }
        }
        foreach ($this->data as $name => $value) {
            if (array_key_exists($name, $result) === false) {
                if ($value instanceof \IvoPetkov\DataObject || $value instanceof \IvoPetkov\DataList) {
                    $result[$name] = $value->toArray();
                } else {
                    $result[$name] = $value;
                }
            }
        }
        ksort($result);
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
