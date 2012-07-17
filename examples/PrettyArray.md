PrettyArray
===========
PrettyArray

This class does not have very much in it, and is planning on staying that way. Instead, it makes magic calls to the 'enumerator' class.
All methods in enumerator are static, which allows this class to call them statically or non-statically making PrettyArray very versatile.
When you are calling methods in enumerator through PrettyArray non-statically it will always prepend the current array to the paramater list.

Destructive methods
-------------------
Some methods that this class provides are 'destructive' similar to methods in Ruby that end in an exclamation mark (!).
Every destructive methods has a 'magic' alias which allow for non-destructive calls.

For example the method 'count_' has a callback which could modify the array, even though it never returns it.
The method 'select_' returns nothing by default and simply modifies the input array, however it's non-destructive alias would return the array.
The underscore is simply an extra precaution.

Method Aliases
--------------
Methods often have various aliases which are pointed out in the documentation. They work identically to the real function call.

see
---
* PrettyArray::__call()
* PrettyArray::__callStatic()

---------

Table Of Contents
=================
 * [\_\_construct](#method___construct)
 * [offsetSet](#method_offsetSet)
 * [offsetExists](#method_offsetExists)
 * [offsetUnset](#method_offsetUnset)
 * [offsetGet](#method_offsetGet)
 * [\_\_call](#method___call)
 * [\_\_callStatic](#method___callStatic)
 * [getRange\_](#method_getRange_)
 * [getSet](#method_getSet_)
 * [getSet\_](#method_getSet_)
 * [setByReference](#method_setByReference)
 * [\_\_toString](#method___toString)
 * [to\_a](#method_to_a)
 * [all](#method_all_)
 * [all\_](#method_all_)
 * [drop](#method_drop_)
 * [drop\_](#method_drop_)
 * [any](#method_any_)
 * [any\_](#method_any_)
 * [collect](#method_array_walk_)
 * [collect\_](#method_array_walk_)
 * [each](#method_array_walk_)
 * [each\_](#method_array_walk_)
 * [map](#method_array_walk_)
 * [map\_](#method_array_walk_)
 * [foreach](#method_array_walk_)
 * [foreach\_](#method_array_walk_)
 * [each\_with\_index](#method_array_walk_)
 * [each\_with\_index\_](#method_array_walk_)
 * [array\_walk](#method_array_walk_)
 * [count](#method_size_)
 * [count\_](#method_size_)
 * [size](#method_size_)
 * [size\_](#method_size_)
 * [length](#method_size_)
 * [length\_](#method_size_)
 * [detect](#method_find_)
 * [detect\_](#method_find_)
 * [find](#method_find_)
 * [find\_](#method_find_)
 * [select](#method_find_all_)
 * [select\_](#method_find_all_)
 * [find\_all](#method_find_all_)
 * [find\_all\_](#method_find_all_)
 * [keep\_if](#method_find_all_)
 * [keep\_if\_](#method_find_all_)
 * [each\_slice](#method_each_slice_)
 * [each\_slice\_](#method_each_slice_)
 * [first](#method_first_)
 * [first\_](#method_first_)
 * [collect\_concat](#method_flat_map_)
 * [collect\_concat\_](#method_flat_map_)
 * [flat\_map](#method_flat_map_)
 * [flat\_map\_](#method_flat_map_)
 * [grep](#method_grep_)
 * [grep\_](#method_grep_)
 * [group\_by](#method_group_by_)
 * [group\_by\_](#method_group_by_)
 * [member](#method_member)
 * [include](#method_member)
 * [min](#method_min)
 * [max](#method_max)
 * [min\_by](#method_min_by)
 * [max\_by](#method_max_by)
 * [minmax](#method_minmax)
 * [minmax\_by](#method_minmax_by)
 * [none](#method_none)
 * [one](#method_one)
 * [partition](#method_partition_)
 * [partition\_](#method_partition_)
 * [inject](#method_reduce_)
 * [inject\_](#method_reduce_)
 * [reduce](#method_reduce_)
 * [reduce\_](#method_reduce_)
 * [reject: reject\_](#method_delete_if_)
 * [delete\_if](#method_delete_if_)
 * [delete\_if\_](#method_delete_if_)
 * [reverse\_collect](#method_reverse_each_)
 * [reverse\_collect\_](#method_reverse_each_)
 * [reverse\_each](#method_reverse_each_)
 * [reverse\_each\_](#method_reverse_each_)
 * [reverse\_map](#method_reverse_each_)
 * [reverse\_map\_](#method_reverse_each_)
 * [reverse\_foreach](#method_reverse_each_)
 * [reverse\_foreach\_](#method_reverse_each_)
 * [reverse\_each\_with\_index](#method_reverse_each_)
 * [sort](#method_sort_)
 * [sort\_](#method_sort_)
 * [sort\_by](#method_sort_by_)
 * [sort\_by\_](#method_sort_by_)
 * [take\_while](#method_take_while_)
 * [take\_while\_](#method_take_while_)
 * [zip](#method_zip_)
 * [zip\_](#method_zip_)
 * [drop\_while](#method_drop_while_)
 * [drop\_while\_](#method_drop_while_)
 * [cycle](#method_cycle_)
 * [cycle\_](#method_cycle_)
 * [each\_cons](#method_each_cons_)
 * [each\_cons\_](#method_each_cons_)
 * [slice\_before](#method_slice_before_)
 * [slice\_before\_](#method_slice_before_)
 * [merge](#method_concat_)
 * [merge\_](#method_concat_)
 * [concat](#method_concat_)
 * [concat\_](#method_concat_)
 * [rotate](#method_rotate_)
 * [rotate\_](#method_rotate_)
 * [reverse](#method_reverse_)
 * [reverse\_](#method_reverse_)
 * [random](#method_sample_)
 * [random\_](#method_sample_)
 * [sample](#method_sample_)
 * [sample\_](#method_sample_)
 * [shuffle](#method_shuffle_)
 * [shuffle\_](#method_shuffle_)
 * [values\_at](#method_values_at_)
 * [values\_at\_](#method_values_at_)
 * [empty](#method_isEmpty)
 * [isEmpty](#method_isEmpty)
 * [has\_value](#method_has_value)
 * [index](#method_find_index_)
 * [index\_](#method_find_index_)
 * [find\_index](#method_find_index_)
 * [find\_index\_](#method_find_index_)
 * [rindex](#method_rindex_)
 * [rindex\_](#method_rindex_)
 * [compact](#method_compact_)
 * [compact\_](#method_compact_)

<a name="method___construct"></a>Methods: \_\_construct
====================
void **\_\_construct** (array optional )


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


<a name="method_offsetSet"></a>Methods: offsetSet
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


<a name="method_offsetExists"></a>Methods: offsetExists
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


<a name="method_offsetUnset"></a>Methods: offsetUnset
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


<a name="method_offsetGet"></a>Methods: offsetGet
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


<a name="method___call"></a>Methods: \_\_call
===============
mixed **\_\_call** (string $method , array $params )


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
$arr = new PrettyArray(array(1,2,3));
$arr->collect_(function($key, &$value) {
	$value++;
	return;
});
print_r($arr->to_a());
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


<a name="method___callStatic"></a>Methods: \_\_callStatic
=====================
mixed **\_\_callStatic** (string $method , array $params )


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
$arr = new PrettyArray(array(1,2,3));
$arr->collect(function($key, &$value) {
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


<a name="method_getRange_"></a>Methods: getRange\_
==================
PrettyArray **getRange\_** (mixed $start , mixed $end )


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


<a name="method_getSet_"></a>Methods: getSet, getSet\_
========================
PrettyArray **getSet** (mixed $start , int $length )

PrettyArray **getSet\_** (mixed $start , int $length )


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


<a name="method_setByReference"></a>Methods: setByReference
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


<a name="method___toString"></a>Methods: \_\_toString
===================
string **\_\_toString** ()


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


<a name="method_to_a"></a>Methods: to\_a
=============
array **to\_a** ()


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


<a name="method_all_"></a>Methods: all, all\_
==================
boolean **all** (array $arr [, callable $callback = NULL ] )

boolean **all\_** (array &$arr [, callable $callback = NULL ] )


Passes each element of the collection to the $callback, if it ever turns false or null this function will return false, else true.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-all-3F

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

Return
------
 boolean

Example 1
---------
```php
$animals = new PrettyArray(array('ant', 'bear', 'cat'));
$o = $animals->all(function($key, &$value) {
	return (strlen($value) >= 3);
});
var_dump($o);
```

```
bool(true)
```

Example 2
---------
```php
$animals = new PrettyArray(array('ant', 'bear', 'cat'));
$o = $animals->all(function($key, &$value) {
	return (strlen($value) >= 4);
});
var_dump($o);
```

```
bool(false)
```

Example 3
---------
```php
$arr = new PrettyArray(array(null, true, 99));
$o = $arr->all();
var_dump($o);
```

```
bool(false)
```


<a name="method_drop_"></a>Methods: drop, drop\_
====================
void **drop** (array $arr , int $count )

void **drop\_** (array &$arr , int $count )


Drops the first $count elements.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop

Parameters
----------
  **&$arr**

  **$count**

Return
------
 void

Example 1
---------
```php
$animals = new PrettyArray(array('ant', 'bear', 'cat'));
$animals->drop_(1);
print_r($animals->to_a());
```

```
Array
(
    [0] => bear
    [1] => cat
)
```


<a name="method_any_"></a>Methods: any, any\_
==================
boolean **any** (array $arr [, callable $callback = NULL ] )

boolean **any\_** (array $arr [, callable $callback = NULL ] )


Passes each element of the collection to the $callback, if it ever returns anything besides null or false I'll return true, else I'll return false.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-any-3F

Parameters
----------
  **$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

Return
------
 boolean

Example 1
---------
```php
$animals = new PrettyArray(array('ant', 'bear', 'cat'));
$o = $animals->any(function($key, &$value) {
	return (strlen($value) >= 3);
});
var_dump($o);
```

```
bool(true)
```

Example 2
---------
```php
$animals = new PrettyArray(array('ant', 'bear', 'cat'));
$o = $animals->any(function($key, &$value) {
	return (strlen($value) >= 4);
});
var_dump($o);
```

```
bool(true)
```

Example 3
---------
```php
$arr = new PrettyArray(array(null, true, 99));
$o = $arr->any($arr);
var_dump($o);
```

```
bool(true)
```


<a name="method_array_walk_"></a>Methods: collect, collect\_, each, each\_, map, map\_, foreach, foreach\_, each\_with\_index, each\_with\_index\_, array\_walk
====================================================================================================================
void **collect** (array $arr , callable $callback )

void **collect\_** (array &$arr , callable $callback )

void **each** (array $arr , callable $callback )

void **each\_** (array &$arr , callable $callback )

void **map** (array $arr , callable $callback )

void **map\_** (array &$arr , callable $callback )

void **foreach** (array $arr , callable $callback )

void **foreach\_** (array &$arr , callable $callback )

void **each\_with\_index** (array &$arr , callable $callback )

void **each\_with\_index\_** (array &$arr , callable $callback )

void **array\_walk** (array &$arr , callable $callback )


Will iterate the elements in the array. Has the potential to change the values.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-collect

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(range(1,4));
$arr->collect_(function($key, &$value) {
	$value *= $value;
	return;
});
print_r($arr->to_a());
```

```
Array
(
    [0] => 1
    [1] => 4
    [2] => 9
    [3] => 16
)
```

Example 2
---------
```php
$arr = new PrettyArray(range(1,4));
$o = $arr->collect(function($key, &$value) {
	$value = "cat";
	return;
});
print_r($o->to_a());
```

```
Array
(
    [0] => cat
    [1] => cat
    [2] => cat
    [3] => cat
)
```


<a name="method_size_"></a>Methods: count, count\_, size, size\_, length, length\_
====================================================
int **count** (array $arr , callable $callback )

int **count\_** (array &$arr , callable $callback )

int **size** (array $arr , callable $callback )

int **size\_** (array &$arr , callable $callback )

int **length** (array $arr , callable $callback )

int **length\_** (array &$arr , callable $callback )


If the callback is null, this function give you the total size of the array.
If the callback is a anonmous function, this function iterate the blocks and count how many times it returns true.
Otherwise this function will count how many times $callback is equal to $value.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Enumerable.html#method-i-count

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

Return
------
 int

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,4,2));
echo $arr->count();
```

```
4
```

Example 2
---------
```php
$arr = new PrettyArray(array(1,2,4,2));
echo $arr->count(2);
```

```
2
```

Example 3
---------
```php
$arr = new PrettyArray(array(1,2,4,2));
echo $arr->count(function($key, &$value) {
	return ($value % 2 == 0);
});
```

```
3
```


<a name="method_find_"></a>Methods: detect, detect\_, find, find\_
=====================================
mixed **detect** (array $arr , callable $callback [, mixed $ifnone = NULL ] )

mixed **detect\_** (array &$arr , callable $callback [, mixed $ifnone = NULL ] )

mixed **find** (array $arr , callable $callback [, mixed $ifnone = NULL ] )

mixed **find\_** (array &$arr , callable $callback [, mixed $ifnone = NULL ] )


Will pass the key and value to $callback the first result that does not return false is returned.
If no results are found this function will return the result of $ifnone (mixed) if none is provided false will be returned.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-detect

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

  **$ifnone**

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(range(1,10));
$o = $arr->detect(function($key, &$value) {
	return ($value % 5 == 0 and $value % 7 == 0);
});
var_dump($o);
```

```
NULL
```

Example 2
---------
```php
$arr = new PrettyArray(range(1,100));
echo $arr->detect(function($key, &$value) {
	return ($value % 5 == 0 and $value % 7 == 0);
});
```

```
35
```


<a name="method_find_all_"></a>Methods: select, select\_, find\_all, find\_all\_, keep\_if, keep\_if\_
================================================================
array **select** (array $arr , callable $callback )

array **select\_** (array &$arr , callable $callback )

array **find\_all** (array &$arr , callable $callback )

array **find\_all\_** (array &$arr , callable $callback )

array **keep\_if** (array &$arr , callable $callback )

array **keep\_if\_** (array &$arr , callable $callback )


Will pass the elements to the callback and unset them if the callback returns false.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-select

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

Return
------
array
    ```
    The array that has already been edited by reference.
    ```

Example 1
---------
```php
$arr = new PrettyArray(range(1,10));
$arr->select_(function($key, &$value) {
	return ($value % 3 == 0);
});
print_r($arr->to_a());
```

```
Array
(
    [2] => 3
    [5] => 6
    [8] => 9
)
```


<a name="method_each_slice_"></a>Methods: each\_slice, each\_slice\_
================================
void **each\_slice** (array &$arr , int $size [, callable $callback = NULL ] )

void **each\_slice\_** (array &$arr , int $size [, callable $callback = NULL ] )


Will slice the elements into $size collections and pass to $callback if defined. If not defined, the slized array is returned.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-each_slice

Parameters
----------
  **&$arr**

  **$size**
    ```
    The size of each slice.
    ```

  **$callback**
    ```
    The callback will be passed each collection. This can be passed by reference.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(range(1,10));
$arr->each_slice_(3, function(&$collection) {
	foreach($collection as $key => &$value) ++$value;
	return;
});
print_r($arr->to_a());
```

```
Array
(
    [0] => Array
        (
            [0] => 2
            [1] => 3
            [2] => 4
        )

    [1] => Array
        (

            [0] => 5
            [1] => 6
            [2] => 7
        )

    [2] => Array
        (
            [0] => 8
            [1] => 9
            [2] => 10
        )

    [3] => Array
        (
            [0] => 11
        )

)
```


<a name="method_first_"></a>Methods: first, first\_
======================
void **first** (array $arr [, int $count = 1 ] )

void **first\_** (array &$arr [, int $count = 1 ] )


Will overwrite $arr with the first $count items in array.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-first

Parameters
----------
  **&$arr**

  **$count**
    ```
    The number of items you wish to return. Defaults to 1
    ```

Return
------
 void

Example 1
---------
```php
$animals = new PrettyArray(array('cat', 'dog', 'cow', 'pig'));
$o = $animals->first();
print_r($o->to_a());
```

```
Array
(
    [0] => cat
)
```

Example 2
---------
```php
$animals = new PrettyArray(array('cat', 'dog', 'cow', 'pig'));
$animals->first_(2);
print_r($animals->to_a());
```

```
Array
(
    [0] => cat
    [1] => dog
)
```


<a name="method_flat_map_"></a>Methods: collect\_concat, collect\_concat\_, flat\_map, flat\_map\_
=============================================================
void **collect\_concat** (array &$arr , callable $callback )

void **collect\_concat\_** (array &$arr , callable $callback )

void **flat\_map** (array &$arr , callable $callback )

void **flat\_map\_** (array &$arr , callable $callback )


Will flatten the input $arr into a non-multi-dimensional array.It will pass the current key and the value to $callback which has the potential to change the value.
The new array will have discarded all current keys.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-flat_map

Parameters
----------
  **&$arr**

  **$callback**
    ```
    The callback will be passed each sliced item as an array. This can be passed by reference.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(array(1,2),array(3,4)));
$arr->collect_concat_(function($key, &$value) {
	return ++$value;
});
print_r($arr->to_a());
```

```
Array
(
    [0] => 2
    [1] => 3
    [2] => 4
    [3] => 5
)
```


<a name="method_grep_"></a>Methods: grep, grep\_
====================
void **grep** (array $arr , string $pattern [, callable $callback = NULL ] )

void **grep\_** (array &$arr , string $pattern [, callable $callback = NULL ] )


Will only keep an item if the value of the item matches $pattern.
If a callback is provided, it will pass the $key and $value into the array.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-grep

Parameters
----------
  **&$arr**

  **$pattern**
    ```
    The regex pattern.
    ```

  **$callback**
    ```
    The callback will be passed each sliced item as an array. This can be passed by reference.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
$arr->grep_("/^snow/");
print_r($arr->to_a());
```

```
Array
(
    [0] => snowball
    [1] => snowcone
    [2] => snowangel
)
```


<a name="method_group_by_"></a>Methods: group\_by, group\_by\_
============================
void **group\_by** (array &$arr , callable $callback [, boolean $preserve_keys = false ] )

void **group\_by\_** (array &$arr , callable $callback [, boolean $preserve_keys = false ] )


Each item will be passed into $callback and the return value will be the new "category" of this item.
The param $arr will be replaced with an array of these categories with all of their items.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-group_by

Parameters
----------
  **&$arr**

  **$callback**
    ```
    The callback will be passed each sliced item as an array. This can be passed by reference.
    ```

  **$preserve_keys**
    ```
    If you want to preserve the keys or not.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(range(1,6));
$o = $arr->group_by(function($key, &$value) {
	return ($value % 3);
});
print_r($o->to_a());
```

```
Array
(
    [0] => Array
        (
            [0] => 3
            [1] => 6
        )

    [1] => Array
        (
            [0] => 1
            [1] => 4
        )

    [2] => Array
        (
            [0] => 2
            [1] => 5
        )

)
```


<a name="method_member"></a>Methods: member, include
========================
boolean **member** (array $arr , mixed $needle )

boolean **include** (array $arr , mixed $needle )


This function will iterate over $arr, if any value is equal (===) to $needle this function will return true. If nothing is found this function will return false.
NOTICE: that 'include' alias is a language construct so this alias cannot be called directly. Refer to example #2.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-member-3F

Parameters
----------
  **$arr**

  **$needle**

Return
------
 boolean

Example 1
---------
```php
$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
$o = $arr->member('snowcone');
var_dump($o);
```

```
bool(true)
```

Example 2
---------
```php
$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
$o = $arr->member('snowman');
var_dump($o);
```

```
bool(false)
```

Example 3
---------
```php
$fun = 'include';
$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
$o = $arr->$fun('snowcone');
var_dump($o);
```

```
bool(true)
```


<a name="method_min"></a>Methods: min
============
mixed **min** (array $arr , callback optional )


Will find the lowest value. If callback is defined it will compare them.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-min

Parameters
----------
  **$arr**

  **optional**
    ```
    $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
    ```

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array('albatross','dog','horse'));
echo $arr->min();
```

```
albatross
```

Example 2
---------
```php
$arr = new PrettyArray(array('albatross','dog','horse'));
echo $arr->min(function($val1, $val2) {
	return strcmp(strlen($val1), strlen($val2));
});
```

```
dog
```


<a name="method_max"></a>Methods: max
============
mixed **max** (array $arr , callback optional )


Will find the highest value. If callback is defined it will compare them.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-max

Parameters
----------
  **$arr**

  **optional**
    ```
    $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
    ```

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array('albatross','dog','horse'));
echo $arr->max();
```

```
horse
```

Example 2
---------
```php
$arr = new PrettyArray(array('albatross','dog','horse'));
echo $arr->max(function($val1, $val2) {
	return strcmp(strlen($val1), strlen($val2));
});
```

```
albatross
```


<a name="method_min_by"></a>Methods: min\_by
===============
mixed **min\_by** (array $arr , callable $callback )


Will find the lowest item in the array but comparing the output os $callback against every item.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-min_by

Parameters
----------
  **$arr**

  **$callback**

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array('albatross','dog','horse'));
echo $arr->min_by(function($val) { 
	return strlen($val); 
});
```

```
dog
```


<a name="method_max_by"></a>Methods: max\_by
===============
mixed **max\_by** (array $arr , callable $callback )


Will find the highest item in the array but comparing the output os $callback against every item.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-max_by

Parameters
----------
  **$arr**

  **$callback**

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array('albatross','dog','horse'));
echo $arr->max_by(function($val) {
	return strlen($val);
});
```

```
albatross
```


<a name="method_minmax"></a>Methods: minmax
===============
array **minmax** (array $arr , callback optional )


Will return an array of min and max. Optionally you can provide a callback to sort them.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-minmax

Parameters
----------
  **$arr**

  **optional**
    ```
    $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
    ```

Return
------
 array

Example 1
---------
```php
$arr = new PrettyArray(array('albatross','dog','horse'));
$o = $arr->minmax(function($val1, $val2) { 
	return strcmp(strlen($val1), strlen($val2));
});
print_r($o->to_a());
```

```
Array
(
    [0] => dog
    [1] => albatross
)
```


<a name="method_minmax_by"></a>Methods: minmax\_by
==================
array **minmax\_by** (array $arr , callable $callback )


Will find the lowest and highest item in the array but comparing the output os $callback against every item.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-minmax_by

Parameters
----------
  **$arr**

  **$callback**

Return
------
 array

Example 1
---------
```php
$arr = new PrettyArray(array('albatross','dog','horse'));
$o = $arr->minmax_by(function($val) { 
	return strlen($val);
});
print_r($o->to_a());
```

```
Array
(
    [0] => dog
    [1] => albatross
)
```


<a name="method_none"></a>Methods: none
=============
boolean **none** (array $arr [, callable $callback = NULL ] )


Passes each element of the collection to $callback. This will return true if $callback never returns true, else false.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-none-3F

Parameters
----------
  **$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

Return
------
 boolean

Example 1
---------
```php
$arr = new PrettyArray(array('ant', 'bear', 'cat'));
$o = $arr->none(function($key, $value) {
	return (strlen($value) == 5);
});
var_dump($o);
```

```
bool(true)
```

Example 2
---------
```php
$arr = new PrettyArray(array('ant', 'bear', 'cat'));
$o = $arr->none(function($key, $value) {
	return (strlen($value) >= 4);
});
var_dump($o);
```

```
bool(false)
```

Example 3
---------
```php
$arr = new PrettyArray();
$o = $arr->none();
var_dump($o);
```

```
bool(true)
```

Example 4
---------
```php
$arr = new PrettyArray(array(null));
$o = $arr->none();
var_dump($o);
```

```
bool(true)
```

Example 5
---------
```php
$arr = new PrettyArray(array(null, false));
$o = $arr->none();
var_dump($o);
```

```
bool(true)
```


<a name="method_one"></a>Methods: one
============
boolean **one** (array $arr [, callable $callback = NULL ] )


Pases each element of the collection to $callback. If $callback returns true once, the function will return true. Otherwise, the function will return false.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-one-3F

Parameters
----------
  **$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

Return
------
 boolean

Example 1
---------
```php
$arr = new PrettyArray(array('ant','bear','cat'));
$o = $arr->one(function($key, $value) {
	return (strlen($value) == 4);
});
var_dump($o);
```

```
bool(true)
```

Example 2
---------
```php
$arr = new PrettyArray(array(null, true, 99));
$o = $arr->one();
var_dump($o);
```

```
bool(false)
```

Example 3
---------
```php
$arr = new PrettyArray(array(null, true, false));
$o = $arr->one();
var_dump($o);
```

```
bool(true)
```


<a name="method_partition_"></a>Methods: partition, partition\_
==============================
void **partition** (array $arr , callable $callback [, boolean $preserve_keys = false ] )

void **partition\_** (array &$arr , callable $callback [, boolean $preserve_keys = false ] )


Passes each element into $callback. If $callback returns true the item will be in the first category, otherwise the second.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-partition

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

  **$preserve_keys**

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(range(1,6));
$o = $arr->partition(function($key, $value) {
	return ($value % 2 == 0);
});
print_r($o->to_a());
```

```
Array
(
    [0] => Array
        (
            [0] => 2
            [1] => 4
            [2] => 6
        )

    [1] => Array
        (
            [0] => 1
            [1] => 3
            [2] => 5
        )
)
```


<a name="method_reduce_"></a>Methods: inject, inject\_, reduce, reduce\_
=========================================
mixed **inject** (array $arr , callable $callback , mixed optional )

mixed **inject\_** (array &$arr , callable $callback , mixed optional )

mixed **reduce** (array $arr , callable $callback , mixed optional )

mixed **reduce\_** (array &$arr , callable $callback , mixed optional )


Will iterate the items in $arr passing each one to $callback with $memo as the third argument.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-inject

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

  **optional**
    ```
    $memo This value is passed to all callback. Be sure to accept it by reference. Defaults to 0 (zero).
    ```

Return
------
mixed
    ```
    The memo variable.
    ```

Example 1
---------
```php
$arr = new PrettyArray(range(5, 10));
echo $arr->inject(function($key, &$value, &$memo){
	$memo += $value;
	return;
});
```

```
45
```

Example 2
---------
```php
$arr = new PrettyArray(range(5, 10));
echo $arr->inject(function($key, &$value, &$memo){
	$memo *= $value;
	return;
}, 1);
```

```
151200
```


<a name="method_delete_if_"></a>Methods: reject: reject\_, delete\_if, delete\_if\_
===============================================
void **reject: reject\_** (array &$arr , callable $callback )

void **delete\_if** (array &$arr , callable $callback )

void **delete\_if\_** (array &$arr , callable $callback )


Will unset an item in $arr if $callback returns true for it.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-reject

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback. The $value can be passed by reference.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(range(1,10));
$arr->reject_(function($key, $value) {
	return ($value % 3 == 0);
});
print_r($arr->to_a());
```

```
Array
(
    [0] => 1
    [1] => 2
    [3] => 4
    [4] => 5
    [6] => 7
    [7] => 8
    [9] => 10
)
```


<a name="method_reverse_each_"></a>Methods: reverse\_collect, reverse\_collect\_, reverse\_each, reverse\_each\_, reverse\_map, reverse\_map\_, reverse\_foreach, reverse\_foreach\_, reverse\_each\_with\_index
==============================================================================================================================================================
void **reverse\_collect** (array &$arr , callable $callback )

void **reverse\_collect\_** (array &$arr , callable $callback )

void **reverse\_each** (array &$arr , callable $callback )

void **reverse\_each\_** (array &$arr , callable $callback )

void **reverse\_map** (array &$arr , callable $callback )

void **reverse\_map\_** (array &$arr , callable $callback )

void **reverse\_foreach** (array &$arr , callable $callback )

void **reverse\_foreach\_** (array &$arr , callable $callback )

void **reverse\_each\_with\_index** (array &$arr , callable $callback )


Will iterate the array in reverse, but will NOT save the order.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-reverse_each

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback. The $value can be passed by reference.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(1, 2, 3));
$arr->reverse_collect(function($key, &$value) {
	echo $value . ', ';
	return;
});
```

```
3, 2, 1,
```


<a name="method_sort_"></a>Methods: sort, sort\_
====================
void **sort** (array $arr [, callable $callback = NULL ] )

void **sort\_** (array &$arr [, callable $callback = NULL ] )


Will sort the contents of $arr. A callback can be used to sort.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-sort

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback. The $value can be passed by reference.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
$arr->sort_();
print_r($arr->to_a());
```

```
Array
(
    [0] => flea
    [1] => kea
    [2] => rhea
)
```

Example 2
---------
```php
$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
$arr->sort_(function($val1, $val2) {
	return strcmp($val2, $val1);
});
print_r($arr->to_a());
```

```
Array
(
    [0] => rhea
    [1] => kea
    [2] => flea
)
```


<a name="method_sort_by_"></a>Methods: sort\_by, sort\_by\_
==========================
void **sort\_by** (array &$arr , callable $callback )

void **sort\_by\_** (array &$arr , callable $callback )


Will sort based off of the return of $callback.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-sort_by

Parameters
----------
  **&$arr**

  **$callback**

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
$arr->sort_by_(function($val) {
	return strlen($val);
});
print_r($arr->to_a());
```

```
Array
(
    [0] => kea
    [1] => flea
    [2] => rhea
)
```


<a name="method_take_while_"></a>Methods: take\_while, take\_while\_
================================
void **take\_while** (array &$arr , callable $callback )

void **take\_while\_** (array &$arr , callable $callback )


Passes elements into $callback until it returns false or null, at which point this function will stop and set $arr to all prior elements.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-take_while

Parameters
----------
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3,4,5,0));
$arr->take_while_(function($key, &$value) {
	return ($value < 3);
});
print_r($arr->to_a());
```

```
Array
(
    [0] => 1
    [1] => 2
)
```


<a name="method_zip_"></a>Methods: zip, zip\_
==================
void **zip** (array $arr , array $one )

void **zip\_** (array &$arr , array $one )


Will turn each element in $arr into an array then appending the associated indexs from the other arrays into this array as well.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-zip

Parameters
----------
  **&$arr**

  **$one**
    ```
    Unlimited of this.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3));
$arr->zip_(array(4,5,6), array(7,8,9));
print_r($arr->to_a());
```

```
Array
(
    [0] => Array
        (
            [0] => 1
            [1] => 4
            [2] => 7
        )

    [1] => Array
        (
            [0] => 2
            [1] => 5
            [2] => 8
        )

    [2] => Array
       (

            [0] => 3
            [1] => 6
            [2] => 9
        )

)
```

Example 2
---------
```php
$arr = new PrettyArray(array(1,2));
$o = $arr->zip(array(4,5,6),array(7,8,9));
print_r($o->to_a());
```

```
Array
(
    [0] => Array
        (
            [0] => 1
            [1] => 4
            [2] => 7
        )

    [1] => Array
        (
            [0] => 2
            [1] => 5
            [2] => 8
        )

)
```

Example 3
---------
```php
$arr = new PrettyArray(array(4,5,6));
$o = $arr->zip(array(1,2), array(8));
print_r($o->to_a());
```

```
Array
(
    [0] => Array
        (
            [0] => 4
            [1] => 1
            [2] => 8
        )

    [1] => Array
        (
            [0] => 5
            [1] => 2
            [2] => 
        )

    [2] => Array
        (
            [0] => 6
            [1] => 
            [2] => 
        )

)
```


<a name="method_drop_while_"></a>Methods: drop\_while, drop\_while\_
================================
void **drop\_while** (array &$arr , callable $callback )

void **drop\_while\_** (array &$arr , callable $callback )


Will pass elements into $callback until false is returned at which point all elements before the current one will be removed.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop_while

Parameters
----------
  **&$arr**

  **$callback**

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3,4,5,0));
$arr->drop_while_(function($key, &$value) {
	return ($value < 3);
});
print_r($arr->to_a());
```

```
Array
(
    [0] => 3
    [1] => 4
    [2] => 5
    [3] => 0
)
```


<a name="method_cycle_"></a>Methods: cycle, cycle\_
======================
void **cycle** (array $arr , int $it , callable $callback )

void **cycle\_** (array $arr , int $it , callable $callback )


Will pass every element of $arr into $callback exactly $it times.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-cycle

Parameters
----------
  **$arr**

  **$it**

  **$callback**
    ```
    This can accept 3 arguments: $key - The key in the array, $value - The value of this key, $it - The current iteration.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3));
$arr->cycle(3, function($key, $value, $it) {
	echo $value . ',';
});
```

```
1,2,3,1,2,3,1,2,3,
```


<a name="method_each_cons_"></a>Methods: each\_cons, each\_cons\_
==============================
void **each\_cons** (array &$arr , int $size [, callable $callback = false ] )

void **each\_cons\_** (array &$arr , int $size [, callable $callback = false ] )


This will return each section as an item in an array.
A section is each consecutive $size of $arr.
It will also iterate over each item in every section.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-each_cons

Parameters
----------
  **&$arr**

  **$size**

  **$callback**

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(range(1,10));
$arr->each_cons_(8);
print_r($arr->to_a());
```

```
Array
(
    [0] => Array
        (
            [0] => 1
            [1] => 2
            [2] => 3
            [3] => 4
            [4] => 5
            [5] => 6
            [6] => 7
            [7] => 8
        )

    [1] => Array
        (
            [0] => 2
            [1] => 3
            [2] => 4
            [3] => 5
            [4] => 6
            [5] => 7
            [6] => 8
            [7] => 9
        )

    [2] => Array
        (
            [0] => 3
            [1] => 4
            [2] => 5
            [3] => 6
            [4] => 7
            [5] => 8
            [6] => 9
            [7] => 10
        )

)
```


<a name="method_slice_before_"></a>Methods: slice\_before, slice\_before\_
====================================
void **slice\_before** (array &$arr , string $pattern )

void **slice\_before\_** (array &$arr , string $pattern )


When $pattern is matched in an element, all previous elements not include previous chunks are placed into a new chunk.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-slice_before

Parameters
----------
  **&$arr**

  **$pattern**

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3,4,5,6,7,8,9,0));
$arr->slice_before_("/[02468]/"); // will "splice before" an even number.
print_r($arr->to_a());
```

```
Array
(
    [0] => Array
        (
            [0] => 1
        )

    [1] => Array
        (
            [0] => 2
            [1] => 3
        )

    [2] => Array
        (
            [0] => 4
            [1] => 5
        )

    [3] => Array
        (
            [0] => 6
            [1] => 7
        )

    [4] => Array
        (
            [0] => 8
            [1] => 9
        )

    [5] => Array
        (
            [0] => 0
        )

)
```


<a name="method_concat_"></a>Methods: merge, merge\_, concat, concat\_
=======================================
void **merge** (array $arr , array $arr2 )

void **merge\_** (array &$arr , array $arr2 )

void **concat** (array $arr , array $arr2 )

void **concat\_** (array &$arr , array $arr2 )


Will merge two or more arrays together.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-2B

Parameters
----------
  **&$arr**

  **$arr2**

Return
------
 void

Example 1
---------
```php
$animals = new PrettyArray(array('dog', 'cat', 'pig'));
$trees = array('pine');
$animals->merge_($trees, array('wool'));
print_r($animals->to_a());
```

```
Array
(
    [0] => dog
    [1] => cat
    [2] => pig
    [3] => pine
    [4] => wool
)
```


<a name="method_rotate_"></a>Methods: rotate, rotate\_
========================
void **rotate** (array $arr , int $index )

void **rotate\_** (array &$arr , int $index )


Will rotate the array so that $index is the first element in the array. Negative indexs are allowed.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-rotate

Parameters
----------
  **&$arr**

  **$index**
    ```
    The starting index
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array('Foo', 'bar', 'foobar'));
$arr->rotate_(1);
print_r($arr->to_a());
```

```
Array
(
    [0] => bar
    [1] => foobar
    [2] => Foo
)
```

Example 2
---------
```php
$arr = new PrettyArray(array('Foo', 'bar', 'foobar'));
$o = $arr->rotate(-1);
print_r($o->to_a());

```

```
Array
(
    [0] => foobar
    [1] => Foo
    [2] => bar
)
```


<a name="method_reverse_"></a>Methods: reverse, reverse\_
==========================
void **reverse** (array $arr , boolean optional )

void **reverse\_** (array &$arr , boolean optional )


Will reverse an array.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-reverse

Parameters
----------
  **&$arr**

  **optional**
    ```
    $preserve_keys Defaults to false. If you want to preserve the keys or not.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3));
$arr->reverse_();
print_r($arr->to_a());
```

```
Array
(
    [0] => 3
    [1] => 2
    [2] => 1
)
```


<a name="method_sample_"></a>Methods: random, random\_, sample, sample\_
=========================================
mixed **random** (array $arr , int optional )

mixed **random\_** (array &$arr , int optional )

mixed **sample** (array $arr , int optional )

mixed **sample\_** (array &$arr , int optional )


Will get $count random values from $arr. If $count is 1 then it'll return the value, otherwise it'll return an array of values.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-sample

Parameters
----------
  **&$arr**

  **optional**
    ```
    $count Defaults to 1
    ```

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
echo $arr->random();
```

```
dog
```

Example 2
---------
```php
$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
$arr->random_(2);
print_r($arr->to_a());
```

```
Array
(
    [0] => dog
    [1] => cow
)
```


<a name="method_shuffle_"></a>Methods: shuffle, shuffle\_
==========================
void **shuffle** (array $arr [, boolean $preserve_keys = false ] )

void **shuffle\_** (array &$arr [, boolean $preserve_keys = false ] )


Will shuffle the inputted array.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-shuffle

Parameters
----------
  **&$arr**

  **$preserve_keys**
    ```
    If you want to preserve keys or not. Defaults to false.
    ```

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3));
$arr->shuffle_();
print_r($arr->to_a());
```

```
Array
(
    [0] => 2
    [1] => 1
    [2] => 3
)
```

Example 2
---------
```php
$arr = new PrettyArray(array('a' => 'apple', 'b' => 'banana', 'c' => 'carrot'));
$o = $arr->shuffle(true);
print_r($o->to_a());
```

```
Array
(
    [a] => apple
    [c] => carrot
    [b] => banana
)
```


<a name="method_values_at_"></a>Methods: values\_at, values\_at\_
==============================
void **values\_at** (type array , mixed $index )

void **values\_at\_** (type array , mixed $index )


Will replace the current array with only the inserted indexs. Use the non-destructive form to get the array returned instead.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-values_at

Parameters
----------
  **array**
    ```
    &$arr
    ```

  **$index**
    ```
    Put in as many indexes as you please.
    ```

Return
------
 void

Example 1
---------
```php
$name = new PrettyArray(array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.'
));
$o = $name->values_at('title', 'last');
print_r($o->to_a());
```

```
Array
(
    [title] => Dr.
    [last] => Doe
)
```


<a name="method_isEmpty"></a>Methods: empty, isEmpty
=======================
boolean **empty** (array $arr )

boolean **isEmpty** (array $arr )


If the array is empty or not.
NOTICE: that 'empty' alias is a language construct so this alias cannot be called directly. Refer to example #3.

Parameters
----------
  **$arr**

Return
------
 boolean

Example 1
---------
```php
$arr = new PrettyArray();
var_dump($arr->isEmpty());
```

```
bool(true)
```

Example 2
---------
```php
$arr = new PrettyArray(array(1,2,3));
var_dump($arr->isEmpty());
```

```
bool(false)
```

Example 3
---------
```php
$empty = 'empty';
$arr = new PrettyArray(array(1,2,3));
var_dump($arr->$empty());
```

```
bool(false)
```


<a name="method_has_value"></a>Methods: has\_value
==================
boolean **has\_value** (array $arr , mixed $value )


Will return a boolean based on the condition that $value exists inside of $arr and are the same data type.

Parameters
----------
  **$arr**

  **$value**

Return
------
 boolean

Example 1
---------
```php
$arr = new PrettyArray(array(0,false));
var_dump($arr->has_value(null));
```

```
bool(false)
```

Example 2
---------
```php
$arr = new PrettyArray(array(false,null));
var_dump($arr->has_value(0));
```

```
bool(false)
```

Example 3
---------
```php
$arr = new PrettyArray(array('apple', 'banana', 'orange'));
var_dump($arr->has_value('orange'));
```

```
bool(true)
```


<a name="method_find_index_"></a>Methods: index, index\_, find\_index, find\_index\_
===============================================
mixed **index** (array $arr [, mixed $callback = NULL ] )

mixed **index\_** (array &$arr [, mixed $callback = NULL ] )

mixed **find\_index** (array &$arr [, mixed $callback = NULL ] )

mixed **find\_index\_** (array &$arr [, mixed $callback = NULL ] )


Will return the first index if found or false otherwise. Use '===' for comparing.
If $callback is a callback function, the $key is returned the first time $callback returns true.
If $callback is not a callback, we are looking for the first $value in $arr to be === $callback.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-index

Parameters
----------
  **&$arr**

  **$callback**

Return
------
 mixed

Example 1
---------
```php
$name = new PrettyArray(array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
));
echo $name->index('John');
```

```
first
```

Example 2
---------
```php
$name = new PrettyArray(array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
));
echo $name->index_(function($key, &$value) {
	return (strpos($value, '.') !== false); // Has a decimal
});
```

```
title
```


<a name="method_rindex_"></a>Methods: rindex, rindex\_
========================
mixed **rindex** (array $arr , mixed $callback )

mixed **rindex\_** (array &$arr , mixed $callback )


Similar to index but looks for the last occurace of $callback.
If $callback is a callback function, the $key is returned the last time $callback returns true.
If $callback is not a callback, we are looking for the last $value in $arr to be === $callback.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-rindex

Parameters
----------
  **&$arr**

  **$callback**

Return
------
 mixed

Example 1
---------
```php
$name = new PrettyArray(array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
));
echo $name->rindex('John');
```

```
first
```

Example 2
---------
```php
$name = new PrettyArray(array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
));
echo $name->rindex_(function($key, &$value) {
	return (strpos($value, '.') !== false);
});
```

```
suffix
```


<a name="method_compact_"></a>Methods: compact, compact\_
==========================
void **compact** (array $arr )

void **compact\_** (array &$arr )


Will remove all null values inside of $arr. If $recursive is set to true, it will crawl sub-arrays.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-compact

Parameters
----------
  **&$arr**

Return
------
 void

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3,null,array(2,3,4,null)));
$arr->compact_();
print_r($arr->to_a());
```

```
Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [4] => Array
        (
            [0] => 2
            [1] => 3
            [2] => 4
            [3] => 
       )

)
```

Example 2
---------
```php
$arr = new PrettyArray(array(1,2,3,null,array(2,3,4,null)));
$o = $arr->compact(true);
print_r($o->to_a());
```

```
Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [4] => Array
        (
            [0] => 2
            [1] => 3
            [2] => 4
       )

)
```

