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
class DataObject implements \ArrayAccess
{

    use DataObjectTrait;

    /**
     * Constructs a new data object
     * 
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->initialize();
        foreach ($data as $name => $value) {
            $this[$name] = $value;
        }
    }

    /**
     * 
     */
    protected function initialize()
    {
        
    }

}
