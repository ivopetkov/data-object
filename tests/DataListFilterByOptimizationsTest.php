<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use IvoPetkov\DataList;
use IvoPetkov\DataListContext;

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
        $this->assertEquals(count($passedContext->actions), 1);
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
        $this->assertEquals(count($passedContext->actions), 1);
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

    /**
     *
     */
    public function testCallbackOptimizations5()
    {
        $passedContext = null;
        $list = new DataList(function (DataListContext $context) use (&$passedContext) {
            $passedContext = $context;
            return [
                ['value' => 'apple', 'count' => 1],
                ['value' => 'ant', 'count' => 2],
                ['value' => 'bear', 'count' => 3],
                ['value' => 'dog', 'count' => 4],
                ['value' => 'donkey', 'count' => 5],
                ['value' => 'dogs', 'count' => 6],
            ];
        });
        $list->filterBy('value', 'd', 'startWith');
        $list->filterBy('value', 'do', 'startWith');
        $list->filterBy('value', 'doxxxx', 'notStartWith');
        $list->filterBy('value', 'x', 'notStartWith');
        $list->filterBy('value', 'xx', 'notStartWith');
        $list->filterBy('count', '[0-9]', 'regExp');
        $list->filterBy('value', 'gs', 'endWith');
        $list->filterBy('value', 's', 'endWith');
        $list->filterBy('value', 'ggs', 'notEndWith');
        $list->filterBy('value', 'y', 'notEndWith');
        $list->filterBy('value', 'zy', 'notEndWith');
        $this->assertEquals($list->toArray(), array(
            0 =>
            array(
                'value' => 'dogs',
                'count' => 6,
            ),
        ));
        $this->assertEquals(sizeof($passedContext->actions), 5);
        $this->assertEquals($passedContext->actions[0]->toArray(), array(
            'name' => 'filterBy',
            'property' => 'value',
            'value' => 'do',
            'operator' => 'startWith',
        ));
        $this->assertEquals($passedContext->actions[1]->toArray(), array(
            'name' => 'filterBy',
            'property' => 'value',
            'value' => 'doxxxx',
            'operator' => 'notStartWith',
        ));
        $this->assertEquals($passedContext->actions[2]->toArray(), array(
            'name' => 'filterBy',
            'property' => 'count',
            'value' => '[0-9]',
            'operator' => 'regExp',
        ));
        $this->assertEquals($passedContext->actions[3]->toArray(), array(
            'name' => 'filterBy',
            'property' => 'value',
            'value' => 'gs',
            'operator' => 'endWith',
        ));
        $this->assertEquals($passedContext->actions[4]->toArray(), array(
            'name' => 'filterBy',
            'property' => 'value',
            'value' => 'ggs',
            'operator' => 'notEndWith',
        ));
    }
}
