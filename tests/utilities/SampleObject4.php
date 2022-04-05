<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class SampleObject4 extends \IvoPetkov\DataObject
{

    public function toJSON(array $options = []): string
    {
        return json_encode(['sampleObjectProperty1' => ["1", "'", '"']]);
    }

}
