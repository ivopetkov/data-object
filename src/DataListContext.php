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
     * Returns a DataList containing all the actions.
     * 
     * @return \IvoPetkov\DataList|\IvoPetkov\DataListAction[]|\IvoPetkov\DataListFilterByAction[]|\IvoPetkov\DataListSlicePropertiesAction[]|\IvoPetkov\DataListSortByAction[] A DataList containing all the actions.
     */
    public function getActions()
    {
        return new \IvoPetkov\DataList($this->actions);
    }

}
