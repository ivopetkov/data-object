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
trait DataListTrait
{

    /**
     * The list data objects.
     * 
     * @var array 
     */
    private $internalDataListData = [];

    /**
     * The pointer when the list is iterated.
     * 
     * @var int
     */
    private $internalDataListPointer = 0;

    /**
     * The list of actions (sort, filter, etc.) that must be applied to the list.
     * 
     * @var array 
     */
    private $internalDataListActions = [];

    /**
     *
     * @var array 
     */
    private $internalDataListClasses = [
        'IvoPetkov\DataListContext' => 'IvoPetkov\DataListContext',
        'IvoPetkov\DataListFilterAction' => 'IvoPetkov\DataListFilterAction',
        'IvoPetkov\DataListFilterByAction' => 'IvoPetkov\DataListFilterByAction',
        'IvoPetkov\DataListMapAction' => 'IvoPetkov\DataListMapAction',
        'IvoPetkov\DataListReverseAction' => 'IvoPetkov\DataListReverseAction',
        'IvoPetkov\DataListShuffleAction' => 'IvoPetkov\DataListShuffleAction',
        'IvoPetkov\DataListSortAction' => 'IvoPetkov\DataListSortAction',
        'IvoPetkov\DataListSortByAction' => 'IvoPetkov\DataListSortByAction',
        'IvoPetkov\DataListSlicePropertiesAction' => 'IvoPetkov\DataListSlicePropertiesAction',
        'IvoPetkov\DataListSliceAction' => 'IvoPetkov\DataListSliceAction',
        'IvoPetkov\DataListObject' => 'IvoPetkov\DataListObject',
    ];

    /**
     * Sets a new data source for the list.
     * 
     * @param array|iterable|callback $dataSource An array or an iterable containing objects or arrays that will be converted into data objects or a callback that returns such. The callback option enables lazy data loading.
     * @throws \InvalidArgumentException
     */
    protected function setDataSource($dataSource)
    {
        if (is_array($dataSource) || $dataSource instanceof \Traversable) {
            foreach ($dataSource as $value) {
                $this->internalDataListData[] = $value;
            }
            return;
        }
        if (is_callable($dataSource)) {
            $this->internalDataListData = $dataSource;
            return;
        }
        throw new \InvalidArgumentException('The data argument must be iterable or a callback that returns such data.');
    }

    /**
     * 
     * @param string $baseClass
     * @param string $newClass
     */
    protected function registerDataListClass(string $baseClass, string $newClass)
    {
        $this->internalDataListClasses[$baseClass] = $newClass;
    }

