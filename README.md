# Data Object

A familiar and powerful Data Object abstraction for PHP.

[![Build Status](https://travis-ci.org/ivopetkov/data-object.svg)](https://travis-ci.org/ivopetkov/data-object)
[![Latest Stable Version](https://poser.pugx.org/ivopetkov/data-object/v/stable)](https://packagist.org/packages/ivopetkov/data-object)
[![codecov.io](https://codecov.io/github/ivopetkov/data-object/coverage.svg?branch=master)](https://codecov.io/github/ivopetkov/data-object?branch=master)
[![License](https://poser.pugx.org/ivopetkov/data-object/license)](https://packagist.org/packages/ivopetkov/data-object)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/0611e1c16b334baea92c8ba775bbf816)](https://www.codacy.com/app/ivo_2/data-object)

## Usage

Create an objects list from array:
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

And here are same helpful methods to modify the list:
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

Full [documentation](https://github.com/ivopetkov/data-object/blob/master/docs/markdown/index.md) is available as part of this repository.

## License
This project is licensed under the MIT License. See the [license file](https://github.com/ivopetkov/data-object/blob/master/LICENSE) for more information.

## Contributing
Feel free to open new issues and contribute to the project. Let's make it awesome and let's do in a positive way.

## Authors
This library is created and maintained by [Ivo Petkov](https://github.com/ivopetkov/) ([ivopetkov.com](https://ivopetkov.com)) and some [awesome folks](https://github.com/ivopetkov/data-object/graphs/contributors).

