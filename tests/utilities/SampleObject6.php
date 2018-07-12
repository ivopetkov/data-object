<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleObject6 extends \IvoPetkov\DataObject
{

    function __construct()
    {
        $this->defineProperty('property1', [
            'type' => '?DateTime'
        ]);
        parent::__construct();
    }

}
