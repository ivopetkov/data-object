# IvoPetkov\DataListMapAction

Information about a map action applied on a data list.

```php
IvoPetkov\DataListMapAction extends IvoPetkov\DataListAction {

	/* Properties */
	public callable $callback

}
```

## Extends

##### [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Information about an action applied on a data list.

## Properties

##### public callable $callback

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The callback function to use.

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

Location: ~/src/DataListMapAction.php

---

[back to index](index.md)

