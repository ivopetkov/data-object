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
    public function testConstructor1()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            function() {
                return ['value' => 'c'];
            }
        ];
        $expectedData = [
            'a',
            'b',
            'c'
        ];
        $list = new DataList($data);
        $this->assertTrue($list[0]->value === $expectedData[0]);
        $this->assertTrue($list[1]->value === $expectedData[1]);
        $this->assertTrue($list[2]->value === $expectedData[2]);
        $this->assertTrue($list->length === 3);
        foreach ($list as $i => $object) {
            $this->assertTrue($object->value === $expectedData[$i]);
        }
    }

    /**
     *
     */
    public function testConstructor2()
    {
        $function = function() {
            return [
                ['value' => 'a'],
                ['value' => 'b'],
                function() {
                    return ['value' => 'c'];
                }
            ];
        };
        $list = new DataList($function);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'c');
        $this->assertTrue($list->length === 3);
    }

    /**
     *
     */
    public function testUpdate()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            function() {
                return ['value' => 'c'];
            }
        ];
        $list = new DataList($data);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'c');
        $list[2] = function () {
            return ['value' => 'cc'];
        };
        $this->assertTrue($list[2]->value === 'cc');
        $list[3] = ['value' => 'dd'];
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
            function() {
                return ['value' => 'c'];
            },
            function() {
                return ['value' => 'd'];
            }
        ];
        $list = new DataList($data);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'c');
        unset($list[1]);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'c');
        unset($list[1]);
        unset($list[3]);
        $this->assertTrue($list[0]->value === 'a');
    }

    /**
     *
     */
    public function testFilter()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            function() {
                return ['value' => 'c'];
            }
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
            function() {
                return ['value' => 'c'];
            },
            ['value' => null],
            ['other' => 1]
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'c');
        $this->assertTrue($list[0]->value === 'c');
        $this->assertTrue($list->length === 1);

        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            function() {
                return ['value' => 'c'];
            },
            ['value' => null],
            ['other' => 1]
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'c', 'notEqual');
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === null);
        $this->assertTrue($list[3]->other === 1);
        $this->assertTrue($list->length === 4);

        $data = [
            ['value' => 'a1'],
            ['value' => 'b2'],
            function() {
                return ['value' => 'c'];
            }
        ];
        $list = new DataList($data);
        $list->filterBy('value', '[0-9]{1}', 'regExp');
        $this->assertTrue($list[0]->value === 'a1');
        $this->assertTrue($list[1]->value === 'b2');
        $this->assertTrue($list->length === 2);

        $data = [
            ['value' => 'a1'],
            ['value' => 'b2'],
            function() {
                return ['value' => 'c'];
            }
        ];
        $list = new DataList($data);
        $list->filterBy('value', '[0-9]{1}', 'notRegExp');
        $this->assertTrue($list[0]->value === 'c');
        $this->assertTrue($list->length === 1);

        $data = [
            ['value' => 'aaa'],
            ['value' => 'baaa'],
            function() {
                return ['value' => 'caaa'];
            }
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'aa', 'startWith');
        $this->assertTrue($list[0]->value === 'aaa');
        $this->assertTrue($list->length === 1);

        $data = [
            ['value' => 'aaa'],
            ['value' => 'baaa'],
            function() {
                return ['value' => 'caaa'];
            }
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'aa', 'notStartWith');
        $this->assertTrue($list[0]->value === 'baaa');
        $this->assertTrue($list[1]->value === 'caaa');
        $this->assertTrue($list->length === 2);

        $data = [
            ['value' => 'aaa'],
            ['value' => 'baa'],
            function() {
                return ['value' => 'aac'];
            }
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'aa', 'endWith');
        $this->assertTrue($list[0]->value === 'aaa');
        $this->assertTrue($list[1]->value === 'baa');
        $this->assertTrue($list->length === 2);

        $data = [
            ['value' => 'aaa'],
            ['value' => 'baa'],
            function() {
                return ['value' => 'aac'];
            }
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'aa', 'notEndWith');
        $this->assertTrue($list[0]->value === 'aac');
        $this->assertTrue($list->length === 1);

        $data = [
            ['value' => null, 'other' => 1],
            ['other' => 2],
            function() {
                return ['value' => 'aac'];
            }
        ];
        $list = new DataList($data);
        $list->filterBy('value', null, 'equal');
        $this->assertTrue($list[0]->other === 1);
        $this->assertTrue($list[1]->other === 2);
        $this->assertTrue($list->length === 2);
    }

    /**
     *
     */
    public function testFilterByContext()
    {
        $list = new DataList(function($context) {
            $requiresOnlyC = false;
            foreach ($context->filterByProperties as $filter) {
                if ($filter->property === 'value' && $filter->value === 'c' && $filter->operator === 'equal') {
                    $requiresOnlyC = true;
                    $filter->applied = true;
                }
            }
            if ($requiresOnlyC) {
                return [
                    ['value' => 'c', 'filtered' => 1]
                ];
            } else {
                return [
                    ['value' => 'a'],
                    ['value' => 'b'],
                    ['value' => 'c', 'filtered' => 0]
                ];
            }
        });
        $list
                ->filterBy('value', 'c');
        $this->assertTrue($list[0]->value === 'c');
        $this->assertTrue($list[0]->filtered === 1);
        $this->assertTrue($list->length === 1);
    }

    /**
     *
     */
    public function testSort()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            function() {
                return ['value' => 'c'];
            }
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
            function() {
                return ['value' => 'c'];
            },
            ['value' => null],
            ['other' => '1'],
        ];
        $list = new DataList($data);
        $list->sortBy('value');
        $this->assertTrue($list[0]->value === null);
        $this->assertTrue($list[1]->other === '1');
        $this->assertTrue($list[2]->value === 'a');
        $this->assertTrue($list[3]->value === 'b');
        $this->assertTrue($list[4]->value === 'c');
        $list->sortBy('value', 'desc');
        $this->assertTrue($list[0]->value === 'c');
        $this->assertTrue($list[1]->value === 'b');
        $this->assertTrue($list[2]->value === 'a');
        $this->assertTrue($list[3]->other === '1');
        $this->assertTrue($list[4]->value === null);
    }

    /**
     *
     */
    public function testSortByContext()
    {
        $getList = function() {
            return new DataList(function($context) {
                $sortByValue = null;
                foreach ($context->sortByProperties as $sort) {
                    if ($sort->property === 'value') {
                        $sortByValue = $sort->order;
                        $sort->applied = true;
                    }
                }
                if ($sortByValue === 'asc') {
                    return [
                        ['value' => 'a', 'sorted' => 1],
                        ['value' => 'b'],
                        ['value' => 'c']
                    ];
                } else {
                    return [
                        ['value' => 'c', 'sorted' => 2],
                        ['value' => 'b'],
                        ['value' => 'a']
                    ];
                }
            });
        };

        $list = $getList();
        $list->sortBy('value', 'desc');
        $this->assertTrue($list[0]->value === 'c');
        $this->assertTrue($list[0]->sorted === 2);
        $this->assertTrue($list->length === 3);

        $list = $getList();
        $list->sortBy('value', 'asc');
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[0]->sorted === 1);
        $this->assertTrue($list->length === 3);
    }

    /**
     *
     */
    public function testLength()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            function() {
                return ['value' => 'c'];
            }
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
            function() {
                return ['value' => 'c'];
            }
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
            function() {
                return ['value' => 'c'];
            }
        ];
        $list = new DataList($data);
        $this->assertTrue($list->length === 3);
        $object = $list->pop();
        $this->assertTrue($object->value === 'c');
        $this->assertTrue($list->length === 2);
        $list->push(['value' => 'c']);
        $this->assertTrue($list[2]->value === 'c');
        $this->assertTrue($list->length === 3);
        $list->push(function() {
            return ['value' => 'd'];
        });
        $this->assertTrue($list[3]->value === 'd');
        $this->assertTrue($list->length === 4);
    }

    /**
     *
     */
    public function testReverse()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            function() {
                return ['value' => 'c'];
            }
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
            function() {
                return ['value' => 'c'];
            }
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
            new \IvoPetkov\DataObject(['value' => 'c']),
            function() {
                return ['value' => 'd'];
            }
        ];
        $list = new DataList($data);
        $array = $list->toArray();
        $this->assertTrue($array === [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c'],
            ['value' => 'd']
        ]);
    }

    /**
     *
     */
    public function testToJSON()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            new \IvoPetkov\DataObject(['value' => 'c']),
            function() {
                return ['value' => 'd'];
            }
        ];
        $list = new DataList($data);
        $json = $list->toJSON();
        $expectedResult = '[{"value":"a"},{"value":"b"},{"value":"c"},{"value":"d"}]';
        $this->assertTrue($json === $expectedResult);
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
    public function testExceptions10()
    {
        $dataList = new DataList();
        $this->setExpectedException('Exception');
        $dataList->filterBy('name', 'John', 'invalidOperator');
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
