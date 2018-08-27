<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * Information about a filterBy action applied on a data list.
 * 
 * @property-read string $property The property name used for the filter.
 * @property-read string $value The value to filter on.
 * @property-read string $operator The operator used for the filter. Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith, inArray, notInArray.
 */
class DataListFilterByAction extends \IvoPetkov\DataListAction
{

    /**
     * 
     * @param string $name The name of the action.
     * @param string $property The property name used for the filter.
     * @param string $value The value to filter on.
     * @param string $operator The operator used for the filter. Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith, inArray, notInArray.
     */
    function __construct(string $name, string $property, string $value, string $operator)
    {
        parent::__construct($name);
        $this
                ->defineProperty('property', [
                    'type' => '?string',
                    'readonly' => true,
                    'get' => function() use ($property) {
                        return $property;
                    }
                ])
                ->defineProperty('value', [
                    'type' => '?string',
                    'readonly' => true,
                    'get' => function() use ($value) {
                        return $value;
                    }
                ])
                ->defineProperty('operator', [
                    'type' => '?string',
                    'readonly' => true,
                    'get' => function() use ($operator) {
                        return $operator;
                    }
        ]);
    }

}
