# IvoPetkov\DataListSortByAction

extends [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

implements [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

Information about a sortBy action applied on a data list.

## Properties

##### public readonly string $order

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The sort order. Available values: asc and desc.

##### public readonly string $property

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name used for the sort.

## Methods

##### public [__construct](ivopetkov.datalistsortbyaction.__construct.method.md) ( string $property , string $order )

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md):

##### public array [toArray](ivopetkov.datalistaction.toarray.method.md) ( void )

##### public string [toJSON](ivopetkov.datalistaction.tojson.method.md) ( void )

##### protected object [defineProperty](ivopetkov.datalistaction.defineproperty.method.md) ( string $name [, array $options = [] ] )

## Details

File: /src/DataListSortByAction.php

---

[back to index](index.md)

