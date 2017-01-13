<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

class DataListTestCase extends PHPUnit_Framework_TestCase
{

    function setUp()
    {
        require __DIR__ . '/../vendor/autoload.php';
    }

}

class DataListAutoloaderTestCase extends PHPUnit_Framework_TestCase
{

    function setUp()
    {
        require __DIR__ . '/../autoload.php';
    }

}
