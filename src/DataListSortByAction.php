<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * Information about a sortBy action applied on a data list.
 * 
 * @property-read string $property The property name used for the sort.
 * @property-read string $order The sort order. Available values: asc and desc.
 */
class DataListSortByAction extends \IvoPetkov\DataListAction
{

    /**
     * 
     * @param string $property The property name used for the sort.
     * @param string $order The sort order. Available values: asc and desc.
     */
    function __construct(string $property, string $order)
    {
        parent::__construct('sortBy');
        $this
                ->defineProperty('property', [
                    'type' => '?string',
                    'readonly' => true,
                    'get' => function() use ($property) {
                        return $property;
                    }
                ])
                ->defineProperty('order', [
                    'type' => '?string',
                    'readonly' => true,
                    'get' => function() use ($order) {
                        return $order;
                    }
        ]);
    }

}
