<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

class DataObjectTestCase extends PHPUnit\Framework\TestCase
{

    function setUp()
    {
        require __DIR__ . '/../vendor/autoload.php';
        require __DIR__ . '/SampleClasses.php';
    }

}

class DataObjectAutoloaderTestCase extends PHPUnit\Framework\TestCase
{

    function setUp()
    {
        require __DIR__ . '/../autoload.php';
        require __DIR__ . '/SampleClasses.php';
    }

}
