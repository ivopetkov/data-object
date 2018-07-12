<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleObject8 extends \IvoPetkov\DataObject
{

    function __construct()
    {
        parent::__construct();
        $this
                ->defineProperty('property1', [
                    'type' => '?string'
                ])
                ->defineProperty('property2', [
                    'type' => '?string',
                    'encodeInJSON' => true
        ]);
    }

}
