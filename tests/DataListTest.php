<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use IvoPetkov\DataList;
use IvoPetkov\DataObject;

/**
 * @runTestsInSeparateProcesses
 */
class DataListTest extends PHPUnit\Framework\TestCase
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
        $this->assertTrue(count($list) === 3);
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
        $this->assertTrue(count($list) === 3);
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

        $this->expectException('\Exception');
        $list[7] = new DataObject(['value' => 'gg']);
    }

    /**
     * 
     */
    public function testGet1()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            ['value' => 'c'],
        ];
        $list = new DataList($data);
        $this->assertTrue($list->getFirst()->value === 'a');
        $this->assertTrue($list->get(1)->value === 'b');
        $this->assertTrue($list->getLast()->value === 'c');
        $this->assertTrue(in_array($list->getRandom()->value, ['a', 'b', 'c']));
    }

    /**
     * 
     */
    public function testGet2()
    {
        $list = new DataList();
        $this->assertTrue($list->getFirst() === null);
        $this->assertTrue($list->get(1) === null);
        $this->assertTrue($list->getLast() === null);
        $this->assertTrue($list->getRandom() === null);
    }

    /**
     * 
     */
    public function testOffsetGetShouldReturnNull()
    {
        $list = new DataList();
        $this->assertNull($list->offsetGet(0));
    }

    /**
     * 
     */
    public function testCurrentShouldReturnNull()
    {
        $list = new DataList();
        $this->assertNull($list->current());
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
    public function testConcat()
    {
        $list1 = new DataList([
            ['value' => 1],
            ['value' => 2],
        ]);
        $list2 = new DataList([
            ['value' => 3],
            ['value' => 4],
        ]);
        $list1->concat($list2);
        $this->assertTrue($list1[0]->value === 1);
        $this->assertTrue($list1[1]->value === 2);
        $this->assertTrue($list1[2]->value === 3);
        $this->assertTrue($list1[3]->value === 4);
        $this->assertTrue(count($list1) === 4);
        $this->assertTrue($list2[0]->value === 3);
        $this->assertTrue($list2[1]->value === 4);
        $this->assertTrue(count($list2) === 2);
    }

    /**
     * 
     */
    public function testSlice()
    {
        $list = new DataList();
        $dataObject = new DataObject();
        $dataObject->value = 1;
        $list[] = $dataObject;
        $dataObject = new DataObject();
        $dataObject->value = 2;
        $list[] = $dataObject;
        $dataObject = new DataObject();
        $dataObject->value = 3;
        $list[] = $dataObject;
        $slice = $list->slice(1, 1);
        $this->assertTrue($slice[0]->value === 2);
        $this->assertTrue(count($slice) === 1);
    }

    /**
     *
     */
    public function testSliceProperties()
    {
        $data = [
            ['id' => 1, 'value' => 'a', 'other' => 1],
            ['id' => 2, 'value' => 'b'],
            function() {
                return ['id' => 3, 'value' => 'c', 'other' => 3];
            },
            function() {
                return ['id' => 4];
            }
        ];
        $list = new DataList($data);
        $result = $list->sliceProperties(['id', 'value']);
        $this->assertTrue($result->toArray() === [
            [
                'id' => 1,
                'value' => 'a'
            ],
            [
                'id' => 2,
                'value' => 'b'
            ],
            [
                'id' => 3,
                'value' => 'c'
            ],
            [
                'id' => 4,
                'value' => null
            ]
        ]);
    }

    /**
     *
     */
    public function testSlicePropertiesContext()
    {
        $list = new DataList(function($context) {
            $actions = $context->getActions();
            foreach ($actions as $action) {
                if ($action->name === 'sliceProperties' && array_search('id', $action->properties) !== false) {
                    return [
                        ['id' => '1', 'value' => 1],
                        ['id' => '2', 'value' => 2],
                        ['id' => '3', 'value' => 3],
                    ];
                }
            }
            return [];
        });
        $result = $list->sliceProperties(['id']);
        $this->assertTrue($result->toArray() === [
            [
                'id' => '1'
            ],
            [
                'id' => '2'
            ],
            [
                'id' => '3'
            ]
        ]);
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
        $this->assertTrue(count($list) === 1);

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
        $this->assertTrue(count($list) === 4);

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
        $this->assertTrue(count($list) === 2);

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
        $this->assertTrue(count($list) === 1);

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
        $this->assertTrue(count($list) === 1);

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
        $this->assertTrue(count($list) === 2);

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
        $this->assertTrue(count($list) === 2);

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
        $this->assertTrue(count($list) === 1);

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
        $this->assertTrue(count($list) === 2);


        $data = [
            ['value' => null, 'other' => 1],
            ['other' => 2],
            function() {
                return ['value' => 'aac'];
            }
        ];
        $list = new DataList($data);
        $list->filterBy('value', ['aac'], 'inArray');
        $this->assertTrue($list[0]->value === 'aac');
        $this->assertTrue(count($list) === 1);
        $list = new DataList($data);
        $list->filterBy('value', [null], 'inArray');
        $this->assertTrue($list[0]->other === 1);
        $this->assertTrue($list[1]->other === 2);
        $this->assertTrue(count($list) === 2);
        $list = new DataList($data);
        $list->filterBy('other', [2, 3], 'inArray');
        $this->assertTrue($list[0]->other === 2);
        $this->assertTrue(count($list) === 1);

        $data = [
            ['value' => null, 'other' => 1],
            ['other' => 2],
            function() {
                return ['value' => 'aac'];
            }
        ];
        $list = new DataList($data);
        $list->filterBy('value', ['aac'], 'notInArray');
        $this->assertTrue($list[0]->other === 1);
        $this->assertTrue($list[1]->other === 2);
        $this->assertTrue(count($list) === 2);
        $list = new DataList($data);
        $list->filterBy('value', [null], 'notInArray');
        $this->assertTrue($list[0]->value === 'aac');
        $this->assertTrue(count($list) === 1);
        $list = new DataList($data);
        $list->filterBy('other', [2, 3], 'notInArray');
        $this->assertTrue($list[0]->other === 1);
        $this->assertTrue($list[1]->value === 'aac');
        $this->assertTrue(count($list) === 2);
    }

    /**
     *
     */
    public function testFilterByContext()
    {
        $list = new DataList(function($context) {
            $requiresOnlyC = false;
            $actions = $context->getActions();
            foreach ($actions as $action) {
                if ($action->name === 'filterBy' && $action->property === 'value' && $action->value === 'c' && $action->operator === 'equal') {
                    $requiresOnlyC = true;
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
        $this->assertTrue(count($list) === 1);
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
        $this->assertTrue($list[3]->value === null);
        $this->assertTrue($list[4]->other === '1');
    }

    /**
     *
     */
    public function testSortByContext()
    {
        $getList = function() {
            return new DataList(function($context) {
                $sortByValue = null;
                $actions = $context->getActions();
                foreach ($actions as $action) {
                    if ($action->name === 'sortBy' && $action->property === 'value') {
                        $sortByValue = $action->order;
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
        $this->assertTrue(count($list) === 3);

        $list = $getList();
        $list->sortBy('value', 'asc');
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue($list[0]->sorted === 1);
        $this->assertTrue(count($list) === 3);
    }

    /**
     *
     */
    public function testCount()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            function() {
                return ['value' => 'c'];
            }
        ];
        $list = new DataList($data);
        $this->assertTrue(count($list) === 3);
        $list->pop();
        $this->assertTrue(count($list) === 2);
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
        $this->assertTrue(count($list) === 3);
        $object = $list->shift();
        $this->assertTrue($object->value === 'a');
        $this->assertTrue(count($list) === 2);
        $list->unshift(['value' => 'a']);
        $this->assertTrue($list[0]->value === 'a');
        $this->assertTrue(count($list) === 3);
    }

    /**
     *
     */
    public function testShiftShouldReturnNull()
    {
        $list = new DataList();
        $this->assertNull($list->shift());
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
        $this->assertTrue(count($list) === 3);
        $object = $list->pop();
        $this->assertTrue($object->value === 'c');
        $this->assertTrue(count($list) === 2);
        $list->push(['value' => 'c']);
        $this->assertTrue($list[2]->value === 'c');
        $this->assertTrue(count($list) === 3);
        $list->push(function() {
            return ['value' => 'd'];
        });
        $this->assertTrue($list[3]->value === 'd');
        $this->assertTrue(count($list) === 4);
    }

    /**
     *
     */
    public function testPopShouldReturnNull()
    {
        $list = new DataList();
        $this->assertNull($list->pop());
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
    public function testShuffle()
    {
        $data = [
            ['value' => 'a'],
            ['value' => 'b'],
            function() {
                return ['value' => 'c'];
            }
        ];
        $list = new DataList($data);
        $list->shuffle();

        $valueExists = function($value) use (&$list) {
            foreach ($list as $object) {
                if ($object->value === $value) {
                    return true;
                }
            }
            return false;
        };

        $this->assertTrue($valueExists('a'));
        $this->assertTrue($valueExists('b'));
        $this->assertTrue($valueExists('c'));

        $list->push(['value' => 'd']);
        $list->shuffle();
        $this->assertTrue($valueExists('a'));
        $this->assertTrue($valueExists('b'));
        $this->assertTrue($valueExists('c'));
        $this->assertTrue($valueExists('d'));
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
        $this->expectException('Exception');
        $dataList[false] = ['key' => 'value'];
    }

    /**
     *
     */
    public function testExceptions7()
    {
        $dataList = new DataList();
        $this->expectException('Exception');
        $dataList->sortBy('name', 1);
    }

    /**
     *
     */
    public function testExceptions10()
    {
        $dataList = new DataList();
        $this->expectException('Exception');
        $dataList->filterBy('name', 'John', 'invalidOperator');
    }

    /**
     *
     */
    public function testDataListInstanceWithInvalidConstructor()
    {
        $this->expectException('InvalidArgumentException');
        $dataList = new DataList('invalid_data_source');
    }

    /**
     *
     */
    public function testDateTimeSort()
    {
        $dataList = new DataList();
        $dateObject1 = new SampleObject6();
        $dateObject1->property1 = new DateTime("2000-10-11T11:11:11+00:00");
        $dataList[] = $dateObject1;
        $dateObject2 = new SampleObject6();
        $dateObject2->property1 = null;
        $dataList[] = $dateObject2;
        $dateObject3 = new SampleObject6();
        $dateObject3->property1 = new DateTime("2100-10-11T11:11:11+00:00");
        $dataList[] = $dateObject3;

        $dataList->sortBy('property1');
        $this->assertTrue($dataList[0]->property1 === null);
        $this->assertTrue($dataList[1]->property1->format('c') === "2000-10-11T11:11:11+00:00");
        $this->assertTrue($dataList[2]->property1->format('c') === "2100-10-11T11:11:11+00:00");

        $dataList->sortBy('property1', 'desc');
        $this->assertTrue($dataList[0]->property1->format('c') === "2100-10-11T11:11:11+00:00");
        $this->assertTrue($dataList[1]->property1->format('c') === "2000-10-11T11:11:11+00:00");
        $this->assertTrue($dataList[2]->property1 === null);
    }

}
