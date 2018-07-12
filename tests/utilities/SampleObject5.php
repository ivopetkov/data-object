<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleObject5 extends \IvoPetkov\DataObject
{

    function __construct()
    {
        $this->defineProperty('property1', [
            'type' => 'DateTime',
            'init' => function() {
                return new DateTime("2222-11-11T11:11:11+00:00");
            }
        ]);
        parent::__construct();
    }

}
