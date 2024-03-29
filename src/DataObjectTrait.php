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
trait DataObjectTrait
{

    /**
     * An array containing the registered properties and the data set.
     * 
     * @var array 
     */
    private $internalDataObjectData = ['p' => [], 'd' => [], 'c' => []]; // properties, data, callables index

    /**
     * Defines a new property. Use closures with $this->privateProperty instead of local variables in the constructor (thay cannot be cloned).
     * 
     * @param string $name The property name.
     * @param array $options The property options. Available values: 
     *   init (callable)
     *   get (callable)
     *   set (callable)
     *   unset (callable)
     *   readonly (boolean)
     *   type (string)
     *   encodeInJSON (boolean) - Base64 encode the value of the property when it's json encoded (in toJSON() for example). The default value is FALSE.
     * @throws \InvalidArgumentException
     * @return self Returns a reference to the object.
     */
    protected function defineProperty(string $name, array $options = [])
    {
        $data = [];
        if (isset($options['init'])) {
            if (!is_callable($options['init'])) {
                throw new \InvalidArgumentException('The \'init\' option must be of type callable, ' . gettype($options['init']) . ' given');
            }
            $data[1] = $options['init'];
            $this->internalDataObjectData['c'][] = [$name, 1];
        }
        if (isset($options['get'])) {
            if (!is_callable($options['get'])) {
                throw new \InvalidArgumentException('The \'get\' option must be of type callable, ' . gettype($options['get']) . ' given');
            }
            $data[2] = $options['get'];
            $this->internalDataObjectData['c'][] = [$name, 2];
        }
        if (isset($options['set'])) {
            if (!is_callable($options['set'])) {
                throw new \InvalidArgumentException('The \'set\' option must be of type callable, ' . gettype($options['set']) . ' given');
            }
            $data[3] = $options['set'];
            $this->internalDataObjectData['c'][] = [$name, 3];
        }
        if (isset($options['unset'])) {
            if (!is_callable($options['unset'])) {
                throw new \InvalidArgumentException('The \'unset\' option must be of type callable, ' . gettype($options['unset']) . ' given');
            }
            $data[4] = $options['unset'];
            $this->internalDataObjectData['c'][] = [$name, 4];
        }
        if (isset($options['readonly'])) {
            if (!is_bool($options['readonly'])) {
                throw new \InvalidArgumentException('The \'readonly\' option must be of type bool, ' . gettype($options['readonly']) . ' given');
            }
            if ($options['readonly']) {
                $data[5] = true;
            }
        }
        if (isset($options['type'])) {
            if (!is_string($options['type'])) {
                throw new \InvalidArgumentException('The \'type\' option must be of type string, ' . gettype($options['type']) . ' given');
            }
            $type = $data[6] = $options['type'];
            if ($type[0] !== '?') {
                if (isset($data[1]) || isset($data[2], $data[4])) {
                    // has init or get and unset callbacks
                } elseif ($type === 'array') {
                    $data[0] = function () {
                        return [];
                    };
                } elseif ($type === 'float') {
                    $data[0] = function () {
                        return 0.0;
                    };
                } elseif ($type === 'int') {
                    $data[0] = function () {
                        return 0;
                    };
                } elseif ($type === 'string') {
                    $data[0] = function () {
                        return '';
                    };
                } else {
                    $data[0] = function () use ($type, $name) {
                        if (class_exists($type)) {
                            return new $type();
                        } else {
                            throw new \InvalidArgumentException('Cannot find a class named \'' . $type . '\' for the default value of \'' . $name . '\'.');
                        }
                    };
                }
            }
        }
        if (isset($options['encodeInJSON'])) {
            if (!is_bool($options['encodeInJSON'])) {
                throw new \InvalidArgumentException('The \'encodeInJSON\' option must be of type bool, ' . gettype($options['encodeInJSON']) . ' given');
            }
            if ($options['encodeInJSON']) {
                $data[7] = true;
            }
        }
        $this->internalDataObjectData['p'][$name] = $data;
        return $this;
    }

    /**
     * 
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function &__get($name)
    {
        if (isset($this->internalDataObjectData['p'][$name])) {
            $propertyDefinition = $this->internalDataObjectData['p'][$name];
            if (isset($propertyDefinition[2])) { // get exists
                $value = call_user_func($propertyDefinition[2]);
                return $value; // Only variable references should be returned by reference
            }
            if (array_key_exists($name, $this->internalDataObjectData['d'])) {
                return $this->internalDataObjectData['d'][$name];
            }
            if (isset($propertyDefinition[1])) { // init exists
                $this->internalDataObjectData['d'][$name] = call_user_func($propertyDefinition[1]);
                return $this->internalDataObjectData['d'][$name];
            }
            if (isset($propertyDefinition[0])) { // default init exists
                $this->internalDataObjectData['d'][$name] = call_user_func($propertyDefinition[0]);
                return $this->internalDataObjectData['d'][$name];
            }
            $value = null;
            return $value; // Only variable references should be returned by reference
        }
        if (array_key_exists($name, $this->internalDataObjectData['d'])) {
            return $this->internalDataObjectData['d'][$name];
        }
        throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $name);
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    public function __set($name, $value): void
    {
        if (isset($this->internalDataObjectData['p'][$name])) {
            $propertyDefinition = $this->internalDataObjectData['p'][$name];
            if (isset($propertyDefinition[5])) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($propertyDefinition[6])) { // type exists
                $type = $propertyDefinition[6];
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
                            if (!$ok && is_int($value)) {
                                $ok = true;
                                $value = (float)$value;
                            }
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
                    $ok = interface_exists($type) && is_a($value, $type);
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
            if (isset($propertyDefinition[3])) { // set exists
                $this->internalDataObjectData['d'][$name] = call_user_func($propertyDefinition[3], $value);
                if ($this->internalDataObjectData['d'][$name] === null) {
                    unset($this->internalDataObjectData['d'][$name]);
                }
                return;
            }
        }
        $this->internalDataObjectData['d'][$name] = $value;
    }

    /**
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset($name): bool
    {
        if (isset($this->internalDataObjectData['p'][$name])) {
            return $this->$name !== null;
        }
        return isset($this->internalDataObjectData['d'][$name]);
    }

    /**
     * 
     * @param string $name
     */
    public function __unset($name): void
    {
        if (isset($this->internalDataObjectData['p'][$name])) {
            $propertyDefinition = $this->internalDataObjectData['p'][$name];
            if (isset($propertyDefinition[5])) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($propertyDefinition[4])) { // unset exists
                $this->internalDataObjectData['d'][$name] = call_user_func($propertyDefinition[4]);
                return;
            }
        }
        if (array_key_exists($name, $this->internalDataObjectData['d'])) {
            unset($this->internalDataObjectData['d'][$name]);
        }
    }

    /**
     * 
     */
    public function __clone()
    {
        foreach ($this->internalDataObjectData['c'] as $data) {
            $value = $this->internalDataObjectData['p'][$data[0]][$data[1]];
            if ($value instanceof \Closure) {
                $this->internalDataObjectData['p'][$data[0]][$data[1]] = \Closure::bind($value, $this);
            }
        }
    }
}
