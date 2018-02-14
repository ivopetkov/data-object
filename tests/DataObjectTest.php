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
class DataObjectTest extends DataListTestCase
{

    /**
     *
     */
    public function testConstructor()
    {
        $data = [
            'property1' => 'a',
            'property2' => 'b',
            'property3' => 'c'
        ];
        $object = new DataObject($data);
        $this->assertTrue($object->property1 === 'a');
        $this->assertTrue($object->property2 === 'b');
        $this->assertTrue($object->property3 === 'c');
        $this->expectException('Exception');
        echo $object->property4;
    }

    /**
     *
     */
    public function testProperties()
    {
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1');
                $this->defineProperty('property2');
                $this->defineProperty('property3');
            }
        };
        $this->assertTrue($object->property1 === null);
        $this->assertTrue($object->property2 === null);
        $this->assertTrue($object->property3 === null);
        $this->assertFalse(isset($object->property1));
        $this->assertFalse(isset($object->property2));
        $this->assertFalse(isset($object->property3));
        $object->property1 = 'a';
        $object->property2 = 'b';
        $this->assertTrue($object->property1 === 'a');
        $this->assertTrue($object->property2 === 'b');
        $this->assertTrue($object->property3 === null);
        $this->assertTrue(isset($object->property1));
        $this->assertTrue(isset($object->property2));
        $this->assertFalse(isset($object->property3));
        unset($object->property2);
        $this->assertTrue($object->property1 === 'a');
        $this->assertTrue($object->property2 === null);
        $this->assertTrue($object->property3 === null);
        $this->assertTrue(isset($object->property1));
        $this->assertFalse(isset($object->property2));
        $this->assertFalse(isset($object->property3));
        $object->property1 = 'aa';
        $object->property1 = 'aaa';
        $object->property2 = 'b';
        $this->assertTrue($object->property1 === 'aaa');
        $this->assertTrue($object->property2 === 'b');
        $this->assertTrue($object->property3 === null);
        $this->assertTrue(isset($object->property1));
        $this->assertTrue(isset($object->property2));
        $this->assertFalse(isset($object->property3));
        $object->property2 = null;
        $this->assertTrue($object->property2 === null);
    }

    /**
     *
     */
    public function testArrayAccess()
    {
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1');
                $this->defineProperty('property2');
                $this->defineProperty('property3');
            }
        };
        $this->assertTrue($object['property1'] === null);
        $this->assertTrue($object['property2'] === null);
        $this->assertTrue($object['property3'] === null);
        $this->assertFalse(isset($object['property1']));
        $this->assertFalse(isset($object['property2']));
        $this->assertFalse(isset($object['property3']));
        $object['property1'] = 'a';
        $object['property2'] = 'b';
        $this->assertTrue($object['property1'] === 'a');
        $this->assertTrue($object['property2'] === 'b');
        $this->assertTrue($object['property3'] === null);
        $this->assertTrue(isset($object['property1']));
        $this->assertTrue(isset($object['property2']));
        $this->assertFalse(isset($object['property3']));
        unset($object['property2']);
        $this->assertTrue($object['property1'] === 'a');
        $this->assertTrue($object['property2'] === null);
        $this->assertTrue($object['property3'] === null);
        $this->assertTrue(isset($object['property1']));
        $this->assertFalse(isset($object['property2']));
        $this->assertFalse(isset($object['property3']));
        $object['property1'] = 'aa';
        $object['property1'] = 'aaa';
        $object['property2'] = 'b';
        $this->assertTrue($object['property1'] === 'aaa');
        $this->assertTrue($object['property2'] === 'b');
        $this->assertTrue($object['property3'] === null);
        $this->assertTrue(isset($object['property1']));
        $this->assertTrue(isset($object['property2']));
        $this->assertFalse(isset($object['property3']));
    }

    /**
     *
     */
    public function testUndefinedProperties()
    {
        $object = new DataObject();
        $this->assertFalse(isset($object->property1));

        $object->property1 = 1;
        $this->assertTrue(isset($object->property1));

        $object->property1 = null;
        $this->assertFalse(isset($object->property1));

        unset($object->property1);
        $this->assertFalse(isset($object->property1));

        $this->expectException('Exception');
        echo $object->property1;
    }

    /**
     *
     */
    public function testUndefinedIndexes()
    {
        $object = new DataObject();
        $this->assertFalse(isset($object['property1']));

        $object['property1'] = 1;
        $this->assertTrue(isset($object['property1']));

        $object['property1'] = null;
        $this->assertFalse(isset($object['property1']));

        unset($object['property1']);
        $this->assertFalse(isset($object['property1']));

        $this->expectException('Exception');
        echo $object['property1'];
    }

    /**
     *
     */
    public function testDefineProperty1()
    {
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1', [
                    'get' => function() {
                        if (!isset($this->property1raw)) {
                            return 'unknown';
                        } else {
                            return $this->property1raw;
                        }
                    },
                    'set' => function($value) {
                        $this->property1raw = $value;
                    }
                ]);
            }
        };
        $this->assertTrue($object->property1 === 'unknown');
        $object->property1 = 10;
        $this->assertTrue($object->property1 === 10);
    }

    /**
     *
     */
    public function testDefineProperty2()
    {
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property2', [
                    'init' => function() {
                        return new class {

                            public $name = 'John';
                        };
                    }
                ]);
            }
        };
        $this->assertTrue($object->property2->name === 'John');
        $object->property2->name = 'Mark';
        $this->assertTrue($object->property2->name === 'Mark');
    }

    /**
     *
     */
    public function testDefineProperty3()
    {
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property3', [
                    'init' => function() {
                        return 0;
                    },
                    'unset' => function() {
                        return 0;
                    }
                ]);
            }
        };
        $this->assertTrue($object->property3 === 0);
        $object->property3 = 5;
        $this->assertTrue($object->property3 === 5);
        unset($object->property3);
        $this->assertTrue($object->property3 === 0);
    }

    /**
     *
     */
    public function testDefineProperty4()
    {
        $object = new class extends DataObject {

            protected function initialize()
            {
                $temp = 0;
                $this->defineProperty('property4', [
                    'get' => function() use (&$temp) {
                        return $temp;
                    },
                    'set' => function($value) use (&$temp) {
                        $temp = $value;
                    },
                    'unset' => function() use (&$temp) {
                        $temp = 0;
                    }
                ]);
            }
        };
        $this->assertTrue($object->property4 === 0);
        $object->property4 = 5;
        $this->assertTrue($object->property4 === 5);
        unset($object->property4);
        $this->assertTrue($object->property4 === 0);
    }

    /**
     *
     */
    public function testDefineProperty5()
    {
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property5', [
                    'init' => function() {
                        return 1;
                    },
                    'set' => function($value) {
                        return $value * 2;
                    },
                    'unset' => function() {
                        return 1;
                    }
                ]);
            }
        };
        $this->assertTrue($object->property5 === 1);
        $object->property5 = 5;
        $this->assertTrue($object->property5 === 10);
        unset($object->property5);
        $this->assertTrue($object->property5 === 1);
    }

    /**
     *
     */
    public function testReadonlyProperty()
    {
        $object = new class extends DataObject {

            protected function initialize()
            {

                $this->defineProperty('property1', [
                    'readonly' => true
                ]);
            }
        };

        $this->expectException('Exception');

        $object->property1 = true;
    }

    /**
     *
     */
    public function testUnsetReadonlyProperty()
    {
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1', [
                    'readonly' => true
                ]);
            }
        };

        $this->expectException('Exception');

        unset($object->property1);
    }

    /**
     *
     */
    public function testEmptyObject1()
    {
        $object = new DataObject();
        $object->property1 = 1;
        $this->assertEquals($object->property1, 1);
    }

    /**
     *
     */
    public function testEmptyObject2()
    {
        $object = new DataObject();
        $this->expectException('Exception');
        echo $object->property1;
    }

    /**
     *
     */
    public function testEmptyObject3()
    {
        $object = new DataObject();
        $this->expectException('Exception');
        echo $object['property1'];
    }

    /**
     *
     */
    public function testEmptyObject4()
    {
        $object = new DataObject();
        unset($object->property1);
        $this->expectException('Exception');
        echo $object->property1;
    }

    /**
     *
     */
    public function testToArray()
    {
        $data = [
            'property4' => 4,
            'property5' => new DataList([
                [
                    'property5.1' => '5.1'
                ]
                    ])
        ];
        $object = new class($data) extends DataObject {

            public $property1 = 1;
            private $property2 = 2;
            protected $property3 = 3;

            protected function initialize()
            {
                $this->defineProperty('property6', [
                    'get' => function() {
                        return 6;
                    }
                ]);
                $this->defineProperty('property7', [
                    'init' => function() {
                        return new DataList([
                            [
                                'property7.1' => '7.1'
                            ],
                            [
                                'property7.2' => '7.2'
                            ]
                        ]);
                    }
                ]);
            }
        };
        $array = $object->toArray();
        $this->assertTrue($array === [
            'property1' => 1,
            'property4' => 4,
            'property5' =>
            [
                [
                    'property5.1' => '5.1',
                ]
            ],
            'property6' => 6,
            'property7' =>
            [
                [
                    'property7.1' => '7.1',
                ],
                [
                    'property7.2' => '7.2',
                ],
            ],
        ]);
    }

    /**
     *
     */
    public function testToJSON()
    {
        $data = [
            'property4' => 4,
            'property5' => new DataList([
                [
                    'property5.1' => '5.1'
                ]
                    ])
        ];
        $object = new class($data) extends DataObject {

            public $property1 = 1;
            private $property2 = 2;
            protected $property3 = 3;

            protected function initialize()
            {
                $this->defineProperty('property6', [
                    'get' => function() {
                        return 6;
                    }
                ]);
                $this->defineProperty('property7', [
                    'init' => function() {
                        return new DataList([
                            [
                                'property7.1' => '7.1'
                            ],
                            [
                                'property7.2' => '7.2'
                            ]
                        ]);
                    }
                ]);
            }
        };
        $json = $object->toJSON();
        $array = json_decode($json, true);
        $this->assertTrue($array === [
            'property1' => 1,
            'property4' => 4,
            'property5' =>
            [
                [
                    'property5.1' => '5.1',
                ]
            ],
            'property6' => 6,
            'property7' =>
            [
                [
                    'property7.1' => '7.1',
                ],
                [
                    'property7.2' => '7.2',
                ],
            ],
        ]);
    }

    /**
     * 
     */
    public function testPropertiesWithArrayAccessOnly()
    {
        $object = new \IvoPetkov\DataObject();
        $object->property1 = new ArrayObject(['value1' => 1]);

        $expectedResult = [
            'property1' => [
                'value1' => 1
            ]
        ];
        $this->assertTrue(json_decode($object->toJSON(), true) === $expectedResult);
        $this->assertTrue($object->toArray() === $expectedResult);

        $list = new IvoPetkov\DataList();
        $list[] = $object;

        $expectedResult = [
            [
                'property1' => [
                    'value1' => 1
                ]
            ]
        ];
        $this->assertTrue(json_decode($list->toJSON(), true) === $expectedResult);
        $this->assertTrue($list->toArray() === $expectedResult);
    }

    /**
     *
     */
    public function testExceptions1()
    {
        $this->expectException('Exception');
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1', [
                    'init' => false
                ]);
            }
        };
    }

    /**
     *
     */
    public function testExceptions2()
    {
        $this->expectException('Exception');
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1', [
                    'get' => false
                ]);
            }
        };
    }

    /**
     *
     */
    public function testExceptions3()
    {
        $this->expectException('Exception');
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1', [
                    'set' => false
                ]);
            }
        };
    }

    /**
     *
     */
    public function testExceptions4()
    {
        $this->expectException('Exception');
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1', [
                    'unset' => false
                ]);
            }
        };
    }

    /**
     *
     */
    public function testExceptions5()
    {
        $this->expectException('Exception');
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1', [
                    'readonly' => 5
                ]);
            }
        };
    }

    /**
     * 
     */
    private function getDataObjectWithPropertyType($type, $options = [])
    {
        return new class($type, $options) extends DataObject {

            public $type;
            public $options;

            function __construct($type, $options)
            {
                $this->type = $type;
                $this->options = $options;
                parent::__construct([]);
            }

            protected function initialize()
            {
                $this->defineProperty('property1', array_merge(['type' => $this->type], $this->options));
            }
        };
    }

    /**
     *
     */
    public function testPropertyTypes1a()
    {
        $object = $this->getDataObjectWithPropertyType('string');
        $object->property1 = 'value';
        $this->assertEquals($object->property1, 'value');

        $object = $this->getDataObjectWithPropertyType('?string');
        $object->property1 = null;
        $this->assertEquals($object->property1, null);
    }

    /**
     *
     */
    public function testPropertyTypes1b()
    {
        $object = $this->getDataObjectWithPropertyType('string');
        $this->expectException('Exception');
        $object->property1 = null;
    }

    /**
     *
     */
    public function testPropertyTypes1c()
    {
        $object = $this->getDataObjectWithPropertyType('?string');
        $this->expectException('Exception');
        $object->property1 = 1;
    }

    /**
     *
     */
    public function testPropertyTypes2a()
    {
        $object = $this->getDataObjectWithPropertyType('int');
        $object->property1 = 1;
        $this->assertEquals($object->property1, 1);

        $object = $this->getDataObjectWithPropertyType('?int');
        $object->property1 = null;
        $this->assertEquals($object->property1, null);
    }

    /**
     *
     */
    public function testPropertyTypes2b()
    {
        $object = $this->getDataObjectWithPropertyType('int');
        $this->expectException('Exception');
        $object->property1 = null;
    }

    /**
     *
     */
    public function testPropertyTypes2c()
    {
        $object = $this->getDataObjectWithPropertyType('?int');
        $this->expectException('Exception');
        $object->property1 = 'value';
    }

    /**
     *
     */
    public function testPropertyTypes3a()
    {
        $object = $this->getDataObjectWithPropertyType('array');
        $object->property1 = [];
        $this->assertEquals($object->property1, []);

        $object = $this->getDataObjectWithPropertyType('?array');
        $object->property1 = null;
        $this->assertEquals($object->property1, null);
    }

    /**
     *
     */
    public function testPropertyTypes3b()
    {
        $object = $this->getDataObjectWithPropertyType('array');
        $this->expectException('Exception');
        $object->property1 = null;
    }

    /**
     *
     */
    public function testPropertyTypes3c()
    {
        $object = $this->getDataObjectWithPropertyType('?array');
        $this->expectException('Exception');
        $object->property1 = 'value';
    }

    /**
     *
     */
    public function testPropertyTypes4a()
    {
        $object = $this->getDataObjectWithPropertyType('callable', [
            'init' => function() {
                return function() {
                            
                        };
            }
        ]);
        $temp = function() {
            
        };
        $object->property1 = $temp;
        $this->assertEquals($object->property1, $temp);

        $object = $this->getDataObjectWithPropertyType('?callable');
        $object->property1 = null;
        $this->assertEquals($object->property1, null);
    }

    /**
     *
     */
    public function testPropertyTypes4b()
    {
        $object = $this->getDataObjectWithPropertyType('callable', [
            'init' => function() {
                return function() {
                            
                        };
            }
        ]);
        $this->expectException('Exception');
        $object->property1 = null;
    }

    /**
     *
     */
    public function testPropertyTypes4c()
    {
        $object = $this->getDataObjectWithPropertyType('?callable');
        $this->expectException('Exception');
        $object->property1 = 'value';
    }

    /**
     *
     */
    public function testPropertyTypes5a()
    {
        $object = $this->getDataObjectWithPropertyType('float');
        $object->property1 = 1.2;
        $this->assertEquals($object->property1, 1.2);

        $object = $this->getDataObjectWithPropertyType('?float');
        $object->property1 = null;
        $this->assertEquals($object->property1, null);
    }

    /**
     *
     */
    public function testPropertyTypes5b()
    {
        $object = $this->getDataObjectWithPropertyType('float');
        $this->expectException('Exception');
        $object->property1 = null;
    }

    /**
     *
     */
    public function testPropertyTypes5c()
    {
        $object = $this->getDataObjectWithPropertyType('?float');
        $this->expectException('Exception');
        $object->property1 = 'value';
    }

    /**
     *
     */
    public function testPropertyTypes6a()
    {
        $object = $this->getDataObjectWithPropertyType('bool', [
            'init' => function() {
                return true;
            }
        ]);
        $object->property1 = false;
        $this->assertEquals($object->property1, false);

        $object = $this->getDataObjectWithPropertyType('?bool');
        $object->property1 = null;
        $this->assertEquals($object->property1, null);
    }

    /**
     *
     */
    public function testPropertyTypes6b()
    {
        $object = $this->getDataObjectWithPropertyType('bool', [
            'init' => function() {
                return true;
            }
        ]);
        $this->expectException('Exception');
        $object->property1 = null;
    }

    /**
     *
     */
    public function testPropertyTypes6c()
    {
        $object = $this->getDataObjectWithPropertyType('?bool');
        $this->expectException('Exception');
        $object->property1 = 'value';
    }

    /**
     *
     */
    public function testPropertyTypes7a()
    {
        $object = $this->getDataObjectWithPropertyType('DateTime', [
            'init' => function() {
                return new DateTime();
            }
        ]);
        $temp = new DateTime();
        $object->property1 = $temp;
        $this->assertEquals($object->property1, $temp);

        $object = $this->getDataObjectWithPropertyType('?DateTime');
        $object->property1 = null;
        $this->assertEquals($object->property1, null);
    }

    /**
     *
     */
    public function testPropertyTypes7b()
    {
        $object = $this->getDataObjectWithPropertyType('DateTime', [
            'init' => function() {
                return new DateTime();
            }
        ]);
        $this->expectException('Exception');
        $object->property1 = null;
    }

    /**
     *
     */
    public function testPropertyTypes7c()
    {
        $object = $this->getDataObjectWithPropertyType('?DateTime');
        $this->expectException('Exception');
        $object->property1 = 'value';
    }

    /**
     *
     */
    public function testPropertyTypes7d()
    {
        $object = $this->getDataObjectWithPropertyType('DateTime', [
            'init' => function() {
                return new DateTime();
            }
        ]);
        $this->expectException('Exception');
        $object->property1 = new stdClass();
    }

}
