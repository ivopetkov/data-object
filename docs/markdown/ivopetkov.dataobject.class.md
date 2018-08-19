# IvoPetkov\DataObject

implements [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Methods

##### protected $this [defineProperty](ivopetkov.dataobject.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### static public object [fromArray](ivopetkov.dataobject.fromarray.method.md) ( array $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the array specified.

##### static public object [fromJSON](ivopetkov.dataobject.fromjson.method.md) ( array $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the array specified.

##### protected void [initialize](ivopetkov.dataobject.initialize.method.md) ( void )

##### public array [toArray](ivopetkov.dataobject.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array

##### public string [toJSON](ivopetkov.dataobject.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON

## Details

File: /src/DataObject.php

