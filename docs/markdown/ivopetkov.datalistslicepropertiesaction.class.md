# IvoPetkov\DataListSlicePropertiesAction

Information about a sliceProperties action applied on a data list.

```php
IvoPetkov\DataListSlicePropertiesAction extends IvoPetkov\DataListAction implements ArrayAccess {

	/* Properties */
	public readonly array $properties

	/* Methods */
	public __construct ( array $properties )

}
```

## Extends

##### [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Information about an action applied on a data list.

## Implements

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Properties

##### public readonly array $properties

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The properties list.

## Methods

##### public [__construct](ivopetkov.datalistslicepropertiesaction.__construct.method.md) ( array $properties )

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

##### protected self [defineProperty](ivopetkov.datalistaction.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### public array [toArray](ivopetkov.datalistaction.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](ivopetkov.datalistaction.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataListSlicePropertiesAction.php

---

[back to index](index.md)

