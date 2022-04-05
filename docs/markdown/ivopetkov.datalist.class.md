# IvoPetkov\DataList

A list of data objects that can be easily filtered, sorted, etc. The objects can be lazy loaded using a callback in the constructor.

```php
IvoPetkov\DataList implements ArrayAccess, Iterator, Countable, Traversable {

	/* Methods */
	public __construct ( [ array|iterable|callback $dataSource ] )
	public self concat ( array|iterable $list )
	public int count ( void )
	public self filter ( callable $callback )
	public self filterBy ( string $property , mixed $value [, string $operator = 'equal' ] )
	public object|null get ( int $index )
	public object|null getFirst ( void )
	public object|null getLast ( void )
	public object|null getRandom ( void )
	public self map ( callable $callback )
	public object|null pop ( void )
	public self push ( object|array $object )
	protected void registerDataListClass ( string $baseClass , string $newClass )
	public self reverse ( void )
	protected void setDataSource ( array|iterable|callback $dataSource )
	public object|null shift ( void )
	public self shuffle ( void )
	public mixed slice ( int $offset [, int $length ] )
	public mixed sliceProperties ( array $properties )
	public self sort ( callable $callback )
	public self sortBy ( string $property [, string $order = 'asc' ] )
	public array toArray ( [ array $options = [] ] )
	public string toJSON ( [ array $options = [] ] )
	public self unshift ( object|array $object )

}
```

## Implements

##### [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

##### [Iterator](http://php.net/manual/en/class.iterator.php)

##### [Countable](http://php.net/manual/en/class.countable.php)

##### [Traversable](http://php.net/manual/en/class.traversable.php)

## Methods

##### public [__construct](ivopetkov.datalist.__construct.method.md) ( [ array|iterable|callback $dataSource ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Constructs a new data objects list.

##### public self [concat](ivopetkov.datalist.concat.method.md) ( array|iterable $list )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Appends the items of the list provided to the current list.

##### public int [count](ivopetkov.datalist.count.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the number of items in the list.

##### public self [filter](ivopetkov.datalist.filter.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list using a callback function.

##### public self [filterBy](ivopetkov.datalist.filterby.method.md) ( string $property , mixed $value [, string $operator = 'equal' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Filters the elements of the list by specific property value.

##### public object|null [get](ivopetkov.datalist.get.method.md) ( int $index )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object at the index specified or null if not found.

##### public object|null [getFirst](ivopetkov.datalist.getfirst.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the first object or null if not found.

##### public object|null [getLast](ivopetkov.datalist.getlast.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the last object or null if not found.

##### public object|null [getRandom](ivopetkov.datalist.getrandom.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a random object from the list or null if the list is empty.

##### public self [map](ivopetkov.datalist.map.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Applies the callback to the objects of the list.

##### public object|null [pop](ivopetkov.datalist.pop.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pops an object off the end of the list.

##### public self [push](ivopetkov.datalist.push.method.md) ( object|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pushes an object onto the end of the list.

##### protected void [registerDataListClass](ivopetkov.datalist.registerdatalistclass.method.md) ( string $baseClass , string $newClass )

##### public self [reverse](ivopetkov.datalist.reverse.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reverses the order of the objects in the list.

##### protected void [setDataSource](ivopetkov.datalist.setdatasource.method.md) ( array|iterable|callback $dataSource )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sets a new data source for the list.

##### public object|null [shift](ivopetkov.datalist.shift.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift an object off the beginning of the list.

##### public self [shuffle](ivopetkov.datalist.shuffle.method.md) ( void )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Randomly reorders the objects in the list.

##### public mixed [slice](ivopetkov.datalist.slice.method.md) ( int $offset [, int $length ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Extract a slice of the list.

##### public mixed [sliceProperties](ivopetkov.datalist.sliceproperties.method.md) ( array $properties )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a new list of object that contain only the specified properties of the objects in the current list.

##### public self [sort](ivopetkov.datalist.sort.method.md) ( callable $callback )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list using a callback function.

##### public self [sortBy](ivopetkov.datalist.sortby.method.md) ( string $property [, string $order = 'asc' ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sorts the elements of the list by specific property.

##### public array [toArray](ivopetkov.datalist.toarray.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as an array.

##### public string [toJSON](ivopetkov.datalist.tojson.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the list data converted as JSON.

##### public self [unshift](ivopetkov.datalist.unshift.method.md) ( object|array $object )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Prepends an object to the beginning of the list.

## Details

Location: ~/src/DataList.php

---

[back to index](index.md)

