# IvoPetkov\DataListFilterByAction

Information about a filterBy action applied on a data list.

```php
IvoPetkov\DataListFilterByAction extends IvoPetkov\DataListAction {

	/* Properties */
	public string $operator
	public string $property
	public string $value

}
```

## Extends

##### [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Information about an action applied on a data list.

## Properties

##### public string $operator

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The operator used for the filter. Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith, inArray, notInArray.

##### public string $property

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name used for the filter.

##### public string $value

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The value to filter on.

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

##### public string $name

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The name of the action.

## Details

Location: ~/src/DataListFilterByAction.php

---

[back to index](index.md)

