<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

$classes = array(
    'IvoPetkov\DataList' => 'src/DataList.php',
    'IvoPetkov\DataListContext' => 'src/DataListContext.php',
    'IvoPetkov\DataObject' => 'src/DataObject.php'
);

spl_autoload_register(function ($class) use ($classes) {
    if (isset($classes[$class])) {
        require __DIR__ . '/' . $classes[$class];
    }
}, true);
