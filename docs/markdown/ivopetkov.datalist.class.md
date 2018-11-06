# IvoPetkov\DataList

implements [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php), [Iterator](http://php.net/manual/en/class.iterator.php), [Traversable](http://php.net/manual/en/class.traversable.php)

A list of data objects that can be easily filtered, sorted, etc. The objects can be lazy loaded using a callback in the constructor.

## Properties

##### public readonly int $length

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The number of objects in the list.

## Methods

##### public [__construct](ivopetkov.datalist.__construct.method.md) ( [ array|iterable|callback $dataSource ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data objects list.

##### public self [concat](ivopetkov.datalist.concat.method.md) ( [IvoPetkov\DataList](ivopetkov.datalist.class.md) $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends the items of the list provided to the current list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

##### public self [filter](ivopetkov.datalist.filter.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list using a callback function.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

##### public self [filterBy](ivopetkov.datalist.filterby.method.md) ( string $property , mixed $value [, string $operator = 'equal' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list by specific property value.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [get](ivopetkov.datalist.get.method.md) ( int $index )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object at the index specified or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The object at the index specified or null if not found.

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [getFirst](ivopetkov.datalist.getfirst.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the first object or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The first object or null if not found.

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [getLast](ivopetkov.datalist.getlast.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the last object or null if not found.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The last object or null if not found.

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [getRandom](ivopetkov.datalist.getrandom.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a random object from the list or null if the list is empty.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A random object from the list or null if the list is empty.

##### public self [map](ivopetkov.datalist.map.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Applies the callback to the objects of the list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [pop](ivopetkov.datalist.pop.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pops an object off the end of the list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns the popped object or null if the list is empty.

##### public self [push](ivopetkov.datalist.push.method.md) ( [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pushes an object onto the end of the list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

##### public self [reverse](ivopetkov.datalist.reverse.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reverses the order of the objects in the list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

##### public [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|null [shift](ivopetkov.datalist.shift.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift an object off the beginning of the list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns the shifted object or null if the list is empty.

##### public self [shuffle](ivopetkov.datalist.shuffle.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Randomly reorders the objects in the list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [slice](ivopetkov.datalist.slice.method.md) ( int $offset [, int $length ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Extract a slice of the list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a slice of the list.

##### public [IvoPetkov\DataList](ivopetkov.datalist.class.md) [sliceProperties](ivopetkov.datalist.sliceproperties.method.md) ( array $properties )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a new list of object that contain only the specified properties of the objects in the current list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: Returns a new list.

##### public self [sort](ivopetkov.datalist.sort.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list using a callback function.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

##### public self [sortBy](ivopetkov.datalist.sortby.method.md) ( string $property [, string $order = 'asc' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list by specific property.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

##### public array [toArray](ivopetkov.datalist.toarray.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as an array.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The list data converted as an array.

##### public string [toJSON](ivopetkov.datalist.tojson.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as JSON.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: The list data converted as JSON.

##### public self [unshift](ivopetkov.datalist.unshift.method.md) ( [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepends an object to the beginning of the list.

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns: A reference to the list.

## Details

File: /src/DataList.php

---

[back to index](index.md)

