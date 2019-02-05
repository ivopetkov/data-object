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
trait DataListFilterByActionTrait
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
