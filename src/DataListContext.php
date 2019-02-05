<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * Information about the actions applied on a data list.
 */
class DataListContext
{

    /**
     *
     * @var array 
     */
    private $actions = [];

    /**
     * Array containing the data list actions.
     * 
     * @param array $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }

    /**
     * Returns an array containing all the actions.
     * 
     * @return array An array containing all the actions.
     */
    public function getActions()
    {
        return $this->actions;
    }

}
