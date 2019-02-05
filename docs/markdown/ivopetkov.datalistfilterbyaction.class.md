# IvoPetkov\DataListFilterByAction

Information about a filterBy action applied on a data list.

```php
IvoPetkov\DataListFilterByAction extends IvoPetkov\DataListAction {

	/* Properties */
	public string The operator used for the filter. Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith, inArray, notInArray. $operator
	public string The property name used for the filter. $property
	public string The value to filter on. $value

}
```

## Extends

##### [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Information about an action applied on a data list.

## Properties

##### public string The operator used for the filter. Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith, inArray, notInArray. $operator

##### public string The property name used for the filter. $property

##### public string The value to filter on. $value

### Inherited from [IvoPetkov\DataListAction](ivopetkov.datalistaction.class.md)

##### public string The name of the action. $name

## Details

Location: ~/src/DataListFilterByAction.php

---

[back to index](index.md)

