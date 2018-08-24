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
class DataObject implements \ArrayAccess
{

    use DataObjectTrait;
    use DataObjectArrayAccessTrait;
    use DataObjectToArrayTrait;
    use DataObjectFromArrayTrait;
    use DataObjectToJSONTrait;
    use DataObjectFromJSONTrait;

    /**
     * Constructs a new data object.
     * 
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->initialize();
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * 
     */
    protected function initialize()
    {
        
    }

}
