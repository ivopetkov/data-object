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
class DataObject implements \ArrayAccess//, \Iterator
{

    use DataObjectTrait;
    use DataObjectArrayAccessTrait;
    use DataObjectToArrayTrait;
    use DataObjectFromArrayTrait;
    use DataObjectToJSONTrait;
    use DataObjectFromJSONTrait;

    /**
     * Constructs a new data object
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

//    public function rewind()
//    {
//        reset($this->internalDataObjectData);
//    }
//
//    public function current()
//    {
//        $var = current($this->internalDataObjectData);
//        return $var;
//    }
//
//    public function key()
//    {
//        $var = key($this->internalDataObjectData);
//        return $var;
//    }
//
//    public function next()
//    {
//        $var = next($this->internalDataObjectData);
//        return $var;
//    }
//
//    public function valid()
//    {
//        $key = key($this->internalDataObjectData);
//        $var = ($key !== NULL && $key !== FALSE);
//        return $var;
//    }
}
