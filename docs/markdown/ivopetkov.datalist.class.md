# IvoPetkov\DataList

implements [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php), [Iterator](http://php.net/manual/en/class.iterator.php), [Traversable](http://php.net/manual/en/class.traversable.php)

## Properties

##### public int $length

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The number of objects in the list

## Methods

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [get](ivopetkov.datalist.get.method.md) ( int $index )

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [getFirst](ivopetkov.datalist.getfirst.method.md) ( void )

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [getLast](ivopetkov.datalist.getlast.method.md) ( void )

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [getRandom](ivopetkov.datalist.getrandom.method.md) ( void )

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [filter](ivopetkov.datalist.filter.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list using a callback function

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [filterBy](ivopetkov.datalist.filterby.method.md) ( string $property , mixed $value [, string $operator = 'equal' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list by specific property value

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [sort](ivopetkov.datalist.sort.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list using a callback function 

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [sortBy](ivopetkov.datalist.sortby.method.md) ( string $property [, string $order = 'asc' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list by specific property

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [reverse](ivopetkov.datalist.reverse.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reverses the order of the objects in the list

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [shuffle](ivopetkov.datalist.shuffle.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Randomly reorders the objects in the list

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [map](ivopetkov.datalist.map.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Applies the callback to the objects of the list

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [unshift](ivopetkov.datalist.unshift.method.md) ( [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepends an object to the beginning of the list

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [shift](ivopetkov.datalist.shift.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift an object off the beginning of the list

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [push](ivopetkov.datalist.push.method.md) ( [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pushes an object onto the end of the list

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [pop](ivopetkov.datalist.pop.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pops an object off the end of the list

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [concat](ivopetkov.datalist.concat.method.md) ( $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends the items of the list provides to the current list

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [slice](ivopetkov.datalist.slice.method.md) ( $offset [, NULL $length ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Extract a slice of the list

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [sliceProperties](ivopetkov.datalist.sliceproperties.method.md) ( array $properties )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a new list of object that contain only the specified properties of the objects in the current list

##### public array [toArray](ivopetkov.datalist.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as an array

##### public string [toJSON](ivopetkov.datalist.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as JSON

## Details

File: /src/DataList.php

