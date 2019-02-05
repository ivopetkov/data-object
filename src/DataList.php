<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * A list of data objects that can be easily filtered, sorted, etc. The objects can be lazy loaded using a callback in the constructor.
 */
class DataList implements \ArrayAccess, \Iterator, \Countable
{

    use \IvoPetkov\DataListTrait;
    use \IvoPetkov\DataListArrayAccessTrait;
    use \IvoPetkov\DataListIteratorTrait;
    use \IvoPetkov\DataListToArrayTrait;
    use \IvoPetkov\DataListToJSONTrait;

    /**
     * Constructs a new data objects list.
     * 
     * @param array|iterable|callback $dataSource An array or an iterable containing objects or arrays that will be converted into data objects or a callback that returns such. The callback option enables lazy data loading.
     * @throws \InvalidArgumentException
     */
    public function __construct($dataSource = null)
    {
        if ($dataSource !== null) {
            $this->setDataSource($dataSource);
        }
    }

}
