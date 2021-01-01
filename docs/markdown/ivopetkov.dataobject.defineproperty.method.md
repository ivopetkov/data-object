# IvoPetkov\DataObject::defineProperty

Defines a new property. Use closures with $this->privateProperty instead of local variables in the constructor (thay cannot be cloned).

```php
protected self defineProperty ( string $name [, array $options = [] ] )
```

## Parameters

##### name

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property name.

##### options

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The property options. Available values:
init (callable)
get (callable)
set (callable)
unset (callable)
readonly (boolean)
type (string)
encodeInJSON (boolean) - Base64 encode the value of the property when it's json encoded (in toJSON() for example). The default value is FALSE.

## Returns

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to the object.

## Details

Class: [IvoPetkov\DataObject](ivopetkov.dataobject.class.md)

Location: ~/src/DataObject.php

---

[back to index](index.md)

