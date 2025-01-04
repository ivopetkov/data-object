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
trait DataListArrayAccessTrait
{

    /**
     * 
     * @param int $offset
     * @return \IvoPetkov\DataObject|null
     * @throws \InvalidArgumentException
     */
    #[\ReturnTypeWillChange] // Return type "mixed" is invalid in older supported versions.
    public function offsetGet($offset)
    {
        $this->internalDataListUpdate();
        if (isset($this->internalDataListData[$offset])) {
            return $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, $offset);
        }
        return null;
    }

    /**
     * 
     * @param int $offset
     * @param \IvoPetkov\DataObject|null $value
     * @return void
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function offsetSet($offset, $value): void
    {
        if (!is_int($offset) && $offset !== null) {
            throw new \Exception('The offset must be of type int or null');
        }
        $this->internalDataListUpdate();
        if (is_null($offset)) {
            $this->internalDataListData[] = $value;
            return;
        }
        if (is_int($offset) && $offset >= 0 && (isset($this->internalDataListData[$offset]) || $offset === count($this->internalDataListData))) {
            $this->internalDataListData[$offset] = $value;
            return;
        }
        throw new \Exception('The offset is not valid.');
    }

    /**
     * 
     * @param int $offset
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function offsetExists($offset): bool
    {
        $this->internalDataListUpdate();
        return isset($this->internalDataListData[$offset]);
    }

    /**
     * 
     * @param int $offset
     * @throws \InvalidArgumentException
     */
    public function offsetUnset($offset): void
    {
        $this->internalDataListUpdate();
        if (isset($this->internalDataListData[$offset])) {
            unset($this->internalDataListData[$offset]);
            $this->internalDataListData = array_values($this->internalDataListData);
        }
    }
}
