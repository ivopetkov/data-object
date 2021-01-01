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

    public function __construct($dataSource = null)
    {
        $this->registerDataListClass('IvoPetkov\DataListContext', 'SampleDataList1Context');
        $this->registerDataListClass('IvoPetkov\DataListFilterAction', 'SampleDataList1FilterAction');
        $this->registerDataListClass('IvoPetkov\DataListFilterByAction', 'SampleDataList1FilterByAction');
        $this->registerDataListClass('IvoPetkov\DataListMapAction', 'SampleDataList1MapAction');
        $this->registerDataListClass('IvoPetkov\DataListReverseAction', 'SampleDataList1ReverseAction');
        $this->registerDataListClass('IvoPetkov\DataListShuffleAction', 'SampleDataList1ShuffleAction');
        $this->registerDataListClass('IvoPetkov\DataListSortAction', 'SampleDataList1SortAction');
        $this->registerDataListClass('IvoPetkov\DataListSortByAction', 'SampleDataList1SortByAction');
        $this->registerDataListClass('IvoPetkov\DataListSlicePropertiesAction', 'SampleDataList1SlicePropertiesAction');
        $this->registerDataListClass('IvoPetkov\DataListSliceAction', 'SampleDataList1SliceAction');
        if ($dataSource !== null) {
            $this->setDataSource($dataSource);
        }
    }
}
