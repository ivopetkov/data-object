<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * Information about an action applied on a data list.
 * 
 * @property-read string $name The name of the action.
 */
class DataListAction
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;
    use \IvoPetkov\DataObjectArrayAccessTrait;

    /**
     * 
     * @param string $name The name of the action.
     */
    function __construct(string $name)
    {
        $this->defineProperty('name', [
            'type' => '?string',
            'readonly' => true,
            'get' => function() use ($name) {
                return $name;
            }
        ]);
    }

}
