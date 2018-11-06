# IvoPetkov\DataListFilterByAction

extends [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

implements [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

Information about a filterBy action applied on a data list.

## Properties

##### public readonly string $operator

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The operator used for the filter. Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith, inArray, notInArray.

##### public readonly string $property

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name used for the filter.

##### public readonly string $value

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The value to filter on.

## Methods

##### public [__construct](ivopetkov.datalistfilterbyaction.__construct.method.md) ( string $name , string $property , string $value , string $operator )

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md):

##### public array [toArray](ivopetkov.datalistaction.toarray.method.md) ( void )

##### public string [toJSON](ivopetkov.datalistaction.tojson.method.md) ( void )

##### protected object [defineProperty](ivopetkov.datalistaction.defineproperty.method.md) ( string $name [, array $options = [] ] )

## Details

File: /src/DataListFilterByAction.php

---

[back to index](index.md)