    /**
     * Returns the object at the index specified or null if not found.
     * 
     * @param int $index The index of the item.
     * @return object|null The object at the index specified or null if not found.
     * @throws \InvalidArgumentException
     */
    public function get(int $index)
    {
        $this->internalDataListUpdate();
        if (isset($this->internalDataListData[$index])) {
            return $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, $index);
        }
        return null;
    }

    /**
     * Returns the first object or null if not found.
     * 
     * @return object|null The first object or null if not found.
     * @throws \InvalidArgumentException
     */
    public function getFirst()
    {
        $this->internalDataListUpdate();
        if (isset($this->internalDataListData[0])) {
            return $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, 0);
        }
        return null;
    }

    /**
     * Returns the last object or null if not found.
     * 
     * @return object|null The last object or null if not found.
     * @throws \InvalidArgumentException
     */
    public function getLast()
    {
        $this->internalDataListUpdate();
        $count = count($this->internalDataListData);
        if (isset($this->internalDataListData[$count - 1])) {
            return $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, $count - 1);
        }
        return null;
    }

    /**
     * Returns a random object from the list or null if the list is empty.
     * 
     * @return object|null A random object from the list or null if the list is empty.
     * @throws \InvalidArgumentException
     */
    public function getRandom()
    {
        $this->internalDataListUpdate();
        $count = count($this->internalDataListData);
        if ($count > 0) {
            $index = rand(0, $count - 1);
            if (isset($this->internalDataListData[$index])) {
                return $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, $index);
            }
        }
        return null;
    }

    /**
     * Filters the elements of the list using a callback function.
     * 
     * @param callable $callback The callback function to use.
     * @return self A reference to the list.
     */
    public function filter(callable $callback): self
    {
        $this->internalDataListActions[] = ['filter', $callback];
        return $this;
    }

    /**
     * Filters the elements of the list by specific property value.
     * 
     * @param string $property The property name.
     * @param mixed $value The value of the property.
     * @param string $operator Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, startWithAny, endWith, notEndWith, endWithAny, inArray, notInArray, textSearch.
     * @return self A reference to the list.
     * @throws \InvalidArgumentException
     */
    public function filterBy(string $property, $value, string $operator = 'equal'): self
    {
        if (!in_array($operator, ['equal', 'notEqual', 'regExp', 'notRegExp', 'startWith', 'notStartWith', 'startWithAny', 'endWith', 'notEndWith', 'endWithAny', 'inArray', 'notInArray', 'textSearch'])) {
            throw new \InvalidArgumentException('Invalid operator specified (' . $operator . ')');
        }
        $this->internalDataListActions[] = ['filterBy', $property, $value, $operator];
        return $this;
    }

    /**
     * Sorts the elements of the list using a callback function.
     * 
     * @param callable $callback The callback function to use.
     * @return self A reference to the list.
     */
    public function sort(callable $callback): self
    {
        $this->internalDataListActions[] = ['sort', $callback];
        return $this;
    }

    /**
     * Sorts the elements of the list by specific property.
     * 
     * @param string $property The property name.
     * @param string $order The sort order. Available values: asc and desc
     * @return self A reference to the list.
     * @throws \InvalidArgumentException
     */
    public function sortBy(string $property, string $order = 'asc'): self
    {
        if ($order !== 'asc' && $order !== 'desc') {
            throw new \InvalidArgumentException('Invalid order specified (' . $order . ')');
        }
        $this->internalDataListActions[] = ['sortBy', $property, $order];
        return $this;
    }

    /**
     * Reverses the order of the objects in the list.
     * 
     * @return self A reference to the list.
     */
    public function reverse(): self
    {
        $this->internalDataListActions[] = ['reverse'];
        return $this;
    }

    /**
     * Randomly reorders the objects in the list.
     * 
     * @return self A reference to the list.
     */
    public function shuffle(): self
    {
        $this->internalDataListActions[] = ['shuffle'];
        return $this;
    }

    /**
     * Applies the callback to the objects of the list.
     * 
     * @param callable $callback The callback function to use.
     * @return self A reference to the list.
     */
    public function map(callable $callback): self
    {
        $this->internalDataListActions[] = ['map', $callback];
        return $this;
    }

    /**
     * Prepends an object to the beginning of the list.
     * 
     * @param object|array $object The data to be prepended.
     * @return self A reference to the list.
     * @throws \InvalidArgumentException
     */
    public function unshift($object): self
    {
        $this->internalDataListUpdate();
        array_unshift($this->internalDataListData, $object);
        return $this;
    }

    /**
     * Shift an object off the beginning of the list.
     * 
     * @return object|null Returns the shifted object or null if the list is empty.
     * @throws \InvalidArgumentException
     */
    public function shift()
    {
        $this->internalDataListUpdate();
        if (isset($this->internalDataListData[0])) {
            $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, 0);
            return array_shift($this->internalDataListData);
        }
        return null;
    }

    /**
     * Pushes an object onto the end of the list.
     * 
     * @param object|array $object The data to be pushed.
     * @return self A reference to the list.
     * @throws \InvalidArgumentException
     */
    public function push($object): self
    {
        $this->internalDataListUpdate();
        array_push($this->internalDataListData, $object);
        return $this;
    }

    /**
     * Pops an object off the end of the list.
     * 
     * @return object|null Returns the popped object or null if the list is empty.
     * @throws \InvalidArgumentException
     */
    public function pop()
    {
        $this->internalDataListUpdate();
        if (isset($this->internalDataListData[0])) {
            $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, count($this->internalDataListData) - 1);
            return array_pop($this->internalDataListData);
        }
        return null;
    }

    /**
     * Appends the items of the list provided to the current list.
     * 
     * @param array|iterable $list A list to append after the current one.
     * @return self A reference to the list.
     * @throws \InvalidArgumentException
     */
    public function concat($list): self
    {
        $this->internalDataListUpdate();
        foreach ($list as $object) {
            array_push($this->internalDataListData, $object);
        }
        return $this;
    }

    /**
     * Extract a slice of the list.
     * 
     * @param int $offset The index position where the extraction should begin
     * @param int|null $length The max length of the items in the extracted slice.
     * @return mixed Returns a slice of the list.
     * @throws \InvalidArgumentException
     */
    public function slice(int $offset, ?int $length = null)
    {
        $actions = $this->internalDataListActions;
        $actions[] = ['slice', $offset, $length];
        $data = $this->internalDataListUpdateData($this->internalDataListData, $actions);
        $slice = array_slice($data, $offset, $length);
        $className = get_class($this);
        $list = new $className();
        foreach ($slice as $object) {
            $list->push($object);
        }
        return $list;
    }

    /**
     * Returns a new list of object that contain only the specified properties of the objects in the current list.
     * 
     * @param array $properties The list of property names.
     * @return mixed Returns a new list.
     */
    public function sliceProperties(array $properties)
    {
        $actions = $this->internalDataListActions;
        $actions[] = ['sliceProperties', $properties];
        $data = $this->internalDataListUpdateData($this->internalDataListData, $actions);
        $className = get_class($this);
        $list = new $className();
        $class = $this->internalDataListClasses['IvoPetkov\DataListObject'];
        $tempObject = new $class();
        foreach ($data as $index => $object) {
            $object = $this->internalDataListUpdateValueIfNeeded($data, $index);
            $newObject = clone ($tempObject);
            foreach ($properties as $property) {
                $newObject[$property] = isset($object->$property) ? $object->$property : null;
            }
            $list->push($newObject);
        }
        return $list;
    }

    /**
     * Returns the number of items in the list.
     * 
     * @return int
     */
    public function count(): int
    {
        $this->internalDataListUpdate();
        return count($this->internalDataListData);
    }

    /**
     * Converts the value into object if needed.
     * 
     * @param int $index
     */
    private function internalDataListUpdateValueIfNeeded(&$data, $index)
    {
        $value = $data[$index];
        if (is_callable($value)) {
            $value = call_user_func($value);
            $data[$index] = $value;
        }
        if (is_object($value)) {
            return $value;
        }
        $value = (object) $value;
        $data[$index] = $value;
        return $value;
    }

    /**
     * Converts all values into objects if needed.
     */
    private function internalDataListUpdateAllValuesIfNeeded(&$data)
    {
        foreach ($data as $index => $value) {
            $this->internalDataListUpdateValueIfNeeded($data, $index);
        }
    }

    /**
     * Applies the pending actions to the data list.
     * 
     * @throws \InvalidArgumentException
     */
    private function internalDataListUpdate()
    {
        $this->internalDataListData = $this->internalDataListUpdateData($this->internalDataListData, $this->internalDataListActions);
        $this->internalDataListActions = [];
    }

    /**
     * Applies the actions to the data list provided.
     * 
     * @param mixed $data
     * @param array $actions
     * @throws \InvalidArgumentException
     * @return array Returns the updated data
     */
    private function internalDataListUpdateData($data, $actions): array
    {
        if (!empty($actions)) {
            $optimizedActions = [];
            $actionsToOptimize = [];
            $optimizeAndAddActions = function () use (&$optimizedActions, &$actionsToOptimize): bool { // return false if conflicting actions and result is empty
                if (!empty($actionsToOptimize)) {
                    $removeLessOrMoreSpecificPrefixes = function (bool $less, array $prefixes, bool $fromStart) {
                        $prefixes = array_values(array_unique($prefixes));
                        if ($fromStart) {
                            if ($less) {
                                rsort($prefixes);
                            } else {
                                sort($prefixes);
                            }
                        } else {
                            if ($less) {
                                usort($prefixes, function ($a, $b) {
                                    return strcmp(strrev($b), strrev($a));
                                });
                            } else {
                                usort($prefixes, function ($a, $b) {
                                    return strcmp(strrev($a), strrev($b));
                                });
                            }
                        }
                        $result = [];
                        $previous = null;
                        foreach ($prefixes as $prefix) {
                            if ($fromStart) {
                                if ($previous === null || ($less ? !str_starts_with($previous, $prefix) : !str_starts_with($prefix, $previous))) {
                                    $result[] = $prefix;
                                    $previous = $prefix;
                                }
                            } else {
                                if ($previous === null || ($less ? !str_ends_with($previous, $prefix) : str_ends_with($prefix, $previous))) {
                                    $result[] = $prefix;
                                    $previous = $prefix;
                                }
                            }
                        }
                        return $result;
                    };
                    $removeMatchingPrefixes = function (array $prefixes1, array $prefixes2, bool $fromStart) { // Removes all prefixes from $prefixes1 that exist in $prefixes2
                        $result = [];
                        foreach ($prefixes1 as $prefix1) {
                            $found = false;
                            foreach ($prefixes2 as $prefix2) {
                                if ($fromStart) {
                                    if (str_starts_with($prefix1, $prefix2)) {
                                        $found = true;
                                        break;
                                    }
                                } else {
                                    if (str_ends_with($prefix1, $prefix2)) {
                                        $found = true;
                                        break;
                                    }
                                }
                            }
                            if (!$found) {
                                $result[] = $prefix1;
                            }
                        }
                        return $result;
                    };
                    $removeMissingPrefixes = function (array $prefixes1, array $prefixes2, bool $fromStart) { // Removes all prefixes from $prefixes1 that do not exist in $prefixes2
                        $result = [];
                        foreach ($prefixes1 as $prefix1) {
                            $found = false;
                            foreach ($prefixes2 as $prefix2) {
                                if ($fromStart) {
                                    if (str_starts_with($prefix1, $prefix2)) {
                                        $found = true;
                                        break;
                                    }
                                } else {
                                    if (str_ends_with($prefix1, $prefix2)) {
                                        $found = true;
                                        break;
                                    }
                                }
                            }
                            if ($found) {
                                $result[] = $prefix1;
                            }
                        }
                        return $result;
                    };
                    $startWith = [];
                    $notStartWith = [];
                    $endWith = [];
                    $notEndWith = [];
                    $targetProperty = null;
                    foreach ($actionsToOptimize as $actionToOptimize) {
                        if ($targetProperty === null) {
                            $targetProperty = $actionToOptimize[1];
                        }
                        if ($actionToOptimize[3] === 'startWith') {
                            $startWith[] = $actionToOptimize[2];
                        } elseif ($actionToOptimize[3] === 'notStartWith') {
                            $notStartWith[] = $actionToOptimize[2];
                        } elseif ($actionToOptimize[3] === 'endWith') {
                            $endWith[] = $actionToOptimize[2];
                        } elseif ($actionToOptimize[3] === 'notEndWith') {
                            $notEndWith[] = $actionToOptimize[2];
                        } else {
                            throw new \Exception('Should not get here for ' . $actionToOptimize[3]);
                        }
                    }
                    if (!empty($notStartWith)) {
                        $notStartWith = $removeLessOrMoreSpecificPrefixes(false, $notStartWith, true);
                    }
                    if (!empty($startWith)) {
                        $startWith = $removeLessOrMoreSpecificPrefixes(true, $startWith, true);
                        if (count($startWith) > 1) { // impossible case
                            return false;
                        }
                        $startWith = $removeMatchingPrefixes($startWith, $notStartWith, true);
                        if (sizeof($startWith) === 0) { // confict with notStartWith
                            return false;
                        }
                        $notStartWith = $removeMissingPrefixes($notStartWith, $startWith, true);
                    }
                    if (!empty($notEndWith)) {
                        $notEndWith = $removeLessOrMoreSpecificPrefixes(false, $notEndWith, false);
                    }
                    if (!empty($endWith)) {
                        $endWith = $removeLessOrMoreSpecificPrefixes(true, $endWith, false);
                        if (count($endWith) > 1) { // impossible case
                            return false;
                        }
                        $endWith = $removeMatchingPrefixes($endWith, $notEndWith, false);
                        if (sizeof($endWith) === 0) { // confict with notEndWith
                            return false;
                        }
                        $notEndWith = $removeMissingPrefixes($notEndWith, $endWith, false);
                    }
                    foreach ($startWith as $value) {
                        $optimizedActions[] = ['filterBy', $targetProperty, $value, 'startWith'];
                    }
                    foreach ($notStartWith as $value) {
                        $optimizedActions[] = ['filterBy', $targetProperty, $value, 'notStartWith'];
                    }
                    foreach ($endWith as $value) {
                        $optimizedActions[] = ['filterBy', $targetProperty, $value, 'endWith'];
                    }
                    foreach ($notEndWith as $value) {
                        $optimizedActions[] = ['filterBy', $targetProperty, $value, 'notEndWith'];
                    }
                }
                return true;
            };
            foreach ($actions as $action) {
                $canBeOptimized = false;
                if ($action[0] === 'filterBy') {
                    if (in_array($action[3], ['startWith', 'notStartWith', 'endWith', 'notEndWith'])) {
                        if (empty($actionsToOptimize)) {
                            $canBeOptimized = true;
                        } else {
                            foreach ($actionsToOptimize as $actionToOptimize) {
                                if ($action[1] === $actionToOptimize[1]) { // if the same property
                                    $canBeOptimized = true;
                                    break;
                                }
                            }
                        }
                        if ($canBeOptimized) {
                            $actionsToOptimize[] = $action;
                        }
                    }
                }
                if (!$canBeOptimized) {
                    if (!$optimizeAndAddActions()) {
                        return [];
                    }
                    $actionsToOptimize = [];
                    $optimizedActions[] = $action;
                }
            }
            if (!$optimizeAndAddActions()) {
                return [];
            }
            $actions = $optimizedActions;
        }
        if (is_callable($data)) {
            $actionsList = [];
            foreach ($actions as $actionData) {
                if ($actionData[0] === 'filter') {
                    $class = $this->internalDataListClasses['IvoPetkov\DataListFilterAction'];
                    $action = new $class();
                    $action->callback = $actionData[1];
                } elseif ($actionData[0] === 'filterBy') {
                    $class = $this->internalDataListClasses['IvoPetkov\DataListFilterByAction'];
                    $action = new $class();
                    $action->property = $actionData[1];
                    $action->value = $actionData[2];
                    $action->operator = $actionData[3];
                } else if ($actionData[0] === 'sort') {
                    $class = $this->internalDataListClasses['IvoPetkov\DataListSortAction'];
                    $action = new $class();
                    $action->callback = $actionData[1];
                } elseif ($actionData[0] === 'sortBy') {
                    $class = $this->internalDataListClasses['IvoPetkov\DataListSortByAction'];
                    $action = new $class();
                    $action->property = $actionData[1];
                    $action->order = $actionData[2];
                } elseif ($actionData[0] === 'sliceProperties') {
                    $class = $this->internalDataListClasses['IvoPetkov\DataListSlicePropertiesAction'];
                    $action = new $class();
                    $action->properties = $actionData[1];
                } elseif ($actionData[0] === 'reverse') {
                    $class = $this->internalDataListClasses['IvoPetkov\DataListReverseAction'];
                    $action = new $class();
                } elseif ($actionData[0] === 'slice') {
                    $class = $this->internalDataListClasses['IvoPetkov\DataListSliceAction'];
                    $action = new $class();
                    $action->offset = $actionData[1];
                    $action->limit = $actionData[2];
                } elseif ($actionData[0] === 'shuffle') {
                    $class = $this->internalDataListClasses['IvoPetkov\DataListShuffleAction'];
                    $action = new $class();
                } else if ($actionData[0] === 'map') {
                    $class = $this->internalDataListClasses['IvoPetkov\DataListMapAction'];
                    $action = new $class();
                    $action->callback = $actionData[1];
                } else {
                    throw new \Exception('Should not get here for "' . $actionData[0] . '" action!');
                }
                $action->name = $actionData[0];
                $actionsList[] = $action;
            }
            $class = $this->internalDataListClasses['IvoPetkov\DataListContext'];
            $context = new $class();
            $context->actions = $actionsList;
            $dataSource = call_user_func($data, $context);
            if (is_array($dataSource) || $dataSource instanceof \Traversable) {
                $data = [];
                foreach ($dataSource as $value) {
                    $data[] = $value;
                }
            } else {
                throw new \InvalidArgumentException('The data source callback result is not iterable!');
            }
        }

        if (!empty($actions)) {
            $sortAndSerializeArray = function ($data) {
                $walkData = function ($data) use (&$walkData) {
                    $result = [];
                    foreach ($data as $key => $value) {
                        if (is_array($value)) {
                            $value = $walkData($value);
                        }
                        $result[$key] = $value;
                    }
                    ksort($result);
                    return $result;
                };
                return serialize($walkData($data));
            };

            foreach ($actions as $action) {
                if ($action[0] === 'filter') {
                    $this->internalDataListUpdateAllValuesIfNeeded($data);
                    $temp = [];
                    foreach ($data as $object) {
                        if (call_user_func($action[1], $object) === true) {
                            $temp[] = $object;
                        }
                    }
                    $data = $temp;
                    unset($temp);
                } else if ($action[0] === 'filterBy') {
                    $propertyName = $action[1];
                    $targetValue = $action[2];
                    $operator = $action[3];
                    $this->internalDataListUpdateAllValuesIfNeeded($data);
                    $temp = [];
                    foreach ($data as $object) {
                        $add = false;
                        if (!isset($object->$propertyName)) {
                            if ($operator === 'equal' && $targetValue === null) {
                                $add = true;
                            } elseif ($operator === 'notEqual' && $targetValue !== null) {
                                $add = true;
                            } elseif ($operator === 'inArray' && is_array($targetValue) && in_array(null, $targetValue)) {
                                $add = true;
                            } elseif ($operator === 'notInArray' && !(is_array($targetValue) && in_array(null, $targetValue))) {
                                $add = true;
                            } else {
                                continue;
                            }
                        }
                        if (!$add) {
                            $value = $object->$propertyName;
                            if ($operator === 'equal') {
                                if (is_array($value) && is_array($targetValue)) {
                                    $add = $sortAndSerializeArray($value) === $sortAndSerializeArray($targetValue);
                                } else {
                                    $add = $value === $targetValue;
                                }
                            } elseif ($operator === 'notEqual') {
                                if (is_array($value) && is_array($targetValue)) {
                                    $add = $sortAndSerializeArray($value) !== $sortAndSerializeArray($targetValue);
                                } else {
                                    $add = $value !== $targetValue;
                                }
                            } elseif ($operator === 'regExp') {
                                if (is_string($targetValue)) {
                                    $add = preg_match('/' . $targetValue . '/', $value) === 1;
                                } else {
                                    throw new \Exception('The target value for ' . $operator . ' must be of type string!');
                                }
                            } elseif ($operator === 'notRegExp') {
                                if (is_string($targetValue)) {
                                    $add = preg_match('/' . $targetValue . '/', $value) === 0;
                                } else {
                                    throw new \Exception('The target value for ' . $operator . ' must be of type string!');
                                }
                            } elseif ($operator === 'startWith') {
                                if (is_string($targetValue)) {
                                    $add = str_starts_with($value, $targetValue);
                                } else {
                                    throw new \Exception('The target value for ' . $operator . ' must be of type string!');
                                }
                            } elseif ($operator === 'notStartWith') {
                                if (is_string($targetValue)) {
                                    $add = !str_starts_with($value, $targetValue);
                                } else {
                                    throw new \Exception('The target value for ' . $operator . ' must be of type string!');
                                }
                            } elseif ($operator === 'startWithAny') {
                                $add = false;
                                if (is_array($targetValue)) {
                                    foreach ($targetValue as $targetValueItem) {
                                        if (str_starts_with($value, $targetValueItem)) {
                                            $add = true;
                                            break;
                                        }
                                    }
                                } else {
                                    throw new \Exception('The target value for ' . $operator . ' must be of type array!');
                                }
                            } elseif ($operator === 'endWith') {
                                if (is_string($targetValue)) {
                                    $add = str_ends_with($value, $targetValue);
                                } else {
                                    throw new \Exception('The target value for ' . $operator . ' must be of type string!');
                                }
                            } elseif ($operator === 'notEndWith') {
                                if (is_string($targetValue)) {
                                    $add = !str_ends_with($value, $targetValue);
                                } else {
                                    throw new \Exception('The target value for ' . $operator . ' must be of type string!');
                                }
                            } elseif ($operator === 'endWithAny') {
                                $add = false;
                                if (is_array($targetValue)) {
                                    foreach ($targetValue as $targetValueItem) {
                                        if (str_ends_with($value, $targetValueItem)) {
                                            $add = true;
                                            break;
                                        }
                                    }
                                } else {
                                    throw new \Exception('The target value for ' . $operator . ' must be of type array!');
                                }
                            } elseif ($operator === 'inArray') {
                                $add = is_array($targetValue) && in_array($value, $targetValue);
                            } elseif ($operator === 'notInArray') {
                                $add = !(is_array($targetValue) && in_array($value, $targetValue));
                            } elseif ($operator === 'textSearch') {
                                if (is_string($targetValue)) {
                                    $add = is_string($value) && mb_strpos(mb_strtolower($value), mb_strtolower($targetValue)) !== false;
                                } else {
                                    throw new \Exception('The target value for ' . $operator . ' must be of type string!');
                                }
                            }
                        }
                        if ($add) {
                            $temp[] = $object;
                        }
                    }
                    $data = $temp;
                    unset($temp);
                } elseif ($action[0] === 'sort') {
                    $this->internalDataListUpdateAllValuesIfNeeded($data);
                    usort($data, $action[1]);
                } elseif ($action[0] === 'sortBy') {
                    $this->internalDataListUpdateAllValuesIfNeeded($data);
                    $sortData = []; // save the index and the property needed for the sort in a temp array
                    foreach ($data as $index => $object) {
                        $sortValue = isset($object->{$action[1]}) ? $object->{$action[1]} : null;
                        if (is_object($sortValue)) {
                            if ($sortValue instanceof \DateTime) {
                                $sortValue = $sortValue->getTimestamp();
                            } else {
                                $sortValue = null;
                            }
                        }
                        $sortData[] = [$index, $sortValue];
                    }
                    usort($sortData, function ($value1SortData, $value2SortData) use ($action) {
                        if ($value1SortData[1] === null && $value2SortData[1] === null) {
                            $result = 0;
                        } else {
                            if ($value1SortData[1] === null) {
                                return $action[2] === 'asc' ? -1 : 1;
                            }
                            if ($value2SortData[1] === null) {
                                return $action[2] === 'asc' ? 1 : -1;
                            }
                            if ((is_int($value1SortData[1]) || is_float($value1SortData[1])) && (is_int($value2SortData[1]) || is_float($value2SortData[1]))) {
                                $result = $value1SortData[1] < $value2SortData[1] ? -1 : 1;
                            } else {
                                $result = strcmp($value1SortData[1], $value2SortData[1]);
                            }
                        }
                        if ($result === 0) { // if the sort property is the same, maintain the order by index
                            return $value1SortData[0] - $value2SortData[0];
                        }
                        return $result * ($action[2] === 'asc' ? 1 : -1);
                    });
                    $temp = [];
                    foreach ($sortData as $sortedValueData) {
                        $temp[] = $data[$sortedValueData[0]];
                    }
                    unset($sortData);
                    $data = $temp;
                    unset($temp);
                } elseif ($action[0] === 'reverse') {
                    $data = array_reverse($data);
                } elseif ($action[0] === 'shuffle') {
                    shuffle($data);
                } elseif ($action[0] === 'map') {
                    $this->internalDataListUpdateAllValuesIfNeeded($data);
                    $data = array_map($action[1], $data);
                }
            }
        }
        return $data;
    }

    /**
     * 
     */
    public function __clone()
    {
        $data = $this->internalDataListData;
        if (is_callable($data)) {
            if ($data instanceof \Closure) {
                $data = \Closure::bind($data, $this);
            }
        } elseif (is_array($data)) {
            foreach ($data as $index => $item) {
                if (is_object($item)) {
                    $data[$index] = clone ($item);
                }
            }
        }
        $this->internalDataListData = $data;
    }
}
