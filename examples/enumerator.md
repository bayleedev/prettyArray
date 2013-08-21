\prettyArray\Enumerator
===========================
Enumerator

A handy static class for handling array methods similar to the methods available to ruby.

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

link
----
* http://ruby-doc.org/core-1.9.3/Enumerable.html

---------

Table Of Contents
=================
 * [get](#method_get)
 * [\_\_callStatic](#method___callStatic)
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

<a name="method_get"></a>Methods: get
============
mixed **get** (string $name )


A generic getter method.

Parameters
----------
  **$name**

Return
------
 mixed


<a name="method___callStatic"></a>Methods: \_\_callStatic
=====================
mixed **\_\_callStatic** (string $method , array $params )


This magic method helps with method aliases and calling destrucitve methods in a non-destructive way.
For example the real method "partition_" will take over your $array, but calling the magic method "partition" will not.
All methods implemented in this class that have an underscore at the end are destructive and have a non-destructive alias.

Parameters
----------
  **$method**
    ```
    The method name
    ```

  **$params**
    ```
    An array of parrams you wish to pass
    ```

Return
------
 mixed


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
$animals = array('ant', 'bear', 'cat');
$o = Enumerator::all($animals, function($key, &$value) {
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
$animals = array('ant', 'bear', 'cat');
$o = Enumerator::all($animals, function($key, &$value) {
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
$arr = array(null, true, 99);
$o = Enumerator::all($arr);
var_dump($o);
```

```
bool(false)
```


<a name="method_drop_"></a>Methods: drop, drop\_
====================
mixed **drop** (array $arr , int $count )

mixed **drop\_** (array &$arr , int $count )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$animals = array('ant', 'bear', 'cat');
$o = Enumerator::drop($animals, 1);
print_r($o);
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
$animals = array('ant', 'bear', 'cat');
$o = Enumerator::any($animals, function($key, &$value) {
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
$animals = array('ant', 'bear', 'cat');
$o = Enumerator::any($animals, function($key, &$value) {
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
$arr = array(null, true, 99);
$o = Enumerator::any($arr);
var_dump($o);
```

```
bool(true)
```


<a name="method_array_walk_"></a>Methods: collect, collect\_, each, each\_, map, map\_, foreach, foreach\_, each\_with\_index, each\_with\_index\_, array\_walk
====================================================================================================================
mixed **collect** (array $arr , callable $callback )

mixed **collect\_** (array &$arr , callable $callback )

mixed **each** (array $arr , callable $callback )

mixed **each\_** (array &$arr , callable $callback )

mixed **map** (array $arr , callable $callback )

mixed **map\_** (array &$arr , callable $callback )

mixed **foreach** (array $arr , callable $callback )

mixed **foreach\_** (array &$arr , callable $callback )

mixed **each\_with\_index** (array &$arr , callable $callback )

mixed **each\_with\_index\_** (array &$arr , callable $callback )

mixed **array\_walk** (array &$arr , callable $callback )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = range(1,4);
$o = Enumerator::collect($arr, function($key, &$value) {
	$value *= $value;
	return;
});
print_r($o);
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
$arr = range(1,4);
$o = Enumerator::collect($arr, function($key, &$value) {
	$value = "cat";
	return;
});
print_r($o);
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
If the callback is a anonymous function, each time it returns 'true' will count as 1.
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
$arr = array(1,2,4,2);
echo Enumerator::count($arr);
```

```
4
```

Example 2
---------
```php
$arr = array(1,2,4,2);
echo Enumerator::count($arr, 2);
```

```
2
```

Example 3
---------
```php
$arr = array(1,2,4,2);
echo Enumerator::count($arr, function($key, &$value) {
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
$arr = range(1,10);
$o = Enumerator::detect($arr, function($key, &$value) {
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
$arr = range(1,100);
echo Enumerator::detect($arr, function($key, &$value) {
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
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = range(1,10);
$o = Enumerator::select($arr, function($key, &$value) {
	return ($value % 3 == 0);
});
print_r($o);
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
mixed **each\_slice** (array &$arr , int $size [, mixed $callback = NULL ] )

mixed **each\_slice\_** (array &$arr , int $size [, mixed $callback = NULL ] )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = range(1,10);
$o = Enumerator::each_slice($arr, 3, function(&$collection) {
	foreach($collection as $key => &$value) ++$value;
	return;
});
print_r($o);
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
mixed **first** (array $arr [, int $count = 1 ] )

mixed **first\_** (array &$arr [, int $count = 1 ] )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$animals = array('cat', 'dog', 'cow', 'pig');
$o = Enumerator::first($animals);
print_r($o);
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
$animals = array('cat', 'dog', 'cow', 'pig');
$o = Enumerator::first($animals, 2);
print_r($o);
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
mixed **collect\_concat** (array &$arr , callable $callback )

mixed **collect\_concat\_** (array &$arr , callable $callback )

mixed **flat\_map** (array &$arr , callable $callback )

mixed **flat\_map\_** (array &$arr , callable $callback )


Will flatten the input $arr into a non-multi-dimensional array.
It will pass the current key and the value to $callback which has the potential to change the value.

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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(array(1,2),array(3,4));
$o = Enumerator::collect_concat($arr, function($key, &$value) {
	return ++$value;
});
print_r($o);
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
mixed **grep** (array $arr , string $pattern [, mixed $callback = NULL ] )

mixed **grep\_** (array &$arr , string $pattern [, mixed $callback = NULL ] )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
$o = Enumerator::grep($arr, "/^snow/");
print_r($o);
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
mixed **group\_by** (array &$arr , callable $callback [, boolean $preserve_keys = false ] )

mixed **group\_by\_** (array &$arr , callable $callback [, boolean $preserve_keys = false ] )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = range(1,6);
$o = Enumerator::group_by($arr, function($key, &$value) {
	return ($value % 3);
});
print_r($o);
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
$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
$o = Enumerator::member($arr, 'snowcone');
var_dump($o);
```

```
bool(true)
```

Example 2
---------
```php
$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
$o = Enumerator::member($arr, 'snowman');
var_dump($o);
```

```
bool(false)
```

Example 3
---------
```php
$fun = 'include';
$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
$o = Enumerator::$fun($arr, 'snowcone');
var_dump($o);
```

```
bool(true)
```


<a name="method_min"></a>Methods: min
============
mixed **min** (array $arr , mixed optional )


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
$arr = array('albatross','dog','horse');
echo Enumerator::min($arr);
```

```
albatross
```

Example 2
---------
```php
$arr = array('albatross','dog','horse');
echo Enumerator::min($arr, function($val1, $val2) {
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
$arr = array('albatross','dog','horse');
echo Enumerator::max($arr);
```

```
horse
```

Example 2
---------
```php
$arr = array('albatross','dog','horse');
echo Enumerator::max($arr, function($val1, $val2) {
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
$arr = array('albatross','dog','horse');
echo Enumerator::min_by($arr, function($val) {
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
$arr = array('albatross','dog','horse');
echo Enumerator::max_by($arr, function($val) {
	return strlen($val);
});
```

```
albatross
```


<a name="method_minmax"></a>Methods: minmax
===============
array **minmax** (array $arr , mixed optional )


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
$arr = array('albatross','dog','horse');
$o = Enumerator::minmax($arr, function($val1, $val2) {
	return strcmp(strlen($val1), strlen($val2));
});
print_r($o);
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
$arr = array('albatross','dog','horse');
$o = Enumerator::minmax_by($arr, function($val) {
	return strlen($val);
});
print_r($o);
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
boolean **none** (array $arr [, mixed $callback = NULL ] )


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
$arr = array('ant', 'bear', 'cat');
$o = Enumerator::none($arr, function($key, $value) {
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
$arr = array('ant', 'bear', 'cat');
$o = Enumerator::none($arr, function($key, $value) {
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
$o = Enumerator::none(array());
var_dump($o);
```

```
bool(true)
```

Example 4
---------
```php
$o = Enumerator::none(array(null));
var_dump($o);
```

```
bool(true)
```

Example 5
---------
```php
$arr = array(null, false);
$o = Enumerator::none($arr);
var_dump($o);
```

```
bool(true)
```


<a name="method_one"></a>Methods: one
============
boolean **one** (array $arr [, mixed $callback = NULL ] )


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
$arr = array('ant','bear','cat');
$o = Enumerator::one($arr, function($key, $value) {
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
$o = Enumerator::one(array(null, true, 99));
var_dump($o);
```

```
bool(false)
```

Example 3
---------
```php
$o = Enumerator::one(array(null, true, false));
var_dump($o);
```

```
bool(true)
```


<a name="method_partition_"></a>Methods: partition, partition\_
==============================
mixed **partition** (array $arr , callable $callback [, boolean $preserve_keys = false ] )

mixed **partition\_** (array &$arr , callable $callback [, boolean $preserve_keys = false ] )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = range(1,6);
$o = Enumerator::partition($arr, function($key, $value) {
	return ($value % 2 == 0);
});
print_r($o);
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
$arr = range(5, 10);
echo Enumerator::inject($arr, function($key, &$value, &$memo){
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
$arr = range(5, 10);
echo Enumerator::inject($arr, function($key, &$value, &$memo){
	$memo *= $value;
	return;
}, 1);
```

```
151200
```


<a name="method_delete_if_"></a>Methods: reject: reject\_, delete\_if, delete\_if\_
===============================================
mixed **reject: reject\_** (array &$arr , callable $callback )

mixed **delete\_if** (array &$arr , callable $callback )

mixed **delete\_if\_** (array &$arr , callable $callback )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = range(1,10);
$o = Enumerator::reject($arr, function($key, $value) {
	return ($value % 3 == 0);
});
print_r($o);
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
mixed **reverse\_collect** (array &$arr , callable $callback )

mixed **reverse\_collect\_** (array &$arr , callable $callback )

mixed **reverse\_each** (array &$arr , callable $callback )

mixed **reverse\_each\_** (array &$arr , callable $callback )

mixed **reverse\_map** (array &$arr , callable $callback )

mixed **reverse\_map\_** (array &$arr , callable $callback )

mixed **reverse\_foreach** (array &$arr , callable $callback )

mixed **reverse\_foreach\_** (array &$arr , callable $callback )

mixed **reverse\_each\_with\_index** (array &$arr , callable $callback )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(1, 2, 3);
Enumerator::reverse_collect($arr, function($key, &$value) {
	echo $value . ', ';
	return;
});
```

```
3, 2, 1,
```


<a name="method_sort_"></a>Methods: sort, sort\_
====================
mixed **sort** (array $arr [, mixed $callback = NULL ] )

mixed **sort\_** (array &$arr [, mixed $callback = NULL ] )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array('rhea', 'kea', 'flea');
$o = Enumerator::sort($arr);
print_r($o);
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
$arr = array('rhea', 'kea', 'flea');
$o = Enumerator::sort($arr, function($val1, $val2) {
	return strcmp($val2, $val1);
});
print_r($o);
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
mixed **sort\_by** (array &$arr , callable $callback )

mixed **sort\_by\_** (array &$arr , callable $callback )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array('rhea', 'kea', 'flea');
$o = Enumerator::sort_by($arr, function($val) {
	return strlen($val);
});
print_r($o);
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
mixed **take\_while** (array &$arr , callable $callback )

mixed **take\_while\_** (array &$arr , callable $callback )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(1,2,3,4,5,0);
$o = Enumerator::take_while($arr, function($key, &$value) {
	return ($value < 3);
});
print_r($o);
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
mixed **zip** (array $arr , array $one )

mixed **zip\_** (array &$arr , array $one )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(1,2,3);
$o = Enumerator::zip($arr, array(4,5,6), array(7,8,9));
print_r($o);
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
$arr = array(1,2);
$o = Enumerator::zip($arr, array(4,5,6),array(7,8,9));
print_r($o);
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
$arr = array(4,5,6);
$o = Enumerator::zip($arr, array(1,2), array(8));
print_r($o);
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
mixed **drop\_while** (array &$arr , callable $callback )

mixed **drop\_while\_** (array &$arr , callable $callback )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(1,2,3,4,5,0);
$o = Enumerator::drop_while($arr, function($key, &$value) {
	return ($value < 3);
});
print_r($o);
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
mixed **cycle** (array $arr , int $it , callable $callback )

mixed **cycle\_** (array $arr , int $it , callable $callback )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(1,2,3);
Enumerator::cycle($arr, 3, function($key, $value, $it) {
	echo $value . ',';
});
```

```
1,2,3,1,2,3,1,2,3,
```


<a name="method_each_cons_"></a>Methods: each\_cons, each\_cons\_
==============================
mixed **each\_cons** (array &$arr , int $size [, mixed $callback = NULL ] )

mixed **each\_cons\_** (array &$arr , int $size [, mixed $callback = NULL ] )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = range(1,10);
$o = Enumerator::each_cons($arr, 8);
print_r($o);
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
mixed **slice\_before** (array &$arr , string $pattern )

mixed **slice\_before\_** (array &$arr , string $pattern )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(1,2,3,4,5,6,7,8,9,0);
$o = Enumerator::slice_before($arr, "/[02468]/"); // will "splice before" an even number.
print_r($o);
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
mixed **merge** (array $arr , array $arr2 )

mixed **merge\_** (array &$arr , array $arr2 )

mixed **concat** (array $arr , array $arr2 )

mixed **concat\_** (array &$arr , array $arr2 )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$animals = array('dog', 'cat', 'pig');
$trees = array('pine');
$o = Enumerator::merge($animals, $trees, array('wool'));
print_r($o);
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
mixed **rotate** (array $arr , int $index )

mixed **rotate\_** (array &$arr , int $index )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array('Foo', 'bar', 'foobar');
$o = Enumerator::rotate($arr, 1);
print_r($o);
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
$arr = array('Foo', 'bar', 'foobar');
$o = Enumerator::rotate($arr, -1);
print_r($o);
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
mixed **reverse** (array $arr , boolean optional )

mixed **reverse\_** (array &$arr , boolean optional )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(1,2,3);
$o = Enumerator::reverse($arr);
print_r($o);
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
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array('pig', 'cow', 'dog', 'horse');
$o = Enumerator::random($arr);
echo $o;
```

```
dog
```

Example 2
---------
```php
$arr = array('pig', 'cow', 'dog', 'horse');
$o = Enumerator::random($arr, 2);
print_r($o);
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
mixed **shuffle** (array $arr [, boolean $preserve_keys = false ] )

mixed **shuffle\_** (array &$arr [, boolean $preserve_keys = false ] )


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
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(1,2,3);
$o = Enumerator::shuffle($arr);
print_r($o);
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
$arr = array('a' => 'apple', 'b' => 'banana', 'c' => 'carrot');
$o = Enumerator::shuffle($arr, true);
print_r($o);
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
mixed **values\_at** (array &$arr , mixed $index )

mixed **values\_at\_** (array &$arr , mixed $index )


Will replace the current array with only the inserted indexs. Use the non-destructive form to get the array returned instead.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-values_at

Parameters
----------
  **&$arr**

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
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.'
);
$o = Enumerator::values_at($name, 'title', 'last');
print_r($o);
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
$arr = array();
var_dump(Enumerator::isEmpty($arr));
```

```
bool(true)
```

Example 2
---------
```php
$arr = array(1,2,3);
var_dump(Enumerator::isEmpty($arr));
```

```
bool(false)
```

Example 3
---------
```php
$empty = 'empty';
$arr = array(1,2,3);
var_dump(Enumerator::$empty($arr));
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
$arr = array(0,false);
var_dump(Enumerator::has_value($arr, null));
```

```
bool(false)
```

Example 2
---------
```php
$arr = array(false,null);
var_dump(Enumerator::has_value($arr, 0));
```

```
bool(false)
```

Example 3
---------
```php
$arr = array('apple', 'banana', 'orange');
var_dump(Enumerator::has_value($arr, 'orange'));
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
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
);
echo Enumerator::index($name, 'John');
```

```
first
```

Example 2
---------
```php
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
);
echo Enumerator::index_($name, function($key, &$value) {
	return (strpos($value, '.') !== false); // Has a decimal
});
```

```
title
```


<a name="method_rindex_"></a>Methods: rindex, rindex\_
========================
mixed **rindex** (array $arr , callable $callback )

mixed **rindex\_** (array &$arr , callable $callback )


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
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
);
echo Enumerator::rindex($name, 'John');
```

```
first
```

Example 2
---------
```php
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
);
echo Enumerator::rindex_($name, function($key, &$value) {
	return (strpos($value, '.') !== false);
});
```

```
suffix
```


<a name="method_compact_"></a>Methods: compact, compact\_
==========================
mixed **compact** (array $arr [, boolean $recursive = false ] )

mixed **compact\_** (array &$arr [, boolean $recursive = false ] )


Will remove all null values inside of $arr. If $recursive is set to true, it will crawl sub-arrays.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-compact

Parameters
----------
  **&$arr**

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
$arr = array(1,2,3,null,array(2,3,4,null));
$o = Enumerator::compact($arr);
print_r($o);
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
$arr = array(1,2,3,null,array(2,3,4,null));
$o = Enumerator::compact($arr, true);
print_r($o);
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
mixed **uniq** (array $arr )

mixed **uniq\_** (array &$arr )

mixed **array\_unique** (array &$arr )

mixed **array\_unique\_** (array &$arr )


Will force all itemsm in $arr to be unique.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-uniq

Parameters
----------
  **&$arr**

Return
------
mixed
    ```
    Nothing if called destructively, otherwise a new array.
    ```

Example 1
---------
```php
$arr = array(1,1,2,3,3,2,1,1,1);
$a = Enumerator::uniq($arr);
print_r($a);
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
mixed **assoc** (array $arr , mixed $search )


Searches through top level items, if the item is an array and the first value matches $search it'll return this element.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-assoc

Parameters
----------
  **$arr**

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
$arr = array($s1, $s2, $s3);
$o = Enumerator::assoc($arr, 'letters');
print_r($o);
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
mixed **rassoc** (array $arr , mixed $search )


Searches through top level items, if the item is an array and the second value matches $search it'll return this element.

Links
-----
 * http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-rassoc

Parameters
----------
  **$arr**

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
$arr = array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two"));
$o = Enumerator::rassoc($arr, 'two');
print_r($o);
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
$arr = array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two"));
$o = Enumerator::rassoc($arr, 'four');
var_dump($o);
```

```
NULL
```


<a name="method_at"></a>Methods: at
===========
mixed **at** (array $arr , mixed $key )


Will create an array from all the keys provided. If only one element exists that element is returned, otherwise the array is returned. If none exist, null is returned.

Parameters
----------
  **$arr**

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
$arr = array('a', 'b', 'c', 'd', 'e');
echo Enumerator::at($arr, 0);
```

```
a
```

Example 2
---------
```php
$arr = array('a', 'b', 'c', 'd', 'e');
echo Enumerator::at($arr, -1);
```

```
e
```

Example 3
---------
```php
$arr = array('a', 'b', 'c', 'd', 'e');
print_r(Enumerator::at($arr, 0, 3, 4));
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
mixed **combination\_** (array &$arr , int $limit [, mixed $callback = NULL ] )

mixed **combination** (array $arr , int $limit [, mixed $callback = NULL ] )


Will yield the various unique combinations of an array with a specific $limit.

Parameters
----------
  **&$arr**

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
$arr = array(1, 2, 3, 4);
Enumerator::combination_($arr, 1);
print_r($arr);
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
$arr = array(1, 2, 3, 4);
Enumerator::combination_($arr, 4);
print_r($arr);
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
$arr = array(1, 2, 3, 4);
Enumerator::combination_($arr, 0);
print_r($arr);
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
mixed **delete\_** (array &$arr , mixed $needle [, callable $callback = NULL ] )

mixed **delete** (array $arr , mixed $needle [, callable $callback = NULL ] )


Will delete every instance of $needle inside of $arr.
If $needle is not found null is returned.
If it is found and $callback is callable it's return value is returned.
If it is found and $callback is not defined $needle is returned.

Parameters
----------
  **&$arr**

  **$needle**

  **$callback**

Return
------
 mixed

Example 1
---------
```php
$arr = array('a','b', 'b', 'b', 'c');
echo Enumerator::delete_($arr, 'b') . PHP_EOL;
print_r($arr);
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
$arr = array('a','b', 'b', 'b', 'c');
var_dump(Enumerator::delete_($arr, 'z'));
```

```
NULL
```

Example 3
---------
```php
$arr = array('a','b', 'b', 'b', 'c');
var_dump(Enumerator::delete($arr, 'z', function() {
	return false;
}));
```

```
bool(false)
```


<a name="method_delete_at_"></a>Methods: delete\_at\_, delete\_at
==============================
mixed **delete\_at\_** (array &$arr , mixed $index )

mixed **delete\_at** (array &$arr , mixed $index )


Will delete the element at the specific index. If the element is found that element is returned, otherwise null is returned.

Parameters
----------
  **&$arr**

  **$index**

Return
------
 mixed

Example 1
---------
```php
$arr = array('ant', 'bat', 'cat', 'dog');
$ret = Enumerator::delete_at_($arr, 2);
echo $ret . PHP_EOL;
print_r($arr);
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
$arr = array('ant', 'bat', 'cat', 'dog');
$ret = Enumerator::delete_at($arr, 99);
var_dump($ret);
```

```
NULL
```


<a name="method_fetch"></a>Methods: fetch\_, fetch
======================
mixed **fetch\_** (array $arr , mixed $index , mixed $value )

mixed **fetch** (array $arr , mixed $index , mixed $value )


Will retrieve the value of the specific index. Will also retrieve negative index counting backwards.
If $index is not found and $value is callable, the index is passed to it and it's return value is returned.
If $index is not found and $value is not callable, $value is returned.

Parameters
----------
  **$arr**

  **$index**

  **$value**

Return
------
 mixed

Example 1
---------
```php
$arr = array(11, 22, 33, 44);
echo Enumerator::fetch($arr, 1);
```

```
22
```

Example 2
---------
```php
$arr = array(11, 22, 33, 44);
echo Enumerator::fetch($arr, -1);
```

```
44
```

Example 3
---------
```php
$arr = array(11, 22, 33, 44);
echo Enumerator::fetch($arr, 4, 'cat');
```

```
cat
```

Example 4
---------
```php
$arr = array(11, 22, 33, 44);
echo Enumerator::fetch($arr, 4, function($i) {
	return $i * $i;
});
```

```
16
```


<a name="method_flatten_"></a>Methods: flatten, flatten\_
==========================
mixed **flatten** (array $arr [, int $depth = 999999 ] )

mixed **flatten\_** (array &$arr [, int $depth = 999999 ] )


Will flatten the array to a single array or until the $depth is reached.

Parameters
----------
  **&$arr**

  **$depth**

Return
------
 mixed

Example 1
---------
```php
$arr = array(1, 2, array(3, array(4, 5)));
$arr = Enumerator::flatten($arr);
echo print_r($arr, true) . PHP_EOL;
$arr = Enumerator::flatten($arr);
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
$arr = array(1, 2, array(3, array(4, 5)));
Enumerator::flatten_($arr, 1);
print_r($arr);
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
mixed **array\_column\_** (array &$arr , mixed $index )

mixed **array\_column** (array &$arr , mixed $index )

mixed **array\_pluck\_** (array &$arr , mixed $index )

mixed **array\_pluck** (array &$arr , mixed $index )


Will return an array of values from a multidimensional array based on the index provided.

Parameters
----------
  **&$arr**

  **$index**

Return
------
 mixed

