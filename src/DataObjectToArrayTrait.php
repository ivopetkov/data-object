<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * 
 */
trait DataObjectToArrayTrait
{

    /**
     * Returns the object data converted as an array
     * 
     * @return array The object data converted as an array
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->internalDataObjectData as $name => $unknown) {
            $name = substr($name, 1);
            if (array_key_exists($name, $result) === false) {
                $value = $this->$name;
                if ($value instanceof \IvoPetkov\DataObject || $value instanceof DataList) {
                    $result[$name] = $value->toArray();
                } else {
                    $result[$name] = $value;
                }
            }
        }
        ksort($result);
        return $result;
    }

}
