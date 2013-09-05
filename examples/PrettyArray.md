\prettyArray\PrettyArray
============================
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

Continue / Break
----------------
You can throw new continue/break statements as exceptions. You can throw them in the following methods and their respective aliases:
* collect
* each_slice
* collect_concat
* grep
* inject
* reverse_collect
* cycle
* each_cons

Throwing a continue:
<code>
	throw new ContinueException;
</code>

Throwing a break:
<code>
	throw new BreakException;
</code>

---------

Table Of Contents
=================
 * [\_\_construct](#method___construct)
 * [chain](#method_chain)
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
 * [get](#method_get)
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
 * [uniq](#method_array_unique_)
 * [uniq\_](#method_array_unique_)
 * [array\_unique](#method_array_unique_)
 * [array\_unique\_](#method_array_unique_)
 * [assoc](#method_assoc)
 * [rassoc](#method_rassoc)
 * [at](#method_at)
 * [combination\_](#method_combination_)
 * [combination](#method_combination_)
 * [delete\_](#method_delete_)
 * [delete](#method_delete_)
 * [delete\_at\_](#method_delete_at_)
 * [delete\_at](#method_delete_at_)
 * [fetch\_](#method_fetch)
 * [fetch](#method_fetch)
 * [flatten](#method_flatten_)
 * [flatten\_](#method_flatten_)
 * [array\_column\_](#method_array_pluck_)
 * [array\_column](#method_array_pluck_)
 * [array\_pluck\_](#method_array_pluck_)
 * [array\_pluck](#method_array_pluck_)

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


<a name="method_chain"></a>Methods: chain
==============
bool **chain** (string $method )


Determines if the given method supports chaining.

Parameters
----------
  **$method**
    ```
    The method you are testing.
    ```

Return
------
bool
    ```
    If the method does not exist false is returned.
    ```


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
use \prettyArray\Enumerator;
use \prettyArray\PrettyArray;
use \prettyArray\srcexceptions\BreakException;
use \prettyArray\srcexceptions\ContinueException;
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


<a name="method_get"></a>Methods: get
============
mixed **get** ()


A generic getter method.

Parameters
----------
Return
------
 mixed


<a name="method_all_"></a>Methods: all, all\_
==================
boolean **all** ([ callable $callback = NULL ] )

boolean **all\_** ([ callable $callback = NULL ] )


Passes each element of the collection to the $callback, if it ever turns false or null this function will return false, else true.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-all-3F

Parameters
----------
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
mixed **drop** (int $count )

mixed **drop\_** (int $count )


Drops the first $count elements.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop

Parameters
----------
  **$count**

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$animals = new PrettyArray(array('ant', 'bear', 'cat'));
$o = $animals->drop(1);
print_r($o->to_a());

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
boolean **any** ([ callable $callback = NULL ] )

boolean **any\_** ([ callable $callback = NULL ] )


Passes each element of the collection to the $callback, if it ever returns anything besides null or false I'll return true, else I'll return false.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-any-3F

Parameters
----------
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
$o = $animals->any($animals, function($key, &$value) {
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
mixed **collect** (callable $callback )

mixed **collect\_** (callable $callback )

mixed **each** (callable $callback )

mixed **each\_** (callable $callback )

mixed **map** (callable $callback )

mixed **map\_** (callable $callback )

mixed **foreach** (callable $callback )

mixed **foreach\_** (callable $callback )

mixed **each\_with\_index** (callable $callback )

mixed **each\_with\_index\_** (callable $callback )

mixed **array\_walk** (callable $callback )


Will iterate the elements in the array. Has the potential to change the values.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-collect

Parameters
----------
  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(range(1,4));
$o = $arr->collect(function($key, &$value) {
	$value *= $value;
	return;
});
print_r($o->to_a());
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
int **count** (callable $callback )

int **count\_** (callable $callback )

int **size** (callable $callback )

int **size\_** (callable $callback )

int **length** (callable $callback )

int **length\_** (callable $callback )


If the callback is null, this function give you the total size of the array.
If the callback is a anonymous function, each time it returns 'true' will count as 1.
Otherwise this function will count how many times $callback is equal to $value.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Enumerable.html#method-i-count

Parameters
----------
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
echo $arr->count(); // 4
echo count($arr); // 4
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
mixed **detect** (callable $callback [, mixed $ifnone = NULL ] )

mixed **detect\_** (callable $callback [, mixed $ifnone = NULL ] )

mixed **find** (callable $callback [, mixed $ifnone = NULL ] )

mixed **find\_** (callable $callback [, mixed $ifnone = NULL ] )


Will pass the key and value to $callback the first result that does not return false is returned.
If no results are found this function will return the result of $ifnone (mixed) if none is provided false will be returned.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-detect

Parameters
----------
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
array **select** (callable $callback )

array **select\_** (callable $callback )

array **find\_all** (callable $callback )

array **find\_all\_** (callable $callback )

array **keep\_if** (callable $callback )

array **keep\_if\_** (callable $callback )


Will pass the elements to the callback and unset them if the callback returns false.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-select

Parameters
----------
  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

Return
------
array
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(range(1,10));
$o = $arr->select(function($key, &$value) {
	return ($value % 3 == 0);
});
print_r($o->to_a());
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
mixed **each\_slice** (int $size [, mixed $callback = NULL ] )

mixed **each\_slice\_** (int $size [, mixed $callback = NULL ] )


Will slice the elements into $size collections and pass to $callback if defined. If not defined, the slized array is returned.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-each_slice

Parameters
----------
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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(range(1,10));
$o = $arr->each_slice(3, function(&$collection) {
	foreach($collection as $key => &$value) ++$value;
	return;
});
print_r($o->to_a());
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
mixed **first** ([ int $count = 1 ] )

mixed **first\_** ([ int $count = 1 ] )


Will overwrite $arr with the first $count items in array.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-first

Parameters
----------
  **$count**
    ```
    The number of items you wish to return. Defaults to 1
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

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
$o = $animals->first(2);
print_r($o->to_a());

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
mixed **collect\_concat** (callable $callback )

mixed **collect\_concat\_** (callable $callback )

mixed **flat\_map** (callable $callback )

mixed **flat\_map\_** (callable $callback )


Will flatten the input $arr into a non-multi-dimensional array.
It will pass the current key and the value to $callback which has the potential to change the value.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-flat_map

Parameters
----------
  **$callback**
    ```
    The callback will be passed each sliced item as an array. This can be passed by reference.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(array(1,2),array(3,4)));
$o = $arr->collect_concat(function($key, &$value) {
	return ++$value;
});
print_r($o->to_a());

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
mixed **grep** (string $pattern [, mixed $callback = NULL ] )

mixed **grep\_** (string $pattern [, mixed $callback = NULL ] )


Will only keep an item if the value of the item matches $pattern.
If a callback is provided, it will pass the $key and $value into the array.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-grep

Parameters
----------
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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
$o = $arr->grep("/^snow/");
print_r($o->to_a());

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
mixed **group\_by** (callable $callback [, boolean $preserve_keys = false ] )

mixed **group\_by\_** (callable $callback [, boolean $preserve_keys = false ] )


Each item will be passed into $callback and the return value will be the new "category" of this item.
The param $arr will be replaced with an array of these categories with all of their items.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-group_by

Parameters
----------
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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

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
boolean **member** (mixed $needle )

boolean **include** (mixed $needle )


This function will iterate over $arr, if any value is equal (===) to $needle this function will return true. If nothing is found this function will return false.
NOTICE: that 'include' alias is a language construct so this alias cannot be called directly. Refer to example #2.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-member-3F

Parameters
----------
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
$o = $arr->member($arr, 'snowman');
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
mixed **min** (mixed optional )


Will find the lowest value. If callback is defined it will compare them.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-min

Parameters
----------
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
mixed **max** (callback optional )


Will find the highest value. If callback is defined it will compare them.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-max

Parameters
----------
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
echo $arr->max($arr);

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
mixed **min\_by** (callable $callback )


Will find the lowest item in the array but comparing the output os $callback against every item.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-min_by

Parameters
----------
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
mixed **max\_by** (callable $callback )


Will find the highest item in the array but comparing the output os $callback against every item.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-max_by

Parameters
----------
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
array **minmax** (mixed optional )


Will return an array of min and max. Optionally you can provide a callback to sort them.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-minmax

Parameters
----------
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
array **minmax\_by** (callable $callback )


Will find the lowest and highest item in the array but comparing the output os $callback against every item.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-minmax_by

Parameters
----------
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
boolean **none** ([ mixed $callback = NULL ] )


Passes each element of the collection to $callback. This will return true if $callback never returns true, else false.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-none-3F

Parameters
----------
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
$arr = new PrettyArray(array());
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
boolean **one** ([ mixed $callback = NULL ] )


Pases each element of the collection to $callback. If $callback returns true once, the function will return true. Otherwise, the function will return false.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-one-3F

Parameters
----------
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
mixed **partition** (callable $callback [, boolean $preserve_keys = false ] )

mixed **partition\_** (callable $callback [, boolean $preserve_keys = false ] )


Passes each element into $callback. If $callback returns true the item will be in the first category, otherwise the second.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-partition

Parameters
----------
  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

  **$preserve_keys**

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

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
mixed **inject** (callable $callback , mixed optional )

mixed **inject\_** (callable $callback , mixed optional )

mixed **reduce** (callable $callback , mixed optional )

mixed **reduce\_** (callable $callback , mixed optional )


Will iterate the items in $arr passing each one to $callback with $memo as the third argument.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-inject

Parameters
----------
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
mixed **reject: reject\_** (callable $callback )

mixed **delete\_if** (callable $callback )

mixed **delete\_if\_** (callable $callback )


Will unset an item in $arr if $callback returns true for it.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-reject

Parameters
----------
  **$callback**
    ```
    A $key, $value are passed to this callback. The $value can be passed by reference.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(range(1,10));
$o = $arr->reject(function($key, $value) {
	return ($value % 3 == 0);
});
print_r($o->to_a());

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
mixed **reverse\_collect** (callable $callback )

mixed **reverse\_collect\_** (callable $callback )

mixed **reverse\_each** (callable $callback )

mixed **reverse\_each\_** (callable $callback )

mixed **reverse\_map** (callable $callback )

mixed **reverse\_map\_** (callable $callback )

mixed **reverse\_foreach** (callable $callback )

mixed **reverse\_foreach\_** (callable $callback )

mixed **reverse\_each\_with\_index** (callable $callback )


Will iterate the array in reverse, but will NOT save the order.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-reverse_each

Parameters
----------
  **$callback**
    ```
    A $key, $value are passed to this callback. The $value can be passed by reference.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

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
mixed **sort** ([ mixed $callback = NULL ] )

mixed **sort\_** ([ mixed $callback = NULL ] )


Will sort the contents of $arr. A callback can be used to sort.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-sort

Parameters
----------
  **$callback**
    ```
    A $key, $value are passed to this callback. The $value can be passed by reference.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
$o = $arr->sort($arr);
print_r($o->to_a());

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
$o = $arr->sort(function($val1, $val2) {
	return strcmp($val2, $val1);
});
print_r($o->to_a());

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
mixed **sort\_by** (callable $callback )

mixed **sort\_by\_** (callable $callback )


Will sort based off of the return of $callback.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-sort_by

Parameters
----------
  **$callback**

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
$o = $arr->sort_by(function($val) {
	return strlen($val);
});
print_r($o->to_a());

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
mixed **take\_while** (callable $callback )

mixed **take\_while\_** (callable $callback )


Passes elements into $callback until it returns false or null, at which point this function will stop and set $arr to all prior elements.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-take_while

Parameters
----------
  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3,4,5,0));
$o = $arr->take_while(function($key, &$value) {
	return ($value < 3);
});
print_r($o->to_a());

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
mixed **zip** (array $one )

mixed **zip\_** (array $one )


Will turn each element in $arr into an array then appending the associated indexs from the other arrays into this array as well.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-zip

Parameters
----------
  **$one**
    ```
    Unlimited of this.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3));
$o = $arr->zip(array(4,5,6), array(7,8,9));
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
mixed **drop\_while** (callable $callback )

mixed **drop\_while\_** (callable $callback )


Will pass elements into $callback until false is returned at which point all elements before the current one will be removed.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop_while

Parameters
----------
  **$callback**

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3,4,5,0));
$o = $arr->drop_while(function($key, &$value) {
	return ($value < 3);
});
print_r($o->to_a());

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
mixed **cycle** (int $it , callable $callback )

mixed **cycle\_** (int $it , callable $callback )


Will pass every element of $arr into $callback exactly $it times.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-cycle

Parameters
----------
  **$it**

  **$callback**
    ```
    This can accept 3 arguments: $key - The key in the array, $value - The value of this key, $it - The current iteration.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

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
mixed **each\_cons** (int $size [, mixed $callback = NULL ] )

mixed **each\_cons\_** (int $size [, mixed $callback = NULL ] )


This will return each section as an item in an array.
A section is each consecutive $size of $arr.
It will also iterate over each item in every section.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-each_cons

Parameters
----------
  **$size**

  **$callback**

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(range(1,10));
$o = $arr->each_cons(8);
print_r($o->to_a());

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
mixed **slice\_before** (string $pattern )

mixed **slice\_before\_** (string $pattern )


When $pattern is matched in an element, all previous elements not include previous chunks are placed into a new chunk.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-slice_before

Parameters
----------
  **$pattern**

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3,4,5,6,7,8,9,0));
$o = $arr->slice_before("/[02468]/"); // will "splice before" an even number.
print_r($o->to_a());

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
mixed **merge** (array $arr2 )

mixed **merge\_** (array $arr2 )

mixed **concat** (array $arr2 )

mixed **concat\_** (array $arr2 )


Will merge two or more arrays together.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-2B

Parameters
----------
  **$arr2**

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$animals = new PrettyArray(array('dog', 'cat', 'pig'));
$trees = array('pine');
$o = $animals->merge($trees, array('wool'));
print_r($o->to_a());
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
mixed **rotate** (int $index )

mixed **rotate\_** (int $index )


Will rotate the array so that $index is the first element in the array. Negative indexs are allowed.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-rotate

Parameters
----------
  **$index**
    ```
    The starting index
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array('Foo', 'bar', 'foobar'));
$o = $arr->rotate(1);
print_r($o->to_a());

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
mixed **reverse** (boolean optional )

mixed **reverse\_** (boolean optional )


Will reverse an array.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-reverse

Parameters
----------
  **optional**
    ```
    $preserve_keys Defaults to false. If you want to preserve the keys or not.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3));
$o = $arr->reverse();
print_r($o->to_a());

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
mixed **random** (int optional )

mixed **random\_** (int optional )

mixed **sample** (int optional )

mixed **sample\_** (int optional )


Will get $count random values from $arr. If $count is 1 then it'll return the value, otherwise it'll return an array of values.

Links
-----
 * http://ruby-doc.org/core-1.9.3/Array.html#method-i-sample

Parameters
----------
  **optional**
    ```
    $count Defaults to 1
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
$o = $arr->random();
echo $o;

```

```
dog
```

Example 2
---------
```php
$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
$o = $arr->random(2);
print_r($o->to_a());

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
mixed **shuffle** ([ boolean $preserve_keys = false ] )

mixed **shuffle\_** ([ boolean $preserve_keys = false ] )


Will shuffle the inputted array.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-shuffle

Parameters
----------
  **$preserve_keys**
    ```
    If you want to preserve keys or not. Defaults to false.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3));
$o = $arr->shuffle();
print_r($o->to_a());

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
mixed **values\_at** (mixed $index )

mixed **values\_at\_** (mixed $index )


Will replace the current array with only the inserted indexs. Use the non-destructive form to get the array returned instead.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-values_at

Parameters
----------
  **$index**
    ```
    Put in as many indexes as you please.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

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
boolean **empty** ()

boolean **isEmpty** ()


If the array is empty or not.
NOTICE: that 'empty' alias is a language construct so this alias cannot be called directly. Refer to example #3.

Parameters
----------
Return
------
 boolean

Example 1
---------
```php
$arr = new PrettyArray(array());
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
boolean **has\_value** (mixed $value )


Will return a boolean based on the condition that $value exists inside of $arr and are the same data type.

Parameters
----------
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
mixed **index** ([ mixed $callback = NULL ] )

mixed **index\_** ([ mixed $callback = NULL ] )

mixed **find\_index** ([ mixed $callback = NULL ] )

mixed **find\_index\_** ([ mixed $callback = NULL ] )


Will return the first index if found or false otherwise. Use '===' for comparing.
If $callback is a callback function, the $key is returned the first time $callback returns true.
If $callback is not a callback, we are looking for the first $value in $arr to be === $callback.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-index

Parameters
----------
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
	'title' => 'Dr.'
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
	'title' => 'Dr.'
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
mixed **rindex** (callable $callback )

mixed **rindex\_** (callable $callback )


Similar to index but looks for the last occurace of $callback.
If $callback is a callback function, the $key is returned the last time $callback returns true.
If $callback is not a callback, we are looking for the last $value in $arr to be === $callback.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-rindex

Parameters
----------
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
	'title' => 'Dr.'
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
mixed **compact** ([ boolean $recursive = false ] )

mixed **compact\_** ([ boolean $recursive = false ] )


Will remove all null values inside of $arr. If $recursive is set to true, it will crawl sub-arrays.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-compact

Parameters
----------
  **$recursive**
    ```
    If you want this to iterate all child arrays.
    ```

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(1,2,3,null,array(2,3,4,null)));
$o = $arr->compact();
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


<a name="method_array_unique_"></a>Methods: uniq, uniq\_, array\_unique, array\_unique\_
=================================================
mixed **uniq** ()

mixed **uniq\_** ()

mixed **array\_unique** ()

mixed **array\_unique\_** ()


Will force all itemsm in $arr to be unique.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-uniq

Parameters
----------
Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(1,1,2,3,3,2,1,1,1));
$a = $arr->uniq();
print_r($a->to_a());

```

```
Array
(
    [0] => 1
    [2] => 2
    [3] => 3
)
```


<a name="method_assoc"></a>Methods: assoc
==============
mixed **assoc** (mixed $search )


Searches through top level items, if the item is an array and the first value matches $search it'll return this element.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-assoc

Parameters
----------
  **$search**

Return
------
mixed
    ```
    The found array, or null.
    ```

Example 1
---------
```php
$s1 = array('color', 'red', 'blue', 'green');
$s2 = array('letters', 'a', 'b', 'c');
$s3 = 'foo';
$arr = new PrettyArray(array($s1, $s2, $s3));
$o = $arr->assoc('letters');
print_r($o->to_a());

```

```
Array
(
    [0] => letters
    [1] => a
    [2] => b
    [3] => c
)
```


<a name="method_rassoc"></a>Methods: rassoc
===============
mixed **rassoc** (mixed $search )


Searches through top level items, if the item is an array and the second value matches $search it'll return this element.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-rassoc

Parameters
----------
  **$search**

Return
------
mixed
    ```
    The found array, or null.
    ```

Example 1
---------
```php
$arr = new PrettyArray(array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two")));
$o = $arr->rassoc('two');
print_r($o->to_a());

```

```
Array
(
    [0] => 2
    [1] => two
)
```

Example 2
---------
```php
$arr = new PrettyArray(array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two")));
$o = $arr->rassoc('four');
var_dump($o);

```

```
NULL
```


<a name="method_at"></a>Methods: at
===========
mixed **at** (mixed $key )


Will create an array from all the keys provided. If only one element exists that element is returned, otherwise the array is returned. If none exist, null is returned.

Parameters
----------
  **$key**
    ```
    You can insert multiple keys. If they key is negative and doe snot belong in the array, it'll return that index from the end.
    ```

Return
------
mixed
    ```
    An item or an array
    ```

Example 1
---------
```php
$arr = new PrettyArray(array('a', 'b', 'c', 'd', 'e'));
echo $arr->at(0);

```

```
a
```

Example 2
---------
```php
$arr = new PrettyArray(array('a', 'b', 'c', 'd', 'e'));
echo $arr->at(-1);

```

```
e
```

Example 3
---------
```php
$arr = new PrettyArray(array('a', 'b', 'c', 'd', 'e'));
$o = $arr->at(0, 3, 4);
print_r($o->to_a());
```

```
Array
(
    [0] => a
    [1] => d
    [2] => e
)
```


<a name="method_combination_"></a>Methods: combination\_, combination
==================================
mixed **combination\_** (int $limit [, mixed $callback = NULL ] )

mixed **combination** (int $limit [, mixed $callback = NULL ] )


Will yield the various unique combinations of an array with a specific $limit.

Parameters
----------
  **$limit**
    ```
    The number of items you wish to have per child element
    ```

  **$callback**

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array(1, 2, 3, 4));
$arr->combination_(1);
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
        )

    [2] => Array
        (
            [0] => 3
        )

    [3] => Array
        (
            [0] => 4
        )

)
```

Example 2
---------
```php
$arr = new PrettyArray(array(1, 2, 3, 4));
$arr->combination_(4);
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
        )

)
```

Example 3
---------
```php
$arr = new PrettyArray(array(1, 2, 3, 4));
$arr->combination_(0);
print_r($arr->to_a());

```

```
Array
(
    [0] => Array
        (
        )

)
```


<a name="method_delete_"></a>Methods: delete\_, delete
========================
mixed **delete\_** (mixed $needle [, callable $callback = NULL ] )

mixed **delete** (mixed $needle [, callable $callback = NULL ] )


Will delete every instance of $needle inside of $arr.
If $needle is not found null is returned.
If it is found and $callback is callable it's return value is returned.
If it is found and $callback is not defined $needle is returned.

Parameters
----------
  **$needle**

  **$callback**

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array('a','b', 'b', 'b', 'c'));
echo $arr->delete_('b') . PHP_EOL;
print_r($arr->to_a());

```

```
b
Array
(
	[0] => a
	[4] => c
)
```

Example 2
---------
```php
$arr = new PrettyArray(array('a','b', 'b', 'b', 'c'));
var_dump($arr->delete_('z'));

```

```
NULL
```

Example 3
---------
```php
$arr = new PrettyArray(array('a','b', 'b', 'b', 'c'));
var_dump($arr->delete('z', function() {
	return false;
}));

```

```
bool(false)
```


<a name="method_delete_at_"></a>Methods: delete\_at\_, delete\_at
==============================
mixed **delete\_at\_** (mixed $index )

mixed **delete\_at** (mixed $index )


Will delete the element at the specific index. If the element is found that element is returned, otherwise null is returned.

Parameters
----------
  **$index**

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array('ant', 'bat', 'cat', 'dog'));
$ret = $arr->delete_at_(2);
echo $ret . PHP_EOL;
print_r($arr->to_a());

```

```
cat
Array
(
    [0] => ant
    [1] => bat
    [3] => dog
)
```

Example 2
---------
```php
$arr = new PrettyArray(array('ant', 'bat', 'cat', 'dog'));
$ret = $arr->delete_at(99);
var_dump($ret);

```

```
NULL
```


<a name="method_fetch"></a>Methods: fetch\_, fetch
======================
mixed **fetch\_** (mixed $index , mixed $value )

mixed **fetch** (mixed $index , mixed $value )


Will retrieve the value of the specific index. Will also retrieve negative index counting backwards.
If $index is not found and $value is callable, the index is passed to it and it's return value is returned.
If $index is not found and $value is not callable, $value is returned.

Parameters
----------
  **$index**

  **$value**

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array(11, 22, 33, 44));
echo $arr->fetch(1);

```

```
22
```

Example 2
---------
```php
$arr = new PrettyArray(array(11, 22, 33, 44));
echo $arr->fetch(-1);

```

```
44
```

Example 3
---------
```php
$arr = new PrettyArray(array(11, 22, 33, 44));
echo $arr->fetch(4, 'cat');

```

```
cat
```

Example 4
---------
```php
$arr = new PrettyArray(array(11, 22, 33, 44));
echo $arr->fetch(4, function($i) {
	return $i * $i;
});

```

```
16
```


<a name="method_flatten_"></a>Methods: flatten, flatten\_
==========================
mixed **flatten** ([ int $depth = 999999 ] )

mixed **flatten\_** ([ int $depth = 999999 ] )


Will flatten the array to a single array or until the $depth is reached.

Parameters
----------
  **$depth**

Return
------
 mixed

Example 1
---------
```php
$arr = new PrettyArray(array(1, 2, array(3, array(4, 5))));
$arr = $arr->flatten();
echo print_r($arr->to_a(), true) . PHP_EOL;
$arr = $arr->flatten();
var_dump($arr);
```

```
Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [3] => 4
    [4] => 5
)
NULL
```

Example 2
---------
```php
$arr = new PrettyArray(array(1, 2, array(3, array(4, 5))));
$arr->flatten_(1);
print_r($arr->to_a());

```

```
Array
(
    [0] => 1
    [1] => 2
    [2] => 3
    [3] => Array
        (
            [0] => 4
            [1] => 5
        )
)
```


<a name="method_array_pluck_"></a>Methods: array\_column\_, array\_column, array\_pluck\_, array\_pluck
===============================================================
mixed **array\_column\_** (mixed $index )

mixed **array\_column** (mixed $index )

mixed **array\_pluck\_** (mixed $index )

mixed **array\_pluck** (mixed $index )


Will return an array of values from a multidimensional array based on the index provided.

Parameters
----------
  **$index**

Return
------
 mixed

