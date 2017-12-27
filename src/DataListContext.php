<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * 
 */
class DataListContext
{

    /**
     *
     * @var array 
     */
    public $filterByProperties = [];

    /**
     *
     * @var array 
     */
    public $sortByProperties = [];
    
    /**
     *
     * @var array 
     */
    public $requestedProperties = [];

}
