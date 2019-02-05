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
trait DataListContextTrait
{

    /**
     *
     * @var array 
     */
    private $internalDataListContextActions = [];

    /**
     * Array containing the data list actions.
     * 
     * @param array $actions
     */
    public function setActions(array $actions)
    {
        $this->internalDataListContextActions = $actions;
    }

    /**
     * Returns an array containing all the actions.
     * 
     * @return array An array containing all the actions.
     */
    public function getActions()
    {
        return $this->internalDataListContextActions;
    }

}
