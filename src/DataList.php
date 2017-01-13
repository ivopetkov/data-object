<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

use IvoPetkov\DataObject;

/**
 * @property-read int $length The number of objects in the list
 */
class DataList implements \ArrayAccess, \Iterator
{

    /**
     * The data source passed to the constructor
     * 
     * @var array 
     */
    private $dataSource = null;

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
     * @param array|iterable|callback $dataSource An array containing DataObjects or arrays that will be converted into DataObjects
     * @throws \InvalidArgumentException
     */
    public function __construct($dataSource = null)
    {
        if ($dataSource !== null && !is_array($dataSource) && !($dataSource instanceof \Traversable) && !is_callable($dataSource)) {
            throw new \InvalidArgumentException('The data argument must be iterable or a callback that returns such data.');
        }
        $this->dataSource = $dataSource;
    }

    /**
     * Converts the data argument into a DataObject if needed
     * 
     * @param \IvoPetkov\DataObject|array $object The data to be converted into a DataObject if needed
     * @return \IvoPetkov\DataObject|null Returns a DataObject or null if the argument is not valid
     * @throws \Exception
     */
    private function makeDataObject($data): \IvoPetkov\DataObject
    {
        if ($data instanceof DataObject) {
            return $data;
        } elseif (is_array($data)) {
            return new DataObject($data);
        }
        throw new \Exception('The data argument is not valid. It must be of type \IvoPetkov\DataObject or array.');
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
        $object = $this->makeDataObject($value);
        if (is_null($offset)) {
            $this->data[] = $object;
            return;
        }
        if (is_int($offset) && $offset >= 0 && (isset($this->data[$offset]) || $offset === sizeof($this->data))) {
            $this->data[$offset] = $object;
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
    public function offsetGet($offset): ?\IvoPetkov\DataObject
    {
        $this->update();
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
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
    public function current(): ?\IvoPetkov\DataObject
    {
        $this->update();
        return isset($this->data[$this->pointer]) ? $this->data[$this->pointer] : null;
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
        if ($this->dataSource !== null) {
            if (is_callable($this->dataSource)) {
                $context = new class {

                    public $filters = [];
                    public $requestedProperties = [];
                };
                foreach ($this->actions as $action) {
                    if ($action[0] === 'filterBy') {
                        $context->filters[] = new DataObject([
                            'property' => $action[1],
                            'value' => $action[2],
                            'operator' => $action[3],
                        ]);
                    }
                }
                $dataSource = call_user_func($this->dataSource, $context);
                if (!is_array($dataSource) && !($dataSource instanceof \Traversable)) {
                    throw new \InvalidArgumentException('The data source callback result is not array, nor iterable');
                }
                $this->dataSource = $dataSource;
                unset($dataSource);
            }
            if (is_array($this->dataSource) || $this->dataSource instanceof \Traversable) {
                foreach ($this->dataSource as $object) {
                    $object = $this->makeDataObject($object);
                    if ($object === null) {
                        $this->data = [];
                        throw new \Exception('The data argument is not valid. It must be of type \IvoPetkov\DataObject or array.');
                    }
                    $this->data[] = $object;
                }
            }
            $this->dataSource = null;
        }
        if (isset($this->actions[0])) {
            foreach ($this->actions as $action) {
                if ($action[0] === 'filter') {
                    $temp = [];
                    foreach ($this->data as $index => $object) {
                        if (call_user_func($action[1], $object) === true) {
                            $temp[] = $object;
                        }
                    }
                    $this->data = $temp;
                    unset($temp);
                } else if ($action[0] === 'filterBy') {
                    $temp = [];
                    foreach ($this->data as $object) {
                        $value = $object[$action[1]];
                        $targetValue = $action[2];
                        $operator = $action[3];
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
                        if ($add) {
                            $temp[] = $object;
                        }
                    }
                    $this->data = $temp;
                    unset($temp);
                } elseif ($action[0] === 'sort') {
                    usort($this->data, $action[1]);
                } elseif ($action[0] === 'sortBy') {
                    usort($this->data, function($object1, $object2) use ($action) {
                        return strcmp($object1[$action[1]], $object2[$action[1]]) * ($action[2] === 'asc' ? 1 : -1);
                    });
                } elseif ($action[0] === 'reverse') {
                    $this->data = array_reverse($this->data);
                } elseif ($action[0] === 'map') {
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
            throw new \Exception('The length property is readonly');
        }
        throw new \Exception('Invalid property (' . (string) $name . ')');
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
        throw new \Exception('Invalid property (' . (string) $name . ')');
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
            throw new \Exception('Cannot unset the length property');
        }
        throw new \Exception('Invalid property (' . (string) $name . ')');
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
        $object = $this->makeDataObject($object);
        array_unshift($this->data, $object);
        return $this;
    }

    /**
     * Shift an object off the beginning of the list
     * 
     * @return \IvoPetkov\DataObject|null Returns the shifted object or null if the list is empty
     */
    public function shift(): ?\IvoPetkov\DataObject
    {
        $this->update();
        return array_shift($this->data);
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
        $object = $this->makeDataObject($object);
        array_push($this->data, $object);
        return $this;
    }

    /**
     * Pops an object off the end of the list
     * 
     * @return \IvoPetkov\DataObject|null Returns the poped object or null if the list is empty
     */
    public function pop(): ?\IvoPetkov\DataObject
    {
        $this->update();
        return array_pop($this->data);
    }

    /**
     * Extract a slice of the list
     * 
     * @return \IvoPetkov\DataList Returns a slice of the list
     */
    public function slice(int $offset, $length = null): \IvoPetkov\DataList
    {
        $this->update();
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
        $result = [];
        foreach ($this->data as $object) {
            $result[] = $object->toArray();
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
