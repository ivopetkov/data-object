# IvoPetkov\DataObject

A data object that supports registering properties and importing/exporting from array and JSON.

```php
IvoPetkov\DataObject implements ArrayAccess {

	/* Methods */
	public __construct ( [ array $data = [] ] )
	protected self defineProperty ( string $name [, array $options = [] ] )
	public static object fromArray ( array $data )
	public static object fromJSON ( string $data )
	public array toArray ( [ array $options = [] ] )
	public string toJSON ( [ array $options = [] ] )

}
```

## Implements

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Methods

##### public [__construct](ivopetkov.dataobject.__construct.method.md) ( [ array $data = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data object.

##### protected self [defineProperty](ivopetkov.dataobject.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property. Use closures with $this->privateProperty instead of local variables in the constructor (thay cannot be cloned).

##### public static object [fromArray](ivopetkov.dataobject.fromarray.method.md) ( array $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the array specified.

##### public static object [fromJSON](ivopetkov.dataobject.fromjson.method.md) ( string $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the JSON specified.

##### public array [toArray](ivopetkov.dataobject.toarray.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](ivopetkov.dataobject.tojson.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataObject.php

---

[back to index](index.md)

