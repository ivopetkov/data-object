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
        $this->assertTrue($object->property4 === null);
    }

    /**
     *
     */
    public function testProperties()
    {
        $object = new DataObject();
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
        $object = new DataObject();
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
    public function testDefineProperty1()
    {
        $object = new class extends DataObject {

            protected
                    function initialize()
            {
                $this->defineProperty('property1', [
                    'get' => function() {
                        if ($this->property1raw === null) {
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

        $this->setExpectedException('Exception');

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

        $this->setExpectedException('Exception');

        unset($object->property1);
    }

    /**
     *
     */
    public function testToArray()
    {
        $data = [
            'property1' => 1,
            'property2' => new DataList([
                [
                    'property2.1' => '2.1'
                ]
                    ])
        ];
        $object = new class($data) extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property3', [
                    'get' => function() {
                        return 3;
                    }
                ]);
                $this->defineProperty('property4', [
                    'init' => function() {
                        return new DataList([
                            [
                                'property4.1' => '4.1'
                            ]
                        ]);
                    }
                ]);
            }
        };
        $array = $object->toArray();
        $this->assertTrue($array === [
            'property1' => 1,
            'property2' => [['property2.1' => '2.1']],
            'property3' => 3,
            'property4' => [['property4.1' => '4.1']]
        ]);
    }

    /**
     *
     */
    public function testToJSON()
    {
        $data = ['property1' => 1];
        $object = new class($data) extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property2', [
                    'get' => function() {
                        return 2;
                    }
                ]);
            }
        };

        $json = $object->toJSON();
        $expectedResult = '{"property1":1,"property2":2}';
        $this->assertTrue($json === $expectedResult);
    }

    /**
     *
     */
    public function testExceptions1()
    {
        $this->setExpectedException('Exception');
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
        $this->setExpectedException('Exception');
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
        $this->setExpectedException('Exception');
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
        $this->setExpectedException('Exception');
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
        $this->setExpectedException('Exception');
        $object = new class extends DataObject {

            protected function initialize()
            {
                $this->defineProperty('property1', [
                    'readonly' => 5
                ]);
            }
        };
    }

}
