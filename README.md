# Data Object

A familiar and powerful Data Object abstraction for PHP

[![Build Status](https://travis-ci.org/ivopetkov/data-object.svg)](https://travis-ci.org/ivopetkov/data-object)
[![Latest Stable Version](https://poser.pugx.org/ivopetkov/data-object/v/stable)](https://packagist.org/packages/ivopetkov/data-object)
[![codecov.io](https://codecov.io/github/ivopetkov/data-object/coverage.svg?branch=master)](https://codecov.io/github/ivopetkov/data-object?branch=master)
[![License](https://poser.pugx.org/ivopetkov/data-object/license)](https://packagist.org/packages/ivopetkov/data-object)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/0611e1c16b334baea92c8ba775bbf816)](https://www.codacy.com/app/ivo_2/data-object)

## Usage

Create an objects list from array
```php
use \IvoPetkov\DataList;

$data = [
    ['value' => 'a'],
    ['value' => 'b'],
    ['value' => 'c']
];
$list = new DataList($data);

// Can access the objects by index and get properties the following ways
echo $list[0]->value; // Output: a
echo $list[0]['value']; // Output: a

// Can loop through the objects
foreach($list as $object){
    echo $object->value;
}

```

And here are same helpful methods to modify the list
```php
use \IvoPetkov\DataList;

$list = new DataList([...]);
$list
    ->filterBy('property1', '...')
    ->sortBy('property2')
    ->map(function($object){});

```

## Install via Composer

```shell
composer require ivopetkov/data-object
```

## Documentation

#### IvoPetkov\DataList
##### Methods

```php
public __construct ( [ array $data = [] ] )
```

Constructs a new Data Object

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$data`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;An array containing DataObjects or arrays that will be converted into DataObjects

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No value is returned.

```php
public \IvoPetkov\DataList filter ( callback $callback )
```

Filters the elements of the list using a callback function

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$callback`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The callback function to use

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the list

```php
public \IvoPetkov\DataList filterBy ( string $property , mixed $value )
```

Filters the elements of the list by specific property value

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$property`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$value`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The value of the property

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the list

```php
public \IvoPetkov\DataList sort ( callback $callback )
```

Sorts the elements of the list using a callback function 

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$callback`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The callback function to use

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the list

```php
public \IvoPetkov\DataList sortBy ( string $property [, string $order = 'asc' ] )
```

Sorts the elements of the list by specific property

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$property`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$order`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The sort order

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the list

```php
public \IvoPetkov\DataList reverse ( void )
```

Reverses the order of the objects in the list

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the list

```php
public \IvoPetkov\DataList map ( callback $callback )
```

Applies the callback to the objects of the list

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$callback`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The callback function to use

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the list

```php
public \IvoPetkov\DataList unshift ( \IvoPetkov\DataObject|array $object )
```

Prepends an object to the beginning of the list

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$object`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The data to be prepended

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the list

```php
public \IvoPetkov\DataObject|null shift ( void )
```

Shift an object off the beginning of the list

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the shifted object or null if the list is empty

```php
public \IvoPetkov\DataList push ( \IvoPetkov\DataObject|array $object )
```

Pushes an object onto the end of the list

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$object`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The data to be pushed

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the list

```php
public \IvoPetkov\DataObject|null pop ( void )
```

Pops an object off the end of list

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the poped object or null if the list is empty

```php
public array toArray ( void )
```

Returns the list data converted as an array

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The list data converted as an array

```php
public string toJSON ( void )
```

Returns the list data converted as JSON

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The list data converted as JSON

#### IvoPetkov\DataObject
##### Methods

```php
public __construct ( [ array $data = [] ] )
```

Constructs a new data object

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$data`

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No value is returned.

```php
public void defineProperty ( string $name [, array $options = [] ] )
```

Defines a new property

_Parameters_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$name`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;`$options`

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property options ['get'=>callable, 'set'=>callable]

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No value is returned.

```php
public array toArray ( void )
```

Returns the object data converted as an array

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The object data converted as an array

```php
public string toJSON ( void )
```

Returns the object data converted as JSON

_Returns_

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The object data converted as JSON

## License
Data Object is open-sourced software. It's free to use under the MIT license. See the [license file](https://github.com/ivopetkov/data-object/blob/master/LICENSE) for more information.

## Author
This library is created by Ivo Petkov. Feel free to contact me at [@IvoPetkovCom](https://twitter.com/IvoPetkovCom) or [ivopetkov.com](https://ivopetkov.com).
