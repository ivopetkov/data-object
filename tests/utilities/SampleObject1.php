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
