# IvoPetkov\DataObject

implements [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Methods

##### protected void [initialize](ivopetkov.dataobject.initialize.method.md) ( void )

##### protected $this [defineProperty](ivopetkov.dataobject.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### public array [toArray](ivopetkov.dataobject.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array

##### static public object [fromArray](ivopetkov.dataobject.fromarray.method.md) ( array $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the array specified.

##### public string [toJSON](ivopetkov.dataobject.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON

##### static public object [fromJSON](ivopetkov.dataobject.fromjson.method.md) ( array $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the array specified.

## Details

File: /src/DataObject.php

