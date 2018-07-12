<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleObject3 extends \IvoPetkov\DataObject
{

    function __construct(array $data = array())
    {
        $this->defineProperty('prop1', [
            'type' => 'ArrayObject'
        ]);
        parent::__construct($data);
    }

}
