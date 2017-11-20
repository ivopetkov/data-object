<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

use IvoPetkov\DataObject;
use IvoPetkov\DataListContext;

/**
 * @property-read int $length The number of objects in the list
 */
class DataList implements \ArrayAccess, \Iterator
{

    /**
     * The list data objects
     * 
     * @var array 
     */
    private $data = [];

    /**
     * The pointer when the list is iterated with foreach 
     * 
     * @var int
     */
    private $pointer = 0;

    /**
     * The list of actions (sort, filter, etc.) that must be applied to the list
     * 
     * @var array 
     */
    private $actions = [];

    /**
     * Constructs a new Data objects list
     * 
     * @param array|iterable|callback $dataSource An array containing object or arrays that will be converted into objects
     * @throws \InvalidArgumentException
     */
    public function __construct($dataSource = null)
    {
        if ($dataSource !== null) {
            if (is_array($dataSource) || $dataSource instanceof \Traversable) {
                foreach ($dataSource as $value) {
                    $this->data[] = $value;
                }
                return;
            }
            if (is_callable($dataSource)) {
                $this->data = $dataSource;
                return;
            }
            throw new \InvalidArgumentException('The data argument must be iterable or a callback that returns such data.');
        }
    }

    /**
     * Converts the value into object if needed
     * @param int $index
     */
    private function updateValueIfNeeded($index)
    {
        $value = $this->data[$index];
        if (is_callable($value)) {
            $value = call_user_func($value);
            $this->data[$index] = $value;
        }
        if (is_object($value)) {
            return $value;
        }
        $value = (object) $value;
        $this->data[$index] = $value;
        return $value;
    }

    /**
     * Converts all values into objects if needed
     */
    private function updateAllValuesIfNeeded()
    {
        foreach ($this->data as $index => $value) {
            $this->updateValueIfNeeded($index);
        }
    }

    /**
     * 
     * @param int $offset
     * @param \IvoPetkov\DataObject|null $value
     * @return void
     * @throws \Exception
     */
    public function offsetSet($offset, $value): void
    {
        if (!is_int($offset) && $offset !== null) {
            throw new \Exception('The offset must be of type int or null');
        }
        $this->update();
        if (is_null($offset)) {
            $this->data[] = $value;
            return;
        }
        if (is_int($offset) && $offset >= 0 && (isset($this->data[$offset]) || $offset === sizeof($this->data))) {
            $this->data[$offset] = $value;
            return;
        }
        throw new \Exception('The offset is not valid.');
    }

    /**
     * 
     * @param int $offset
     * @return boolean
     * @throws \Exception
     */
    public function offsetExists($offset): bool
    {
        $this->update();
        return isset($this->data[$offset]);
    }

    /**
     * 
     * @param int $offset
     * @throws \Exception
     */
    public function offsetUnset($offset): void
    {
        $this->update();
        if (isset($this->data[$offset])) {
            unset($this->data[$offset]);
            $this->data = array_values($this->data);
        }
    }

    /**
     * 
     * @param int $offset
     * @return \IvoPetkov\DataObject|null
     * @throws \Exception
     */
    public function offsetGet($offset)
    {
        $this->update();
        if (isset($this->data[$offset])) {
            return $this->updateValueIfNeeded($offset);
        }
        return null;
    }

    /**
     * 
     */
    public function rewind(): void
    {
        $this->pointer = 0;
    }

    /**
     * 
     * @return \IvoPetkov\DataObject|null
     */
    public function current()
    {
        $this->update();
        if (isset($this->data[$this->pointer])) {
            return $this->updateValueIfNeeded($this->pointer);
        }
        return null;
    }

    /**
     * 
     * @return int
     */
    public function key(): int
    {
        return $this->pointer;
    }

    /**
     * 
     */
    public function next(): void
    {
        ++$this->pointer;
    }

    /**
     * 
     * @return boolean
     */
    public function valid(): bool
    {
        $this->update();
        return isset($this->data[$this->pointer]);
    }

