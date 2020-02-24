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
trait DataListIteratorTrait
{

    /**
     * 
     */
    public function rewind(): void
    {
        $this->internalDataListPointer = 0;
    }

    /**
     * 
     * @return object|null
     * @throws \InvalidArgumentException
     */
    public function current()
    {
        $this->internalDataListUpdate();
        if (isset($this->internalDataListData[$this->internalDataListPointer])) {
            return $this->internalDataListUpdateValueIfNeeded($this->internalDataListData, $this->internalDataListPointer);
        }
        return null;
    }

    /**
     * 
     * @return int
     */
    public function key(): int
    {
        return $this->internalDataListPointer;
    }

    /**
     * 
     */
    public function next(): void
    {
        ++$this->internalDataListPointer;
    }

    /**
     * 
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function valid(): bool
    {
        $this->internalDataListUpdate();
        return isset($this->internalDataListData[$this->internalDataListPointer]);
    }
}
