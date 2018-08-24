# IvoPetkov\DataList::filterBy

Filters the elements of the list by specific property value.

```php
public IvoPetkov\DataList filterBy ( string $property , mixed $value [, string $operator = 'equal' ] )
```

## Parameters

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$property`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$value`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The value of the property.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$operator`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Available values: equal, notEqual, regExp, notRegExp, startWith, notStartWith, endWith, notEndWith, inArray, notInArray.

## Returns

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A reference to the list.

## Details

Class: [IvoPetkov\DataList](ivopetkov.datalist.class.md)

File: /src/DataList.php

