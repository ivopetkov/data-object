# IvoPetkov\DataListSortByAction

Information about a sortBy action applied on a data list.

```php
IvoPetkov\DataListSortByAction extends IvoPetkov\DataListAction {

	/* Properties */
	public string $order
	public string $property

}
```

## Extends

##### [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Information about an action applied on a data list.

## Properties

##### public string $order

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The sort order. Available values: asc and desc.

##### public string $property

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name used for the sort.

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

##### public string $name

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The name of the action.

## Methods

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

##### public array [toArray](ivopetkov.datalistaction.toarray.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](ivopetkov.datalistaction.tojson.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataListSortByAction.php

---

[back to index](index.md)

