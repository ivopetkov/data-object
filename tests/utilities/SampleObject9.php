<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleObject9 extends \IvoPetkov\DataObject
{

    private $prop1 = 'value1';

    function __construct()
    {
        $prop2 = 'value2';
        $this
            ->defineProperty('property1', [
                'type' => '?string',
                'get' => function () {
                    return $this->prop1;
                },
                'set' => function ($value): void {
                    $this->prop1 = $value;
                }
            ])
            ->defineProperty('property2', [
                'type' => '?string',
                'get' => function () use (&$prop2) {
                    return $prop2;
                },
                'set' => function ($value)  use (&$prop2): void {
                    $prop2 = $value;
                }
            ])
            ->defineProperty('property3', [
                'type' => '?string',
                'init' => function () {
                    return 'value3';
                }
            ])
            ->defineProperty('property4', [
                'type' => '?string',
                'init' => ['SampleObject9', 'property4init']
            ]);
    }

    static function property4init()
    {
        return 'value4';
    }
}
