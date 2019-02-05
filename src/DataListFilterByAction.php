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
 */
class DataListFilterByAction extends \IvoPetkov\DataListAction
{

    /**
     *
     * @var string The property name used for the filter.
     */
    public $property = null;

    /**
     *
     * @var string The value to filter on.
     */
    public $value = null;

    /**
     *
     * @var string The operator used for the filter. Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith, inArray, notInArray.
     */
    public $operator = null;

}
