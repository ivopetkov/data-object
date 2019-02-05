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
 */
class DataListSortByAction extends \IvoPetkov\DataListAction
{

    /**
     *
     * @var string The property name used for the sort.
     */
    public $property = null;

    /**
     *
     * @var string The sort order. Available values: asc and desc.
     */
    public $order = null;

}
