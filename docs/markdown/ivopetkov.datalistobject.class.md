# IvoPetkov\DataListObject

Information about an object in the data list.

```php
IvoPetkov\DataListObject implements ArrayAccess {

	/* Methods */
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

##### protected self [defineProperty](ivopetkov.datalistobject.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property. Use closures with $this->privateProperty instead of local variables in the constructor (thay cannot be cloned).

##### public static object [fromArray](ivopetkov.datalistobject.fromarray.method.md) ( array $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the array specified.

##### public static object [fromJSON](ivopetkov.datalistobject.fromjson.method.md) ( string $data )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creates an object and fills its properties from the JSON specified.

##### public array [toArray](ivopetkov.datalistobject.toarray.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](ivopetkov.datalistobject.tojson.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataListObject.php

---

[back to index](index.md)

