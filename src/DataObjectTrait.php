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
trait DataObjectTrait
{

    /**
     * An array containing the registered properties and the data set
     * 
     * @var array 
     */
    private $internalDataObjectData = [];

    /**
     * Defines a new property
     * 
     * @param string $name The property name
     * @param array $options The property options ['get'=>callable, 'set'=>callable]
     * @throws \Exception
     */
    protected function defineProperty(string $name, array $options = [])
    {
        $data = [];
        if (isset($options['init'])) {
            if (!is_callable($options['init'])) {
                throw new \Exception('The \'init\' option must be of type callable, ' . gettype($options['init']) . ' given');
            }
            $data[0] = \Closure::bind($options['init'], $this);
        }
        if (isset($options['get'])) {
            if (!is_callable($options['get'])) {
                throw new \Exception('The \'get\' option must be of type callable, ' . gettype($options['get']) . ' given');
            }
            $data[1] = \Closure::bind($options['get'], $this);
        }
        if (isset($options['set'])) {
            if (!is_callable($options['set'])) {
                throw new \Exception('The \'set\' option must be of type callable, ' . gettype($options['set']) . ' given');
            }
            $data[2] = \Closure::bind($options['set'], $this);
        }
        if (isset($options['unset'])) {
            if (!is_callable($options['unset'])) {
                throw new \Exception('The \'unset\' option must be of type callable, ' . gettype($options['unset']) . ' given');
            }
            $data[3] = \Closure::bind($options['unset'], $this);
        }
        if (isset($options['readonly'])) {
            if (!is_bool($options['readonly'])) {
                throw new \Exception('The \'readonly\' option must be of type bool, ' . gettype($options['readonly']) . ' given');
            }
            if ($options['readonly']) {
                $data[4] = true;
            }
        }
        if (isset($options['type'])) {
            if (!is_string($options['type'])) {
                throw new \Exception('The \'type\' option must be of type string, ' . gettype($options['type']) . ' given');
            }
            $data[5] = $options['type'];
        }
        $this->internalDataObjectData['p' . $name] = $data;
    }

    /**
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->internalDataObjectData['p' . $name])) {
            if (isset($this->internalDataObjectData['p' . $name][1])) { // get exists
                return call_user_func($this->internalDataObjectData['p' . $name][1]);
            }
            if (array_key_exists('d' . $name, $this->internalDataObjectData)) {
                return $this->internalDataObjectData['d' . $name];
            }
            if (isset($this->internalDataObjectData['p' . $name][0])) { // init exists
                $this->internalDataObjectData['d' . $name] = call_user_func($this->internalDataObjectData['p' . $name][0]);
                return $this->internalDataObjectData['d' . $name];
            }
            return null;
        }
        if (array_key_exists('d' . $name, $this->internalDataObjectData)) {
            return $this->internalDataObjectData['d' . $name];
        }
        throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $name);
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value): void
    {
        if (isset($this->internalDataObjectData['p' . $name])) {
            if (isset($this->internalDataObjectData['p' . $name][4])) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($this->internalDataObjectData['p' . $name][5])) { // type exists
                $type = $this->internalDataObjectData['p' . $name][5];
                $nullable = false;
                $ok = false;
                if ($type[0] === '?') {
                    if ($value === null) {
                        $ok = true;
                    }
                    $type = substr($type, 1);
                    $nullable = true;
                }
                if (!$ok) {
                    switch ($type) {
                        case 'array':
                            $ok = is_array($value);
                            break;
                        case 'callable':
                            $ok = is_callable($value);
                            break;
                        case 'bool':
                            $ok = is_bool($value);
                            break;
                        case 'float':
                            $ok = is_float($value);
                            break;
                        case 'int':
                            $ok = is_int($value);
                            break;
                        case 'string':
                            $ok = is_string($value);
                            break;
                    }
                }
                if (!$ok) {
                    $ok = class_exists($type) && is_a($value, $type);
                }
                if (!$ok) {
                    $valueType = gettype($value);
                    if (array_search($type, ['array', 'callable', 'bool', 'float', 'int', 'string']) === false) {
                        if ($valueType === 'object') {
                            throw new \Exception('The value of \'' . $name . '\' must be an instance of ' . $type . ($nullable ? ' or null' : '') . ', instance of ' . get_class($value) . ' given');
                        } else {
                            throw new \Exception('The value of \'' . $name . '\' must be an instance of ' . $type . ($nullable ? ' or null' : '') . ', ' . $valueType . ' given');
                        }
                    } else {
                        throw new \Exception('The value of \'' . $name . '\' must be of type ' . $type . ($nullable ? ' or null' : '') . ', ' . $valueType . ' given');
                    }
                }
            }
            if (isset($this->internalDataObjectData['p' . $name][2])) { // set exists
                $this->internalDataObjectData['d' . $name] = call_user_func($this->internalDataObjectData['p' . $name][2], $value);
                if ($this->internalDataObjectData['d' . $name] === null) {
                    unset($this->internalDataObjectData['d' . $name]);
                }
                return;
            }
        }
        $this->internalDataObjectData['d' . $name] = $value;
    }

    /**
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset($name): bool
    {
        if (isset($this->internalDataObjectData['p' . $name])) {
            return $this->$name !== null;
        }
        return isset($this->internalDataObjectData['d' . $name]);
    }

    /**
     * 
     * @param string $name
     */
    public function __unset($name): void
    {
        if (isset($this->internalDataObjectData['p' . $name])) {
            if (isset($this->internalDataObjectData['p' . $name][4])) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($this->internalDataObjectData['p' . $name][3])) { // unset exists
                $this->internalDataObjectData['d' . $name] = call_user_func($this->internalDataObjectData['p' . $name][3]);
                return;
            }
        }
        if (array_key_exists('d' . $name, $this->internalDataObjectData)) {
            unset($this->internalDataObjectData['d' . $name]);
        }
    }

}
