<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use IvoPetkov\DataList;
use IvoPetkov\DataListContext;
use IvoPetkov\DataObject;

/**
 * @runTestsInSeparateProcesses
 */
class DataListFilterByOptimizationsTest extends PHPUnit\Framework\TestCase
{

    /**
     *
     */
    public function testOptimizations1()
    {
        $data = [
            ['value' => 'apple'],
            ['value' => 'ant'],
            ['value' => 'bear'],
            ['value' => 'dog'],
            ['value' => 'donkey'],
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'a', 'startWith');
        $this->assertEquals($list->toArray(), array(
            0 =>
            array(
                'value' => 'apple',
            ),
            1 =>
            array(
                'value' => 'ant',
            ),
        ));
    }

    /**
     *
     */
    public function testOptimizations2()
    {
        $data = [
            ['value' => 'apple'],
            ['value' => 'ant'],
            ['value' => 'bear'],
            ['value' => 'dog'],
            ['value' => 'donkey'],
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'a', 'startWith');
        $list->filterBy('value', 'b', 'startWith');
        $this->assertEquals($list->toArray(), array());
    }

    /**
     *
     */
    public function testOptimizations3()
    {
        $data = [
            ['value' => 'apple'],
            ['value' => 'ant'],
            ['value' => 'bear'],
            ['value' => 'dog'],
            ['value' => 'donkey'],
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'd', 'startWith');
        $list->filterBy('value', 'x1', 'notStartWith');
        $list->filterBy('value', 'x2', 'notStartWith');
        $list->filterBy('value', 'x3', 'notStartWith');
        $this->assertEquals($list->toArray(), array(
            0 =>
            array(
                'value' => 'dog',
            ),
            1 =>
            array(
                'value' => 'donkey',
            ),
        ));
    }

    /**
     *
     */
    public function testOptimizations4()
    {
        $data = [
            ['value' => 'apple'],
            ['value' => 'ant'],
            ['value' => 'bear'],
            ['value' => 'dog'],
            ['value' => 'donkey'],
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'd', 'notStartWith');
        $list->filterBy('value', 'x', 'notStartWith');
        $this->assertEquals($list->toArray(), array(
            0 =>
            array(
                'value' => 'apple',
            ),
            1 =>
            array(
                'value' => 'ant',
            ),
            2 =>
            array(
                'value' => 'bear',
            ),
        ));
    }

    /**
     *
     */
    public function testOptimizations5()
    {
        $data = [
            ['value' => 'apple'],
            ['value' => 'ant'],
            ['value' => 'bear'],
            ['value' => 'dog'],
            ['value' => 'donkey'],
        ];
        $list = new DataList($data);
        $list->filterBy('value', 'do', 'startWith');
        $list->filterBy('value', 'd', 'notStartWith');
        $this->assertEquals($list->toArray(), array());
    }

    /**
     *
     */
    public function testCallbackOptimizations1()
    {
        $passedContext = null;
        $list = new DataList(function (DataListContext $context) use (&$passedContext) {
            $passedContext = $context;
            return [['value' => 'countries/bulgaria']];
        });
        $list->filterBy('value', 'countries/', 'startWith');
        $this->assertEquals($list->count(), 1);
        $this->assertEquals(sizeof($passedContext->actions), 1);
        $this->assertEquals($passedContext->actions[0]->toArray(), array(
            'name' => 'filterBy',
            'operator' => 'startWith',
            'property' => 'value',
            'value' => 'countries/',
        ));
    }

    /**
     *
     */
    public function testCallbackOptimizations2()
    {
        $passedContext = null;
        $list = new DataList(function (DataListContext $context) use (&$passedContext) {
            $passedContext = $context;
            return [];
        });
        $list->filterBy('value', 'countries/', 'startWith');
        $list->filterBy('value', 'food/', 'startWith');
        $this->assertEquals($list->count(), 0);
        $this->assertEquals($passedContext, null);
    }

    /**
     *
     */
    public function testCallbackOptimizations3()
    {
        $passedContext = null;
        $list = new DataList(function (DataListContext $context) use (&$passedContext) {
            $passedContext = $context;
            return [['value' => 'countries/bulgaria']];
        });
        $list->filterBy('value', 'countries/', 'startWith');
        $list->filterBy('value', 'food/a', 'notStartWith');
        $list->filterBy('value', 'food/b', 'notStartWith');
        $list->filterBy('value', 'food/c', 'notStartWith');
        $this->assertEquals($list->count(), 1);
        $this->assertEquals(sizeof($passedContext->actions), 1);
        $this->assertEquals($passedContext->actions[0]->toArray(), array(
            'name' => 'filterBy',
            'operator' => 'startWith',
            'property' => 'value',
            'value' => 'countries/',
        ));
    }

    /**
     *
     */
    public function testCallbackOptimizations4()
    {
        $passedContext = null;
        $list = new DataList(function (DataListContext $context) use (&$passedContext) {
            $passedContext = $context;
            return [['value' => 'countries/bulgaria']];
        });
        $list->filterBy('value', 'countries/', 'startWith');
        $list->filterBy('value', 'cou', 'notStartWith');
        $this->assertEquals($list->count(), 0);
        $this->assertEquals($passedContext, null);
    }
}
