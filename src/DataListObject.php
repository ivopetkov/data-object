<?php

/*
 * Data Object
 * https://github.com/ivopetkov/data-object
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace IvoPetkov;

/**
 * Information about an object in the data list.
 */
class DataListObject implements \ArrayAccess
{

    use DataObjectTrait;
    use DataObjectArrayAccessTrait;
    use DataObjectToArrayTrait;
    use DataObjectFromArrayTrait;
    use DataObjectToJSONTrait;
    use DataObjectFromJSONTrait;
}
