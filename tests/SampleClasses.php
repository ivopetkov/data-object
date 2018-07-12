<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleObject1 extends \IvoPetkov\DataObject
{

    function __construct(array $data = array())
    {
        $this->defineProperty('prop1', [
            'type' => 'string',
            'init' => function() {
                return '1';
            }
        ]);
        $this->defineProperty('prop3', [
            'type' => 'array'
        ]);
        $this->defineProperty('prop4', [
            'type' => 'ArrayObject',
            'init' => function() {
                return new ArrayObject(['prop4.1' => '4.1']);
            }
        ]);
        $this->defineProperty('prop5', [
            'type' => 'SampleObject2'
        ]);
        $this->defineProperty('prop6', [
            'type' => 'string',
            'init' => function() {
                return '6';
            },
            'readonly' => true
        ]);
        $this->defineProperty('prop7', [
            'init' => function() {
                return new SampleObject3();
            }
        ]);
        $this->defineProperty('prop8', [
            'type' => 'SampleObject3'
        ]);
        $this->defineProperty('prop9', [
            'type' => 'array'
        ]);
        parent::__construct($data);
    }

}

class SampleObject2 extends \IvoPetkov\DataObject
{

    function __construct(array $data = array())
    {
        $this->defineProperty('prop1', [
            'type' => 'ArrayObject',
            'init' => function() {
                return new ArrayObject(['prop1.1' => '1.1']);
            }
        ]);
        parent::__construct($data);
    }

    static function fromArray(array $data)
    {
        $object = new SampleObject2();
        if (isset($data['prop2'])) {
            $object->prop2 = $data['prop2'] . '!!!';
        }
        return $object;
    }

    static function fromJSON(string $data)
    {
        $data = json_decode($data, true);
        $object = new SampleObject2();
        if (isset($data['prop2'])) {
            $object->prop2 = $data['prop2'] . '!!!';
        }
        return $object;
    }

}

class SampleObject3 extends \IvoPetkov\DataObject
{

    function __construct(array $data = array())
    {
        $this->defineProperty('prop1', [
            'type' => 'ArrayObject'
        ]);
        parent::__construct($data);
    }

}

class SampleObject4 extends \IvoPetkov\DataObject
{

    public function toJSON(): string
    {
        return json_encode(['sampleObjectProperty1' => ["1", "'", '"']]);
    }

}

class SampleObject5 extends \IvoPetkov\DataObject
{

    function __construct()
    {
        $this->defineProperty('property1', [
            'type' => 'DateTime',
            'init' => function() {
                return new DateTime("2222-11-11T11:11:11+00:00");
            }
        ]);
        parent::__construct();
    }

}

class SampleObject6 extends \IvoPetkov\DataObject
{

    function __construct()
    {
        $this->defineProperty('property1', [
            'type' => '?DateTime'
        ]);
        parent::__construct();
    }

}

class SampleObject7 extends \IvoPetkov\DataObject
{

    function __construct()
    {
        $this->defineProperty('property1', [
            'type' => '?DateTime',
            'init' => function() {
                return new DateTime("2222-11-11T11:11:11+00:00");
            }
        ]);
        parent::__construct();
    }

}

class SampleObject8 extends \IvoPetkov\DataObject
{

    function __construct()
    {
        parent::__construct();
        $this
                ->defineProperty('property1', [
                    'type' => '?string'
                ])
                ->defineProperty('property2', [
                    'type' => '?string',
                    'encodeInJSON' => true
        ]);
    }

}
