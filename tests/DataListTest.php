<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

use IvoPetkov\DataList;
use IvoPetkov\DataObject;

/**
 * @runTestsInSeparateProcesses
 */
class DataListTest extends DataListTestCase
{

    /**
     *
     */
    public function testConstructor()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'c');
        $this->assertTrue($list->length === 3);
        foreach ($list as $i => $object) {
            $this->assertTrue($object->value === $data[$i]['value']);
        }
    }

    /**
     *
     */
    public function testUpdate()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'c');
        $list[2] = new DataObject(['value' => 'cc']);
        $this->assertTrue($list[2]->value === 'cc');
        $list[3] = new DataObject(['value' => 'dd']);
        $this->assertTrue($list[3]->value === 'dd');
        $list[4] = new DataObject(['value' => 'ee']);
        $this->assertTrue($list[4]->value === 'ee');
        $this->assertTrue(isset($list[4]));
        $list[] = new DataObject(['value' => 'ff']);
        $this->assertTrue($list[5]->value === 'ff');

        $this->assertFalse(isset($list[6]));

        $this->setExpectedException('\Exception');
        $list[7] = new DataObject(['value' => 'gg']);
    }

    /**
     *
     */
    public function testUnset()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'c');
        unset($list[1]);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'c');
    }

    /**
     *
     */
    public function testFilter()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $list->filter(function($object) {
            return $object->value !== 'b';
        });
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'c');
    }

    /**
     *
     */
    public function testFilterBy()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'c');
        $this->assertTrue($list[0]->value === 'c');
    }

    /**
     *
     */
    public function testSort()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $list->sort(function($object1, $object2) {
            return strcmp($object1->value, $object2->value);
        });
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'c');

        $list->sort(function($object1, $object2) {
            return strcmp($object1->value, $object2->value) * -1;
        });
        $this->assertTrue($list[0]->value === 'c');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'a');
    }

    /**
     *
     */
    public function testSortBy()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $list->sortBy('value');
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'c');
        $list->sortBy('value', 'desc');
        $this->assertTrue($list[0]->value === 'c');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'a');
    }

    /**
     *
     */
    public function testLength()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $this->assertTrue(isset($list->length));
        $list->pop();
        $this->assertTrue($list->length === 2);
    }

    /**
     *
     */
    public function testShiftAndUnshift()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $this->assertTrue($list->length === 3);
        $object = $list->shift();
        $this->assertTrue($object->value === 'a');
        $this->assertTrue($list->length === 2);
        $list->unshift(['value' => 'a']);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list->length === 3);
    }

    /**
     *
     */
    public function testPopAndPush()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $this->assertTrue($list->length === 3);
        $object = $list->pop();
        $this->assertTrue($object->value === 'c');
        $this->assertTrue($list->length === 2);
        $list->push(['value' => 'c']);
        $this->assertTrue($list[2]->value === 'c');
        $this->assertTrue($list->length === 3);
    }

    /**
     *
     */
    public function testReverse()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $list->reverse();
        $this->assertTrue($list[0]->value === 'c');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'a');

        $list->push(['value' => 'd']);
        $list->reverse();
        $this->assertTrue($list[0]->value === 'd');
        $this->assertTrue($list[1]->value === 'a');
        $this->assertTrue($list[2]->value === 'b');
        $this->assertTrue($list[3]->value === 'c');
    }

    /**
     *
     */
    public function testMap()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $list->map(function($object) {
            $object->value .= $object->value;
            return $object;
        });
        $this->assertTrue($list[0]->value === 'aa');
        $this->assertTrue($list[1]->value === 'bb');
        $this->assertTrue($list[2]->value === 'cc');
    }

    /**
     *
     */
    public function testToArray()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $array = $list->toArray();
        $this->assertTrue($array === $data);
    }

    /**
     *
     */
    public function testToJSON()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c']
        ];
        $list = new DataList($data);
        $json = $list->toJSON();
        $expectedResult = '[{"value":"a"},{"value":"b"},{"value":"c"}]';
        $this->assertTrue($json === $expectedResult);
    }

    /**
     *
     */
    public function testExceptions1()
    {
        $this->setExpectedException('Exception');
        new DataList([1, 2, 3]);
    }

    /**
     *
     */
    public function testExceptions2()
    {
        $dataList = new DataList();
        $this->setExpectedException('Exception');
        $dataList[false] = ['key' => 'value'];
    }

    /**
     *
     */
    public function testExceptions3()
    {
        $dataList = new DataList();
        $this->setExpectedException('Exception');
        $dataList[0] = 5;
    }

    /**
     *
     */
    public function testExceptions4()
    {
        $dataList = new DataList();
        $this->setExpectedException('Exception');
        $dataList->missing = 5;
    }

    /**
     *
     */
    public function testExceptions5()
    {
        $dataList = new DataList();
        $this->setExpectedException('Exception');
        echo $dataList->missing;
    }

    /**
     *
     */
    public function testExceptions6()
    {
        $dataList = new DataList();
        $this->setExpectedException('Exception');
        $dataList->length = 5;
    }

    /**
     *
     */
    public function testExceptions7()
    {
        $dataList = new DataList();
        $this->setExpectedException('Exception');
        $dataList->sortBy('name', 1);
    }

    /**
     *
     */
    public function testExceptions8()
    {
        $dataList = new DataList();
        $this->setExpectedException('Exception');
        $dataList->unshift(5);
    }

    /**
     *
     */
    public function testExceptions9()
    {
        $dataList = new DataList();
        $this->setExpectedException('Exception');
        $dataList->push(5);
    }

    /**
     *
     */
    public function testIsset()
    {
        $dataList = new DataList();
        $this->assertTrue(isset($dataList->length));
        $this->assertFalse(isset($dataList->missing));
    }

}
