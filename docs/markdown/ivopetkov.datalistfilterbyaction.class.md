# IvoPetkov\DataListFilterByAction

Information about a filterBy action applied on a data list.

```php
IvoPetkov\DataListFilterByAction extends IvoPetkov\DataListAction implements ArrayAccess {

	/* Properties */
	public readonly string $operator
	public readonly string $property
	public readonly string $value

	/* Methods */
	public __construct ( string $property , string $value , string $operator )

}
```

## Extends

##### [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Information about an action applied on a data list.

## Implements

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

## Properties

##### public readonly string $operator

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The operator used for the filter. Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith, inArray, notInArray.

##### public readonly string $property

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name used for the filter.

##### public readonly string $value

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The value to filter on.

## Methods

##### public [__construct](ivopetkov.datalistfilterbyaction.__construct.method.md) ( string $property , string $value , string $operator )

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

##### protected self [defineProperty](ivopetkov.datalistaction.defineproperty.method.md) ( string $name [, array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Defines a new property.

##### public array [toArray](ivopetkov.datalistaction.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](ivopetkov.datalistaction.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataListFilterByAction.php

---

[back to index](index.md)

