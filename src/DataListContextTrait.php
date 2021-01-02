<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 *
 */
trait DataListContextTrait
{

    /**
     * An array containing all the actions.
     * 
     * @var array 
     */
    public $actions = [];

    /**
     * Apply the actions to the data list specified.
     *
     * @return void
     */
    public function apply(&$list)
    {
        foreach ($this->actions as $action) {
            switch ($action->name) {
                case 'filter':
                    $list->filter($action->callback);
                    break;
                case 'filterBy':
                    $list->filterBy($action->property, $action->value, $action->operator);
                    break;
                case 'sort':
                    $list->sort($action->callback);
                    break;
                case 'sortBy':
                    $list->sortBy($action->property, $action->order);
                    break;
                case 'sliceProperties':
                    $list = $list->sliceProperties($action->properties);
                    break;
                case 'reverse':
                    $list->reverse();
                    break;
                case 'shuffle':
                    $list->shuffle();
                    break;
                case 'slice':
                    $list = $list->slice($action->offset, $action->limit);
                    break;
                case 'map':
                    $list->map($action->callback);
                    break;
                default:
                    throw new \Exception('Should not get here for "' . $action->name . '"!');
                    break;
            }
        }
    }
}