    /**
     * Applies the pending actions to the Data Object
     */
    private function update(): void
    {
        if (is_callable($this->data)) {
            $context = new DataListContext();
            $contextActionsIndexes = [];
            foreach ($this->actions as $index => $action) {
                if ($action[0] === 'filterBy') {
                    $contextActionsIndexes[$index] = 'filterBy' . sizeof($context->filterByProperties);
                    $context->filterByProperties[] = new DataObject([
                        'property' => $action[1],
                        'value' => $action[2],
                        'operator' => $action[3],
                        'applied' => false
                    ]);
                } elseif ($action[0] === 'sortBy') {
                    $contextActionsIndexes[$index] = 'sortBy' . sizeof($context->sortByProperties);
                    $context->sortByProperties[] = new DataObject([
                        'property' => $action[1],
                        'order' => $action[2],
                        'applied' => false
                    ]);
                }
            }
            $dataSource = call_user_func($this->data, $context);
            $hasRemovedActions = false;
            foreach ($context->filterByProperties as $index => $object) {
                if ($object->applied) {
                    $actionIndex = array_search('filterBy' . $index, $contextActionsIndexes);
                    if ($actionIndex !== false) {
                        unset($this->actions[$actionIndex]);
                        $hasRemovedActions = true;
                    }
                }
            }
            foreach ($context->sortByProperties as $index => $object) {
                if ($object->applied) {
                    $actionIndex = array_search('sortBy' . $index, $contextActionsIndexes);
                    if ($actionIndex !== false) {
                        unset($this->actions[$actionIndex]);
                        $hasRemovedActions = true;
                    }
                }
            }
            if ($hasRemovedActions) {
                $this->actions = array_values($this->actions);
            }
            if (is_array($dataSource) || $dataSource instanceof \Traversable) {
                $this->data = [];
                foreach ($dataSource as $value) {
                    $this->data[] = $value;
                }
            } else {
                throw new \InvalidArgumentException('The data source callback result is not iterable');
            }
        }
        if (isset($this->actions[0])) {
            foreach ($this->actions as $action) {
                if ($action[0] === 'filter') {
                    $this->updateAllValuesIfNeeded();
                    $temp = [];
                    foreach ($this->data as $index => $object) {
                        if (call_user_func($action[1], $object) === true) {
                            $temp[] = $object;
                        }
                    }
                    $this->data = $temp;
                    unset($temp);
                } else if ($action[0] === 'filterBy') {
                    $this->updateAllValuesIfNeeded();
                    $temp = [];
                    foreach ($this->data as $object) {
                        $propertyName = $action[1];
                        $targetValue = $action[2];
                        $operator = $action[3];
                        $add = false;
                        if (!isset($object->$propertyName)) {
                            if ($operator === 'equal' && $targetValue === null) {
                                $add = true;
                            } elseif ($operator === 'notEqual' && $targetValue !== null) {
                                $add = true;
                            } else {
                                continue;
                            }
                        }
                        if (!$add) {
                            $value = $object->$propertyName;
                            if ($operator === 'equal') {
                                $add = $value === $targetValue;
                            } elseif ($operator === 'notEqual') {
                                $add = $value !== $targetValue;
                            } elseif ($operator === 'regExp') {
                                $add = preg_match('/' . $targetValue . '/', $value) === 1;
                            } elseif ($operator === 'notRegExp') {
                                $add = preg_match('/' . $targetValue . '/', $value) === 0;
                            } elseif ($operator === 'startWith') {
                                $add = substr($value, 0, strlen($targetValue)) === $targetValue;
                            } elseif ($operator === 'notStartWith') {
                                $add = substr($value, 0, strlen($targetValue)) !== $targetValue;
                            } elseif ($operator === 'endWith') {
                                $add = substr($value, -strlen($targetValue)) === $targetValue;
                            } elseif ($operator === 'notEndWith') {
                                $add = substr($value, -strlen($targetValue)) !== $targetValue;
                            }
                        }
                        if ($add) {
                            $temp[] = $object;
                        }
                    }
                    $this->data = $temp;
                    unset($temp);
                } elseif ($action[0] === 'sort') {
                    $this->updateAllValuesIfNeeded();
                    usort($this->data, $action[1]);
                } elseif ($action[0] === 'sortBy') {
                    $this->updateAllValuesIfNeeded();
                    usort($this->data, function($object1, $object2) use ($action) {
                        if (!isset($object1->{$action[1]})) {
                            return $action[2] === 'asc' ? -1 : 1;
                        }
                        if (!isset($object2->{$action[1]})) {
                            return $action[2] === 'asc' ? 1 : -1;
                        }
                        return strcmp($object1->{$action[1]}, $object2->{$action[1]}) * ($action[2] === 'asc' ? 1 : -1);
                    });
                } elseif ($action[0] === 'reverse') {
                    $this->data = array_reverse($this->data);
                } elseif ($action[0] === 'map') {
                    $this->updateAllValuesIfNeeded();
                    $this->data = array_map($action[1], $this->data);
                }
            }
            $this->actions = [];
        }
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    public function __set(string $name, $value): void
    {
        if ($name === 'length') {
            throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
        }
        throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $name);
    }

