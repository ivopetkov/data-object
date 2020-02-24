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
trait DataListSortByActionTrait
{

    /**
     * The property name used for the sort.
     * 
     * @var string
     */
    public $property = null;

    /**
     * The sort order. Available values: asc and desc.
     * 
     * @var string
     */
    public $order = null;
}
