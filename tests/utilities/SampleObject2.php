<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

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
