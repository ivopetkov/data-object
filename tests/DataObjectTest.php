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
class DataObjectTest extends PHPUnit\Framework\TestCase
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
        $object = new class extends DataObject
        {

            public function __construct()
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
        $object = new class extends DataObject
        {

            public function __construct()
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
        $object = new class extends DataObject
        {

            public function __construct()
            {
                $this->defineProperty('property1', [
                    'get' => function () {
                        if (!isset($this->property1raw)) {
                            return 'unknown';
                        } else {
                            return $this->property1raw;
                        }
                    },
                    'set' => function ($value) {
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
        $object = new class extends DataObject
        {

            public function __construct()
            {
                $this->defineProperty('property2', [
                    'init' => function () {
                        return new class
                        {

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
        $object = new class extends DataObject
        {

            public function __construct()
            {
                $this->defineProperty('property3', [
                    'init' => function () {
                        return 0;
                    },
                    'unset' => function () {
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
        $object = new class extends DataObject
        {

            public function __construct()
            {
                $temp = 0;
                $this->defineProperty('property4', [
                    'get' => function () use (&$temp) {
                        return $temp;
                    },
                    'set' => function ($value) use (&$temp) {
                        $temp = $value;
                    },
                    'unset' => function () use (&$temp) {
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
        $object = new class extends DataObject
        {

            public function __construct()
            {
                $this->defineProperty('property5', [
                    'init' => function () {
                        return 1;
                    },
                    'set' => function ($value) {
                        return $value * 2;
                    },
                    'unset' => function () {
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
        $object = new class extends DataObject
        {

            public function __construct()
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
        $object = new class extends DataObject
        {

            public function __construct()
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
        $object = new class ($data) extends DataObject
        {

            public $property1 = 1;
            private $property2 = 2;
            protected $property3 = 3;

            public function __construct($data)
            {
                $this->defineProperty('property6', [
                    'get' => function () {
                        return 6;
                    }
                ]);
                $this->defineProperty('property7', [
                    'init' => function () {
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
                parent::__construct($data);
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
    public function testFromArrayAndFromJSON()
    {
        $object1 = new SampleObject1();
        $object1->prop1 = '1.1';
        $object1->prop2 = '2.1';
        $object1->prop3 = ['3.1', '3.2', '3.3'];
        $object1->prop4['prop4.1'] = '4.1';
        $object1->prop4['prop4.2'] = new stdClass(['prop4.2.1' => '4.2.1']);
        $object1->prop4['prop4.3'] = new ArrayObject(['prop4.3.1' => '4.3.1']);
        $object1->prop5->prop2 = '2.1';
        $object1->prop7->prop1['prop1.1'] = '1.1';
        $object1->prop7->prop2 = '2';
        $object1->prop8['prop8.1'] = '8.1';

        $object1Array = $object1->toArray();
        $object1JSON = $object1->toJSON();

        for ($i = 1; $i <= 2; $i++) {
            if ($i === 1) {
                $object2 = SampleObject1::fromArray($object1Array);
            } else {
                $object2 = SampleObject1::fromJSON($object1JSON);
            }
            $array1asJSON = json_encode($object1Array);
            $array2asJSON = str_replace('!!!', '', json_encode($object2->toArray())); // SampleObject2 has added "!!!" to one property to test the fromArray() and fromJSON() methods.
            $this->assertTrue($array1asJSON === $array2asJSON);
            $this->assertTrue(get_class($object2->prop4) === 'ArrayObject');
            $this->assertTrue(gettype($object2->prop4['prop4.1']) === 'string');
            $this->assertTrue(gettype($object2->prop4['prop4.2']) === 'array'); // Cannot convert back to stdClass, because it's custom property
            $this->assertTrue(gettype($object2->prop4['prop4.3']) === 'array'); // Cannot convert back to ArrayObject, because it's custom property
            $this->assertTrue(get_class($object2->prop5) === 'SampleObject2');
            $this->assertTrue(get_class($object2->prop5->prop1) === 'ArrayObject');
            $this->assertTrue(get_class($object2->prop7) === 'SampleObject3');
            $this->assertTrue(get_class($object2->prop7->prop1) === 'ArrayObject');
            $this->assertTrue(get_class($object2->prop8) === 'SampleObject3');
            $this->assertTrue(get_class($object2->prop8->prop1) === 'ArrayObject');
            $this->assertTrue(gettype($object1->prop9) === 'array');
        }
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
        $object = new class ($data) extends DataObject
        {

            public $property1 = 1;
            private $property2 = 2;
            protected $property3 = 3;

            public function __construct($data)
            {
                $this->defineProperty('property6', [
                    'get' => function () {
                        return 6;
                    }
                ]);
                $this->defineProperty('property7', [
                    'init' => function () {
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
                $this->defineProperty('property8', [
                    'init' => function () {
                        return new SampleObject4();
                    }
                ]);
                parent::__construct($data);
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
            'property8' =>
            [
                'sampleObjectProperty1' => ['1', "'", '"'],
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
    public function testPropertiesReferenceAccess()
    {
        $object = new \IvoPetkov\DataObject();
        $object->property1 = ['value1' => 1];
        $object->property1['value1'] = 11;
        $object['property1']['value2'] = 22;

        $expectedResult = [
            'property1' => [
                'value1' => 11,
                'value2' => 22,
            ]
        ];
        $this->assertTrue(json_decode($object->toJSON(), true) === $expectedResult);
        $this->assertTrue($object->toArray() === $expectedResult);
    }

    /**
     *
     */
    public function testExceptions1()
    {
        $this->expectException('Exception');
        $object = new class extends DataObject
        {

            public function __construct()
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
        $object = new class extends DataObject
        {

            public function __construct()
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
        $object = new class extends DataObject
        {

            public function __construct()
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
        $object = new class extends DataObject
        {

            public function __construct()
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
        $object = new class extends DataObject
        {

            public function __construct()
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
        return new class ($type, $options) extends DataObject
        {

            function __construct($type, $options)
            {
                $this->defineProperty('property1', array_merge(['type' => $type], $options));
                parent::__construct([]);
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
            'init' => function () {
                return function () {
                };
            }
        ]);
        $temp = function () {
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
            'init' => function () {
                return function () {
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
            'init' => function () {
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
            'init' => function () {
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
            'init' => function () {
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
            'init' => function () {
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
            'init' => function () {
                return new DateTime();
            }
        ]);
        $this->expectException('Exception');
        $object->property1 = new stdClass();
    }

    /**
     *
     */
    public function testDateTimeType()
    {
        $object = new SampleObject5();
        $expectedJSON = '{"property1":"2222-11-11T11:11:11+00:00"}';
        $expectedArray = ['property1' => '2222-11-11T11:11:11+00:00'];
        $this->assertTrue($object->toJSON() === $expectedJSON);
        $this->assertTrue($object->toArray() === $expectedArray);
        $object2 = SampleObject5::fromJSON($expectedJSON);
        $this->assertTrue($object2->property1 instanceof \DateTime && $object2->property1->format('c') === "2222-11-11T11:11:11+00:00");
        $object2 = SampleObject5::fromArray($expectedArray);
        $this->assertTrue($object2->property1 instanceof \DateTime && $object2->property1->format('c') === "2222-11-11T11:11:11+00:00");

        $object = new SampleObject6();
        $expectedJSON = '{"property1":null}';
        $expectedArray = ['property1' => null];
        $this->assertTrue($object->toJSON() === $expectedJSON);
        $this->assertTrue($object->toArray() === $expectedArray);
        $object2 = SampleObject6::fromJSON($expectedJSON);
        $this->assertTrue($object2->property1 === null);
        $object2 = SampleObject6::fromArray($expectedArray);
        $this->assertTrue($object2->property1 === null);

        $object = new SampleObject7();
        $expectedJSON = '{"property1":"2222-11-11T11:11:11+00:00"}';
        $expectedArray = ['property1' => '2222-11-11T11:11:11+00:00'];
        $this->assertTrue($object->toJSON() === $expectedJSON);
        $this->assertTrue($object->toArray() === $expectedArray);
        $object2 = SampleObject7::fromJSON($expectedJSON);
        $this->assertTrue($object2->property1 instanceof \DateTime && $object2->property1->format('c') === "2222-11-11T11:11:11+00:00");
        $object2 = SampleObject7::fromArray($expectedArray);
        $this->assertTrue($object2->property1 instanceof \DateTime && $object2->property1->format('c') === "2222-11-11T11:11:11+00:00");
    }

    /**
     *
     */
    public function testJSONEncodePropertyValue()
    {
        $object = new SampleObject8();
        $object->property1 = 'value1';
        $object->property2 = 'value2';
        $expectedJSON = '{"property1":"value1","property2":"data:;base64,dmFsdWUy"}';
        $expectedArray = ['property1' => 'value1', 'property2' => 'value2'];
        $this->assertTrue($object->toJSON() === $expectedJSON);
        $this->assertTrue($object->toArray() === $expectedArray);
        $this->assertTrue(SampleObject8::fromJSON($expectedJSON)->toArray() === $expectedArray);
    }

    /**
     *
     */
    public function testClone()
    {
        $object = new SampleObject9();
        $this->assertEquals($object->property1, 'value1');
        $this->assertEquals($object->property2, 'value2');
        $this->assertEquals($object->property3, 'value3');
        $this->assertEquals($object->property4, 'value4');
        $clonedObject = clone ($object);
        $clonedObject->property1 = 'updatedValue1';
        $clonedObject->property2 = 'updatedValue2';
        $clonedObject->property3 = 'updatedValue3';
        $clonedObject->property4 = 'updatedValue4';
        $this->assertEquals($object->property1, 'value1');
        $this->assertEquals($object->property2, 'updatedValue2'); // expected. Should not use local properties in constructors.
        $this->assertEquals($object->property3, 'value3');
        $this->assertEquals($object->property4, 'value4');
        $this->assertEquals($clonedObject->property1, 'updatedValue1');
        $this->assertEquals($clonedObject->property2, 'updatedValue2');
        $this->assertEquals($clonedObject->property3, 'updatedValue3');
        $this->assertEquals($clonedObject->property4, 'updatedValue4');
    }
}