    /**
     * 
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get(string $name)
    {
        if ($name === 'length') {
            $this->update();
            return sizeof($this->data);
        }
        throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $name);
    }

    /**
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset(string $name): bool
    {
        if ($name === 'length') {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param string $name
     * @throws \Exception
     */
    public function __unset(string $name): void
    {
        if ($name === 'length') {
            throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
        }
        throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $name);
    }

    /**
     * 
     * @return array
     */
    public function __debugInfo(): array
    {
        return $this->toArray();
    }

    /**
     * Filters the elements of the list using a callback function
     * 
     * @param callable $callback The callback function to use
     * @return \IvoPetkov\DataList Returns a reference to the list
     * @throws \Exception
     */
    public function filter(callable $callback): \IvoPetkov\DataList
    {
        $this->actions[] = ['filter', $callback];
        return $this;
    }

    /**
     * Filters the elements of the list by specific property value
     * 
     * @param string $property The property name
     * @param mixed $value The value of the property
     * @param string $operator equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith
     * @return \IvoPetkov\DataList Returns a reference to the list
     * @throws \Exception
     */
    public function filterBy(string $property, $value, $operator = 'equal'): \IvoPetkov\DataList
    {
        if (array_search($operator, ['equal', 'notEqual', 'regExp', 'notRegExp', 'startWith', 'notStartWith', 'endWith', 'notEndWith']) === false) {
            throw new \Exception('Invalid operator (' . $operator . ')');
        }
        $this->actions[] = ['filterBy', $property, $value, $operator];
        return $this;
    }

    /**
     * Sorts the elements of the list using a callback function 
     * 
     * @param callable $callback The callback function to use
     * @return \IvoPetkov\DataList Returns a reference to the list
     * @throws \Exception
     */
    public function sort(callable $callback): \IvoPetkov\DataList
    {
        $this->actions[] = ['sort', $callback];
        return $this;
    }

    /**
     * Sorts the elements of the list by specific property
     * 
     * @param string $property The property name
     * @param string $order The sort order
     * @return \IvoPetkov\DataList Returns a reference to the list
     * @throws \Exception
     */
    public function sortBy(string $property, string $order = 'asc'): \IvoPetkov\DataList
    {
        if ($order !== 'asc' && $order !== 'desc') {
            throw new \Exception('The order argument \'asc\' or \'desc\'');
        }
        $this->actions[] = ['sortBy', $property, $order];
        return $this;
    }

    /**
     * Reverses the order of the objects in the list
     * 
     * @return \IvoPetkov\DataList Returns a reference to the list
     */
    public function reverse(): \IvoPetkov\DataList
    {
        $this->actions[] = ['reverse'];
        return $this;
    }

    /**
     * Applies the callback to the objects of the list
     * 
     * @param callable $callback The callback function to use
     * @return \IvoPetkov\DataList Returns a reference to the list
     * @throws \Exception
     */
    public function map(callable $callback): \IvoPetkov\DataList
    {
        $this->actions[] = ['map', $callback];
        return $this;
    }

    /**
     * Prepends an object to the beginning of the list
     * 
     * @param \IvoPetkov\DataObject|array $object The data to be prepended
     * @return \IvoPetkov\DataList Returns a reference to the list
     * @throws Exception
     */
    public function unshift($object): \IvoPetkov\DataList
    {
        $this->update();
        array_unshift($this->data, $object);
        return $this;
    }

    /**
     * Shift an object off the beginning of the list
     * 
     * @return \IvoPetkov\DataObject|null Returns the shifted object or null if the list is empty
     */
    public function shift()
    {
        $this->update();
        if (isset($this->data[0])) {
            $this->updateValueIfNeeded(0);
            return array_shift($this->data);
        }
        return null;
    }

    /**
     * Pushes an object onto the end of the list
     * 
     * @param \IvoPetkov\DataObject|array $object The data to be pushed
     * @return \IvoPetkov\DataList Returns a reference to the list
     * @throws Exception
     */
    public function push($object): \IvoPetkov\DataList
    {
        $this->update();
        array_push($this->data, $object);
        return $this;
    }

    /**
     * Pops an object off the end of the list
     * 
     * @return \IvoPetkov\DataObject|null Returns the poped object or null if the list is empty
     */
    public function pop()
    {
        $this->update();
        if (isset($this->data[0])) {
            $this->updateValueIfNeeded(sizeof($this->data) - 1);
            return array_pop($this->data);
        }
        return null;
    }

    /**
     * Extract a slice of the list
     * 
     * @return \IvoPetkov\DataList Returns a slice of the list
     */
    public function slice(int $offset, $length = null): \IvoPetkov\DataList
    {
        $this->update();
//        for ($i = $offset; $i < $offset + $length; $i++) {
//            if (isset($this->data[$i])) {
//                $this->updateValueIfNeeded($i);
//            }
//        }
        $slice = array_slice($this->data, $offset, $length);
        $className = get_class($this);
        return new $className($slice);
    }

    /**
     * Returns the list data converted as an array
     * 
     * @return array The list data converted as an array
     */
    public function toArray(): array
    {
        $this->update();

        $toArray = function($object) use (&$toArray) {
            $result = [];
            $vars = get_object_vars($object);
            foreach ($vars as $name => $value) {
                if ($name !== 'internalDataObjectData') {
                    $reflectionProperty = new \ReflectionProperty($object, $name);
                    if ($reflectionProperty->isPublic()) {
                        $result[$name] = null;
                    }
                }
            }
            if (isset($object->internalDataObjectData)) {
                foreach ($object->internalDataObjectData as $name => $value) {
                    $result[substr($name, 1)] = null;
                }
            }
            ksort($result);
            foreach ($result as $name => $null) {
                $value = $object->$name;
                if (is_object($value)) {
                    if (method_exists($value, 'toArray')) {
                        $result[$name] = $value->toArray();
                    } else {
                        $propertyVars = $toArray($value);
                        foreach ($propertyVars as $propertyVarName => $propertyVarValue) {
                            if (is_object($propertyVarValue)) {
                                $propertyVars[$propertyVarName] = $toArray($propertyVarValue);
                            }
                        }
                        $result[$name] = $propertyVars;
                    }
                } else {
                    $result[$name] = $value;
                }
            }
            return $result;
        };

        $result = [];
        foreach ($this->data as $index => $object) {
            $object = $this->updateValueIfNeeded($index);
            if (method_exists($object, 'toArray')) {
                $result[] = $object->toArray();
            } else {
                $result[] = $toArray($object);
            }
        }
        return $result;
    }

    /**
     * Returns the list data converted as JSON
     * 
     * @return string The list data converted as JSON
     */
    public function toJSON(): string
    {
        return json_encode($this->toArray());
    }

}
