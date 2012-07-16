PrettyArray
===========
This class does not have very much in it, and is planning on staying that way. Instead, it makes magic calls to the 'enumerator' class.
All methods in enumerator are static, which allows this class to call them statically or non-statically making PrettyArray very versatile.
When you are calling methods in enumerator it will always append the current array to the paramater list.

see
---
* PrettyArray::__call()
* PrettyArray::__callStatic()

Methods: __construct
====================
void **__construct** (array optional )


The default array can be passed as the first argument in the constructor.

Parameters
----------
  **optional**
    ```
    $defaults
    ```

Return
------
 void


Methods: offsetSet
==================
$value **offsetSet** (mixed $key , mixed $value )


Part of ArrayAccess. Allows PrettyArray to set a value based on the [] operator.

Parameters
----------
  **$key**

  **$value**

Return
------
 $value

Example 1
---------
```php
$arr = new PrettyArray();
$arr[] = 'new';
$arr->offsetSet(null, 2);
print_r($arr->to_a());
```

```

Array
(
    [0] => new
    [1] => 2
)

```


Methods: offsetExists
=====================
boolean **offsetExists** (mixed $key )


Part of ArrayAccess. If the offest exists.

Parameters
----------
  **$key**

Return
------
 boolean

Example 1
---------
```php
$arr = new PrettyArray();
$arr[0] = 'foobar';
var_dump(isset($arr[0])); // true
var_dump($arr->offsetExists(0)); // true
```

```

bool(true)
bool(true)

```


Methods: offsetUnset
====================
void **offsetUnset** (mixed $key )


Part of ArrayAccess. Will unset the value if it exists.

Parameters
----------
  **$key**

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray();
$arr[0] = 'foobar';
unset($arr[0]);
$arr[1] = 'foo';
$arr->offsetUnset(1);
print_r($arr->to_a());
```

```

Array
(
)

```


Methods: offsetGet
==================
type **offsetGet** (type $key )


Part of ArrayAccess. Will get the value of the current offset.

Parameters
----------
  **$key**

Return
------
 type

Example 1
---------
```php
$arr = new PrettyArray();
$arr[0] = 'foobar';
echo $arr[0] . PHP_EOL;
echo $arr->offsetGet(0);
```

```

foobar
foobar

```


Methods: __call
===============
mixed **__call** (string $method , array $params )


This serves two purposes.
The first is that it helps the destructive methods in this class become non-destructive giving them aliases.
The second is that is also proxies/mixins the static enumerable methods to non-static calls on this class and appends the current array as the first param.

Parameters
----------
  **$method**

  **$params**

Return
------
 mixed

Example 1
---------
```php
$arr = array(1,2,3);
enumerator::collect_($arr, function($key, &$value) {
	$value++;
	return;
});
print_r($arr);
```

```

Array
(
    [0] => 2
    [1] => 3
    [2] => 4
)

```

Example 2
---------
```php
$arr = new PrettyArray(array(2,3,4));
$arr->collect_(function($key, &$value) {
	$value--;
	return;
});
print_r($arr->to_a());
```

```

Array
(
    [0] => 1
    [1] => 2
    [2] => 3
)

```


Methods: __callStatic
=====================
mixed **__callStatic** (string $method , array $params )


A basic proxy for static methods on enumerator.

Parameters
----------
  **$method**

  **$params**

Return
------
 mixed

Example 1
---------
```php
$arr = array(1,2,3);
enumerator::collect($arr, function($key, &$value) {
	echo $value;
});
```

```

123

```

Example 2
---------
```php
$arr = array(1,2,3);
PrettyArray::collect($arr, function($key, &$value) {
	echo $value;
});
```

```

123

```


Methods: getRange_
==================
PrettyArray **getRange_** (mixed $start , mixed $end )


Will get a 'range' from PrettyArray. Calling it destructively will force the return value to be references to the current PrettyArray.

Parameters
----------
  **$start**

  **$end**

Return
------
 PrettyArray

Example 1
---------
```php
$arr = new PrettyArray(['swamp', 'desert', 'snow', 'rain', 'fog']);
$arr->getSet(1,3); // [ 1 => desert, 2 => snow, 3 => rain]
```

Example 2
---------
```php
$arr = new PrettyArray();
$arr['nasty'] = 'swamp';
$arr['hot'] = 'desert';
$arr['cold'] = 'snow';
$arr[] = 'rain';
$arr[] = 'fog';

$o = $arr->getRange('hot', 0)->to_a();
print_r($o);
```

```

Array
(
    [hot] => desert
    [cold] => snow
    [0] => rain
)

```


Methods: getSet, getSet_
========================
PrettyArray **getSet** (mixed $start , int $length )

PrettyArray **getSet_** (mixed $start , int $length )


Will get a 'set' from PrettyArray. Calling it destructively will force the return value to be references to the current PrettyArray.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-slice

Parameters
----------
  **$start**

  **$length**

Return
------
 PrettyArray

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3,4,5));
$o = $arr->getSet(1, 2)->to_a();
print_r($o);
```

```

Array
(
    [1] => 2
    [2] => 3
)

```


Methods: setByReference
=======================
$value **setByReference** (mixed $key , mixed $value )


By default you can't set by reference. This helps you do so.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-slice

Parameters
----------
  **$key**

  **&$value**

Return
------
$value
    ```
    from before
    ```

Example 1
---------
```php
$arr = new PrettyArray();
$a = 'foo';
$arr->setByReference('a', $a);
$a = 'bar';
echo $arr['a'];
```

```

bar

```


Methods: __toString
===================
string **__toString** ()


Method: __toString

Converts the PrettyArray into a print_r string.

Return
------
 string

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3));
echo $arr;
```

```

Array
(
    [0] => 1
    [1] => 2
    [2] => 3
)

```


Methods: to_a
=============
array **to_a** ()


Will return the array of data that PrettyArray has stored.

Return
------
 array

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3));
print_r($arr->to_a());
```

```

Array
(
    [0] => 1
    [1] => 2
    [2] => 3
)

```

