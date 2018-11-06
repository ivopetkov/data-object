<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * Information about a sliceProperties action applied on a data list.
 * 
 * @property-read array $properties The properties list.
 */
class DataListSlicePropertiesAction extends \IvoPetkov\DataListAction
{

    /**
     * 
     * @param array $properties The properties list.
     */
    function __construct(array $properties)
    {
        parent::__construct('sliceProperties');
        $this
                ->defineProperty('properties', [
                    'type' => '?array',
                    'readonly' => true,
                    'get' => function() use ($properties) {
                        return $properties;
                    }
        ]);
    }

}
