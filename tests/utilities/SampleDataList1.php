<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleDataList1
{

    use \IvoPetkov\DataListTrait;

    public function __construct($dataSource)
    {
        $this->registerDataListClass('IvoPetkov\DataListContext', 'SampleDataList1Context');
        $this->registerDataListClass('IvoPetkov\DataListFilterByAction', 'SampleDataList1FilterByAction');
        $this->registerDataListClass('IvoPetkov\DataListSortByAction', 'SampleDataList1SortByAction');
        $this->registerDataListClass('IvoPetkov\DataListAction', 'SampleDataList1Action');
        $this->registerDataListClass('IvoPetkov\DataListSlicePropertiesAction', 'SampleDataList1SlicePropertiesAction');
        $this->setDataSource($dataSource);
    }

}
