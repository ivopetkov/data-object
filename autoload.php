<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

$classes = array(
    'IvoPetkov\DataList' => 'src/DataList.php',
    'IvoPetkov\DataListAction' => 'src/DataListAction.php',
    'IvoPetkov\DataListActionTrait' => 'src/DataListActionTrait.php',
    'IvoPetkov\DataListArrayAccessTrait' => 'src/DataListArrayAccessTrait.php',
    'IvoPetkov\DataListContext' => 'src/DataListContext.php',
    'IvoPetkov\DataListContextTrait' => 'src/DataListContextTrait.php',
    'IvoPetkov\DataListFilterByAction' => 'src/DataListFilterByAction.php',
    'IvoPetkov\DataListFilterByActionTrait' => 'src/DataListFilterByActionTrait.php',
    'IvoPetkov\DataListIteratorTrait' => 'src/DataListIteratorTrait.php',
    'IvoPetkov\DataListObject' => 'src/DataListObject.php',
    'IvoPetkov\DataListSlicePropertiesAction' => 'src/DataListSlicePropertiesAction.php',
    'IvoPetkov\DataListSlicePropertiesActionTrait' => 'src/DataListSlicePropertiesActionTrait.php',
    'IvoPetkov\DataListSortByAction' => 'src/DataListSortByAction.php',
    'IvoPetkov\DataListSortByActionTrait' => 'src/DataListSortByActionTrait.php',
    'IvoPetkov\DataListToArrayTrait' => 'src/DataListToArrayTrait.php',
    'IvoPetkov\DataListToJSONTrait' => 'src/DataListToJSONTrait.php',
    'IvoPetkov\DataListTrait' => 'src/DataListTrait.php',
    'IvoPetkov\DataObject' => 'src/DataObject.php',
    'IvoPetkov\DataObjectArrayAccessTrait' => 'src/DataObjectArrayAccessTrait.php',
    'IvoPetkov\DataObjectFromArrayTrait' => 'src/DataObjectFromArrayTrait.php',
    'IvoPetkov\DataObjectFromJSONTrait' => 'src/DataObjectFromJSONTrait.php',
    'IvoPetkov\DataObjectToArrayTrait' => 'src/DataObjectToArrayTrait.php',
    'IvoPetkov\DataObjectToJSONTrait' => 'src/DataObjectToJSONTrait.php',
    'IvoPetkov\DataObjectTrait' => 'src/DataObjectTrait.php'
);

spl_autoload_register(function ($class) use ($classes) {
    if (isset($classes[$class])) {
        require __DIR__ . '/' . $classes[$class];
    }
}, true);
