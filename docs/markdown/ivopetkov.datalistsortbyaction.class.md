# IvoPetkov\DataListSortByAction

Information about a sortBy action applied on a data list.

```php
IvoPetkov\DataListSortByAction extends IvoPetkov\DataListAction implements ArrayAccess {

	/* Properties */
	public readonly string $order
	public readonly string $property

	/* Methods */
	public __construct ( string $property , string $order )

}
```

## Extends

##### [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Information about an action applied on a data list.

## Implements

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Properties

##### public readonly string $order

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The sort order. Available values: asc and desc.

##### public readonly string $property

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name used for the sort.

## Methods

##### public [__construct](ivopetkov.datalistsortbyaction.__construct.method.md) ( string $property , string $order )

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

##### protected self [defineProperty](ivopetkov.datalistaction.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### public array [toArray](ivopetkov.datalistaction.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](ivopetkov.datalistaction.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataListSortByAction.php

---

[back to index](index.md)

