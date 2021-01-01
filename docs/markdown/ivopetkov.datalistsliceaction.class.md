# IvoPetkov\DataListSliceAction

Information about a slice action applied on a data list.

```php
IvoPetkov\DataListSliceAction extends IvoPetkov\DataListAction {

	/* Properties */
	public int $limit
	public int $offset

}
```

## Extends

##### [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Information about an action applied on a data list.

## Properties

##### public int $limit

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The limit.

##### public int $offset

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The offset.

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

##### public string $name

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The name of the action.

## Methods

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

##### public array [toArray](ivopetkov.datalistaction.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](ivopetkov.datalistaction.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/DataListSliceAction.php

---

[back to index](index.md)

