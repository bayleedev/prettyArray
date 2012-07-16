Enumerator
==========
A handy class for handling array methods similar to the methods available to ruby.

Destructive Methods:
There are "destructive" methods which are identified by the "_" at the end of the method name.
These methods will overwrite the $array passed to them.

To get around this, I have added many "alias" magic methods which all destructive methods have.
Just remove the ending '_' and instaed of overwriting the array it'll return it.

Method Alias':
Methods often have various alias' which are pointed out in the documentation. They work identically to the real function call.

### todo ###
* change examples to be 5.3 compatiable

### link ###
* http://ruby-doc.org/core-1.9.3/Enumerable.html

# Methods: __callStatic
mixed **__callStatic** (string $method , array $params )

This magic method helps with method alias' and calling destrucitve methods in a non-destructive way.
For example the real method "partition_" will take over your $array, but calling the magic method "partition" will not.
All methods implemented in this class that have an underscore at the end are destructive and have a non-destructive alias.

### Parameters
  **$method**
    ```
    The method name
    ```

  **$params**
    ```
    An array of parrams you wish to pass
    ```

### Return
  void


# Methods: all, all_
boolean **all** (array $arr [, callable $callback = NULL ] )
boolean **all_** (array &$arr [, callable $callback = NULL ] )

Passes each element of the collection to the $callback, if it ever turns false or null this function will return false, else true.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$animals = array('ant', 'bear', 'cat');
$o = enumerator::all($animals, function($key, &$value) {
	return (strlen($value) >= 3);
});
var_dump($o);
```

```

bool(true)

```

**Example 2**
```php
$animals = array('ant', 'bear', 'cat');
$o = enumerator::all($animals, function($key, &$value) {
	return (strlen($value) >= 4);
});
var_dump($o);
```

```

bool(false)

```

**Example 3**
```php
$arr = array(null, true, 99);
$o = enumerator::all($arr);
var_dump($o);
```

```

bool(false)

```


# Methods: drop, drop_
void **drop** (array $arr , int $count )
void **drop_** (array &$arr , int $count )

Drops the first $count elements.

### Parameters
  **&$arr**

  **$count**

### Return
  void

### Examples
**Example 1**
```php
$animals = array('ant', 'bear', 'cat');
$o = enumerator::drop($animals, 1);
print_r($o);
```

```

Array
(
    [0] => bear
    [1] => cat
)

```


# Methods: any, any_
boolean **any** (array $arr [, callable $callback = NULL ] )
boolean **any_** (array $arr [, callable $callback = NULL ] )

Passes each element of the collection to the $callback, if it ever returns anything besides null or false I'll return true, else I'll return false.

### Parameters
  **$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$animals = array('ant', 'bear', 'cat');
$o = enumerator::any($animals, function($key, &$value) {
	return (strlen($value) >= 3);
});
var_dump($o);
```

```

bool(true)

```

**Example 2**
```php
$animals = array('ant', 'bear', 'cat');
$o = enumerator::any($animals, function($key, &$value) {
	return (strlen($value) >= 4);
});
var_dump($o);
```

```

bool(true)

```

**Example 3**
```php
$arr = array(null, true, 99);
$o = enumerator::any($arr);
var_dump($o);
```

```

bool(true)

```


# Methods: collect, collect_, each, each_, map, map_, foreach, foreach_, each_with_index, each_with_index_, array_walk
void **collect** (array $arr , callable $callback )
void **collect_** (array &$arr , callable $callback )
void **each** (array $arr , callable $callback )
void **each_** (array &$arr , callable $callback )
void **map** (array $arr , callable $callback )
void **map_** (array &$arr , callable $callback )
void **foreach** (array $arr , callable $callback )
void **foreach_** (array &$arr , callable $callback )
void **each_with_index** (array &$arr , callable $callback )
void **each_with_index_** (array &$arr , callable $callback )
void **array_walk** (array &$arr , callable $callback )

Will iterate the elements in the array. Has the potential to change the values.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = range(1,4);
$o = enumerator::collect($arr, function($key, &$value) {
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

**Example 2**
```php
$arr = range(1,4);
$o = enumerator::collect($arr, function($key, &$value) {
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


# Methods: count, count_, size, size_, length, length_
int **count** (array $arr , callable $callback )
int **count_** (array &$arr , callable $callback )
int **size** (array $arr , callable $callback )
int **size_** (array &$arr , callable $callback )
int **length** (array $arr , callable $callback )
int **length_** (array &$arr , callable $callback )

If the callback is null, this function give you the total size of the array.
If the callback is a anonmous function, this function iterate the blocks and count how many times it returns true.
Otherwise this function will count how many times $callback is equal to $value.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1,2,4,2);
echo enumerator::count($arr);
```

```

4

```

**Example 2**
```php
$arr = array(1,2,4,2);
echo enumerator::count($arr, 2);
```

```

2

```

**Example 3**
```php
$arr = array(1,2,4,2);
echo enumerator::count($arr, function($key, &$value) {
	return ($value % 2 == 0);
});
```

```

3

```


# Methods: Methods, detect, detect_, find, find_
mixed **Methods** (array $arr , callable $callback [, mixed $ifnone = NULL ] )
mixed **detect** (array $arr , callable $callback [, mixed $ifnone = NULL ] )
mixed **detect_** (array &$arr , callable $callback [, mixed $ifnone = NULL ] )
mixed **find** (array $arr , callable $callback [, mixed $ifnone = NULL ] )
mixed **find_** (array &$arr , callable $callback [, mixed $ifnone = NULL ] )

Will pass the key and value to $callback the first result that does not return false is returned.
If no results are found this function will return the result of $ifnone (mixed) if none is provided false will be returned.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

  **$ifnone**

### Return
  void

### Examples
**Example 1**
```php
$arr = range(1,10);
$o = enumerator::detect($arr, function($key, &$value) {
	return ($value % 5 == 0 and $value % 7 == 0);
});
var_dump($o);
```

```

NULL

```

**Example 2**
```php
$arr = range(1,100);
echo enumerator::detect($arr, function($key, &$value) {
	return ($value % 5 == 0 and $value % 7 == 0);
});
```

```

35

```


# Methods: select, select_, find_all, find_all_, keep_if, keep_if_
array **select** (array $arr , callable $callback )
array **select_** (array &$arr , callable $callback )
array **find_all** (array &$arr , callable $callback )
array **find_all_** (array &$arr , callable $callback )
array **keep_if** (array &$arr , callable $callback )
array **keep_if_** (array &$arr , callable $callback )

Will pass the elements to the callback and unset them if the callback returns false.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key and a $value are passed to this callback. The $value can be accepted by reference.
    ```

### Return
array
    ```
    The array that has already been edited by reference.
    ```

### Examples
**Example 1**
```php
$arr = range(1,10);
$o = enumerator::select($arr, function($key, &$value) {
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


# Methods: each_slice, each_slice_
void **each_slice** (array &$arr , int $size [, callable $callback = NULL ] )
void **each_slice_** (array &$arr , int $size [, callable $callback = NULL ] )

Will slice the elements into $size collections and pass to $callback if defined. If not defined, the slized array is returned.

### Parameters
  **&$arr**

  **$size**
    ```
    The size of each slice.
    ```

  **$callback**
    ```
    The callback will be passed each collection. This can be passed by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = range(1,10);
$o = enumerator::each_slice($arr, 3, function(&$collection) {
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


# Methods: first, first_
void **first** (array $arr [, int $count = 1 ] )
void **first_** (array &$arr [, int $count = 1 ] )

Will overwrite $arr with the first $count items in array.

### Parameters
  **&$arr**

  **$count**
    ```
    The number of items you wish to return. Defaults to 1
    ```

### Return
  void

### Examples
**Example 1**
```php
$animals = array('cat', 'dog', 'cow', 'pig');
$o = enumerator::first($animals);
print_r($o);
```

```

Array
(
    [0] => cat
)

```

**Example 2**
```php
$animals = array('cat', 'dog', 'cow', 'pig');
$o = enumerator::first($animals, 2);
print_r($o);
```

```

Array
(
    [0] => cat
    [1] => dog
)

```


# Methods: collect_concat, collect_concat_, flat_map, flat_map_
void **collect_concat** (array &$arr , callable $callback )
void **collect_concat_** (array &$arr , callable $callback )
void **flat_map** (array &$arr , callable $callback )
void **flat_map_** (array &$arr , callable $callback )

Will flatten the input $arr into a non-multi-dimensional array.It will pass the current key and the value to $callback which has the potential to change the value.
The new array will have discarded all current keys.

### Parameters
  **&$arr**

  **$callback**
    ```
    The callback will be passed each sliced item as an array. This can be passed by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array(array(1,2),array(3,4));
$o = enumerator::collect_concat($arr, function($key, &$value) {
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


# Methods: grep, grep_
void **grep** (array $arr , string $pattern [, callable $callback = NULL ] )
void **grep_** (array &$arr , string $pattern [, callable $callback = NULL ] )

Will only keep an item if the value of the item matches $pattern.
If a callback is provided, it will pass the $key and $value into the array.

### Parameters
  **&$arr**

  **$pattern**
    ```
    The regex pattern.
    ```

  **$callback**
    ```
    The callback will be passed each sliced item as an array. This can be passed by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
$o = enumerator::grep($arr, "/^snow/");
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


# Methods: group_by, group_by_
void **group_by** (array &$arr , callable $callback [, boolean $preserve_keys = false ] )
void **group_by_** (array &$arr , callable $callback [, boolean $preserve_keys = false ] )

Each item will be passed into $callback and the return value will be the new "category" of this item.
The param $arr will be replaced with an array of these categories with all of their items.

### Parameters
  **&$arr**

  **$callback**
    ```
    The callback will be passed each sliced item as an array. This can be passed by reference.
    ```

  **$preserve_keys**
    ```
    If you want to preserve the keys or not.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = range(1,6);
$o = enumerator::group_by($arr, function($key, &$value) {
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


# Methods: member, include
boolean **member** (array $arr , mixed $needle )
boolean **include** (array $arr , mixed $needle )

This function will iterate over $arr, if any value is equal (===) to $needle this function will return true. If nothing is found this function will return false.
NOTICE: that 'include' alias is a language construct so this alias cannot be called directly. Refer to example #2.

### Parameters
  **$arr**

  **$needle**

### Return
  void

### Examples
**Example 1**
```php
$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
$o = enumerator::member($arr, 'snowcone');
var_dump($o);
```

```

bool(true)

```

**Example 2**
```php
$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
$o = enumerator::member($arr, 'snowman');
var_dump($o);
```

```

bool(false)

```

**Example 3**
```php
$fun = 'include';
$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
$o = enumerator::$fun($arr, 'snowcone');
var_dump($o);
```

```

bool(true)

```


# Methods: min
mixed **min** (array $arr , callback optional )

Will find the lowest value. If callback is defined it will compare them.

### Parameters
  **$arr**

  **optional**
    ```
    $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
    ```

### Return
  void

### Examples
**Example 1**
```php
$array = array('albatross','dog','horse');
echo enumerator::min($array);
```

```

albatross

```

**Example 2**
```php
$array = array('albatross','dog','horse');
echo enumerator::min($array, function($val1, $val2) {
	return strcmp(strlen($val1), strlen($val2));
});
```

```

dog

```


# Methods: max
mixed **max** (array $arr , callback optional )

Will find the highest value. If callback is defined it will compare them.

### Parameters
  **$arr**

  **optional**
    ```
    $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
    ```

### Return
  void

### Examples
**Example 1**
```php
$array = array('albatross','dog','horse');
echo enumerator::max($array);
```

```

horse

```

**Example 2**
```php
$array = array('albatross','dog','horse');
echo enumerator::max($array, function($val1, $val2) {
	return strcmp(strlen($val1), strlen($val2));
});
```

```

albatross

```


# Methods: min_by
mixed **min_by** (array $arr , callable $callback )

Will find the lowest item in the array but comparing the output os $callback against every item.

### Parameters
  **$arr**

  **$callback**

### Return
  void

### Examples
**Example 1**
```php
$array = array('albatross','dog','horse');
echo enumerator::min_by($array, function($val) { 
	return strlen($val); 
});
```

```

dog

```


# Methods: max_by
mixed **max_by** (array $arr , callable $callback )

Will find the highest item in the array but comparing the output os $callback against every item.

### Parameters
  **$arr**

  **$callback**

### Return
  void

### Examples
**Example 1**
```php
$array = array('albatross','dog','horse');
echo enumerator::max_by($array, function($val) {
	return strlen($val);
});
```

```

albatross

```


# Methods: minmax
array **minmax** (array $arr , callback optional )

Will return an array of min and max. Optionally you can provide a callback to sort them.

### Parameters
  **$arr**

  **optional**
    ```
    $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
    ```

### Return
  void

### Examples
**Example 1**
```php
$array = array('albatross','dog','horse'); 
$o = enumerator::minmax($array, function($val1, $val2) { 
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


# Methods: minmax_by
array **minmax_by** (array $arr , callable $callback )

Will find the lowest and highest item in the array but comparing the output os $callback against every item.

### Parameters
  **$arr**

  **$callback**

### Return
  void

### Examples
**Example 1**
```php
$array = array('albatross','dog','horse');
$o = enumerator::minmax_by($array, function($val) { 
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


# Methods: none
boolean **none** (array $arr [, callable $callback = NULL ] )

Passes each element of the collection to $callback. This will return true if $callback never returns true, else false.

### Parameters
  **$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

### Return
  void

### Examples
**Example 1**
```php
$array = array('ant', 'bear', 'cat');
$o = enumerator::none($array, function($key, $value) {
	return (strlen($value) == 5);
});
var_dump($o);
```

```

bool(true)

```

**Example 2**
```php
$array = array('ant', 'bear', 'cat');
$o = enumerator::none($array, function($key, $value) {
	return (strlen($value) >= 4);
});
var_dump($o);
```

```

bool(false)

```

**Example 3**
```php
$o = enumerator::none(array());
var_dump($o);
```

```

bool(true)

```

**Example 4**
```php
$o = enumerator::none(array(null));
var_dump($o);
```

```

bool(true)

```

**Example 5**
```php
$arr = array(null, false);
$o = enumerator::none($arr);
var_dump($o);
```

```

bool(true)

```


# Methods: one
boolean **one** (array $arr [, callable $callback = NULL ] )

Pases each element of the collection to $callback. If $callback returns true once, the function will return true. Otherwise, the function will return false.

### Parameters
  **$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

### Return
  void

### Examples
**Example 1**
```php
$array = array('ant','bear','cat');
$o = enumerator::one($array, function($key, $value) {
	return (strlen($value) == 4);
});
var_dump($o);
```

```

bool(true)

```

**Example 2**
```php
$o = enumerator::one(array(null, true, 99));
var_dump($o);
```

```

bool(false)

```

**Example 3**
```php
$o = enumerator::one(array(null, true, false));
var_dump($o);
```

```

bool(true)

```


# Methods: partition, partition_
void **partition** (array $arr , callable $callback [, boolean $preserve_keys = false ] )
void **partition_** (array &$arr , callable $callback [, boolean $preserve_keys = false ] )

Passes each element into $callback. If $callback returns true the item will be in the first category, otherwise the second.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

  **$preserve_keys**

### Return
  void

### Examples
**Example 1**
```php
$arr = range(1,6);
$o = enumerator::partition($arr, function($key, $value) {
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


# Methods: inject, inject_, reduce, reduce_
mixed **inject** (array $arr , callable $callback , mixed optional )
mixed **inject_** (array &$arr , callable $callback , mixed optional )
mixed **reduce** (array $arr , callable $callback , mixed optional )
mixed **reduce_** (array &$arr , callable $callback , mixed optional )

Will iterate the items in $arr passing each one to $callback with $memo as the third argument.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

  **optional**
    ```
    $memo This value is passed to all callback. Be sure to accept it by reference. Defaults to 0 (zero).
    ```

### Return
mixed
    ```
    The memo variable.
    ```

### Examples
**Example 1**
```php
$arr = range(5, 10);
echo enumerator::inject($arr, function($key, &$value, &$memo){
	$memo += $value;
	return;
});
```

```

45

```

**Example 2**
```php
$arr = range(5, 10);
echo enumerator::inject($arr, function($key, &$value, &$memo){
	$memo *= $value;
	return;
}, 1);
```

```

151200

```


# Methods: reject: reject_, delete_if, delete_if_
void **reject: reject_** (array &$arr , callable $callback )
void **delete_if** (array &$arr , callable $callback )
void **delete_if_** (array &$arr , callable $callback )

Will unset an item in $arr if $callback returns true for it.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback. The $value can be passed by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = range(1,10);
$o = enumerator::reject($arr, function($key, $value) {
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


# Methods: reverse_collect, reverse_collect_, reverse_each, reverse_each_, reverse_map, reverse_map_, reverse_foreach, reverse_foreach_, reverse_each_with_index
void **reverse_collect** (array &$arr , callable $callback )
void **reverse_collect_** (array &$arr , callable $callback )
void **reverse_each** (array &$arr , callable $callback )
void **reverse_each_** (array &$arr , callable $callback )
void **reverse_map** (array &$arr , callable $callback )
void **reverse_map_** (array &$arr , callable $callback )
void **reverse_foreach** (array &$arr , callable $callback )
void **reverse_foreach_** (array &$arr , callable $callback )
void **reverse_each_with_index** (array &$arr , callable $callback )

Will iterate the array in reverse, but will NOT save the order.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback. The $value can be passed by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1, 2, 3);
enumerator::reverse_collect($arr, function($key, &$value) {
	echo $value . ', ';
	return;
});
```

```

3, 2, 1,

```


# Methods: sort, sort_
void **sort** (array $arr [, callable $callback = NULL ] )
void **sort_** (array &$arr [, callable $callback = NULL ] )

Will sort the contents of $arr. A callback can be used to sort.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback. The $value can be passed by reference.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array('rhea', 'kea', 'flea');
$o = enumerator::sort($arr);
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

**Example 2**
```php
$arr = array('rhea', 'kea', 'flea');
$o = enumerator::sort($arr, function($val1, $val2) {
	return strcmp($val2, $val1);
}); // [rhea, kea, flea]
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


# Methods: sort_by, sort_by_
void **sort_by** (array &$arr , callable $callback )
void **sort_by_** (array &$arr , callable $callback )

Will sort based off of the return of $callback.

### Parameters
  **&$arr**

  **$callback**

### Return
  void

### Examples
**Example 1**
```php
$arr = array('rhea', 'kea', 'flea');
$o = enumerator::sort_by($arr, function($val) {
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


# Methods: take_while, take_while_
void **take_while** (array &$arr , callable $callback )
void **take_while_** (array &$arr , callable $callback )

Passes elements into $callback until it returns false or null, at which point this function will stop and set $arr to all prior elements.

### Parameters
  **&$arr**

  **$callback**
    ```
    A $key, $value are passed to this callback.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1,2,3,4,5,0);
$o = enumerator::take_while($arr, function($key, &$value) {
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


# Methods: zip, zip_
void **zip** (array $arr , array $one )
void **zip_** (array &$arr , array $one )

Will turn each element in $arr into an array then appending the associated indexs from the other arrays into this array as well.

### Parameters
  **&$arr**

  **$one**
    ```
    Unlimited of this.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1,2,3);
$o = enumerator::zip($arr, array(4,5,6), array(7,8,9));
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

**Example 2**
```php
$arr = array(1,2);
$o = enumerator::zip($arr, array(4,5,6),array(7,8,9));
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

**Example 3**
```php
$arr = array(4,5,6);
$o = enumerator::zip($arr, array(1,2), array(8));
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


# Methods: drop_while, drop_while_
void **drop_while** (array &$arr , callable $callback )
void **drop_while_** (array &$arr , callable $callback )

Will pass elements into $callback until false is returned at which point all elements before the current one will be removed.

### Parameters
  **&$arr**

  **$callback**

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1,2,3,4,5,0);
$o = enumerator::drop_while($arr, function($key, &$value) {
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


# Methods: cycle, cycle_
void **cycle** (array $arr , int $it , callable $callback )
void **cycle_** (array $arr , int $it , callable $callback )

Will pass every element of $arr into $callback exactly $it times.

### Parameters
  **$arr**

  **$it**

  **$callback**
    ```
    This can accept 3 arguments: $key - The key in the array, $value - The value of this key, $it - The current iteration.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1,2,3);
enumerator::cycle($arr, 3, function($key, $value, $it) {
	echo $value . ',';
});
```

```

1,2,3,1,2,3,1,2,3,

```


# Methods: each_cons, each_cons_
void **each_cons** (array &$arr , int $size [, callable $callback = false ] )
void **each_cons_** (array &$arr , int $size [, callable $callback = false ] )

This will return each section as an item in an array.
A section is each consecutive $size of $arr.
It will also iterate over each item in every section.

### Parameters
  **&$arr**

  **$size**

  **$callback**

### Return
  void

### Examples
**Example 1**
```php
$arr = range(1,10);
$o = enumerator::each_cons($arr, 8);
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


# Methods: slice_before, slice_before_
void **slice_before** (array &$arr , string $pattern )
void **slice_before_** (array &$arr , string $pattern )

When $pattern is matched in an element, all previous elements not include previous chunks are placed into a new chunk.

### Parameters
  **&$arr**

  **$pattern**

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1,2,3,4,5,6,7,8,9,0);
$o = enumerator::slice_before($arr, "/[02468]/"); // will "splice before" an even number.
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


# Methods: merge, merge_, concat, concat_
void **merge** (array $arr , array $arr2 )
void **merge_** (array &$arr , array $arr2 )
void **concat** (array $arr , array $arr2 )
void **concat_** (array &$arr , array $arr2 )

Will merge two or more arrays together.

### Parameters
  **&$arr**

  **$arr2**

### Return
  void

### Examples
**Example 1**
```php
$animals = array('dog', 'cat', 'pig');
$trees = array('pine');
$o = enumerator::merge($animals, $trees, array('wool'));
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


# Methods: rotate, rotate_
void **rotate** (array $arr , int $index )
void **rotate_** (array &$arr , int $index )

Will rotate the array so that $index is the first element in the array. Negative indexs are allowed.

### Parameters
  **&$arr**

  **$index**
    ```
    The starting index
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array('Foo', 'bar', 'foobar');
$o = enumerator::rotate($arr, 1);
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

**Example 2**
```php
$arr = array('Foo', 'bar', 'foobar');
$o = enumerator::rotate($arr, -1);
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


# Methods: reverse, reverse_
void **reverse** (array $arr , boolean optional )
void **reverse_** (array &$arr , boolean optional )

Will reverse an array.

### Parameters
  **&$arr**

  **optional**
    ```
    $preserve_keys Defaults to false. If you want to preserve the keys or not.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1,2,3);
$o = enumerator::reverse($arr);
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


# Methods: random, random_, sample, sample_
mixed **random** (array $arr , int optional )
mixed **random_** (array &$arr , int optional )
mixed **sample** (array $arr , int optional )
mixed **sample_** (array &$arr , int optional )

Will get $count random values from $arr. If $count is 1 then it'll return the value, otherwise it'll return an array of values.

### Parameters
  **&$arr**

  **optional**
    ```
    $count Defaults to 1
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array('pig', 'cow', 'dog', 'horse');
$o = enumerator::random($arr);
echo $o;
```

```

dog

```

**Example 2**
```php
$arr = array('pig', 'cow', 'dog', 'horse');
$o = enumerator::random($arr, 2);
print_r($o);
```

```

Array
(
    [0] => dog
    [1] => cow
)

```


# Methods: shuffle, shuffle_
void **shuffle** (array $arr [, boolean $preserve_keys = false ] )
void **shuffle_** (array &$arr [, boolean $preserve_keys = false ] )

Will shuffle the inputted array.

### Parameters
  **&$arr**

  **$preserve_keys**
    ```
    If you want to preserve keys or not. Defaults to false.
    ```

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1,2,3);
$o = enumerator::shuffle($arr);
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

**Example 2**
```php
$arr = array('a' => 'apple', 'b' => 'banana', 'c' => 'carrot');
$o = enumerator::shuffle($arr, true);
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


# Methods: values_at, values_at_
void **values_at** (type array , mixed $index )
void **values_at_** (type array , mixed $index )

Will replace the current array with only the inserted indexs. Use the non-destructive form to get the array returned instead.

### Parameters
  **array**
    ```
    &$arr
    ```

  **$index**
    ```
    Put in as many indexes as you please.
    ```

### Return
  void

### Examples
**Example 1**
```php
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.'
);
$o = enumerator::values_at($name, 'title', 'last');
print_r($o);
```

```

Array
(
    [title] => Dr.
    [last] => Doe
)

```


# Methods: empty, isEmpty
boolean **empty** (array $arr )
boolean **isEmpty** (array $arr )

If the array is empty or not.
NOTICE: that 'empty' alias is a language construct so this alias cannot be called directly. Refer to example #3.

### Parameters
  **$arr**

### Return
  void

### Examples
**Example 1**
```php
$arr = array();
var_dump(enumerator::isEmpty($arr));
```

```

bool(true)

```

**Example 2**
```php
$arr = array(1,2,3);
var_dump(enumerator::isEmpty($arr));
```

```

bool(false)

```

**Example 3**
```php
$empty = 'empty';
$arr = array(1,2,3);
var_dump(enumerator::$empty($arr));
```

```

bool(false)

```


# Methods: has_value
boolean **has_value** (array $arr , mixed $value )

Will return a boolean based on the condition that $value exists inside of $arr and are the same data type.

### Parameters
  **$arr**

  **$value**

### Return
  void

### Examples
**Example 1**
```php
$arr = array(0,false);
var_dump(enumerator::has_value($arr, null));
```

```

bool(false)

```

**Example 2**
```php
$arr = array(false,null);
var_dump(enumerator::has_value($arr, 0));
```

```

bool(false)

```

**Example 3**
```php
$arr = array('apple', 'banana', 'orange');
var_dump(enumerator::has_value($arr, 'orange'));
```

```

bool(true)

```


# Methods: index, index_, find_index, find_index_
mixed **index** (array $arr [, mixed $callback = NULL ] )
mixed **index_** (array &$arr [, mixed $callback = NULL ] )
mixed **find_index** (array &$arr [, mixed $callback = NULL ] )
mixed **find_index_** (array &$arr [, mixed $callback = NULL ] )

Will return the first index if found or false otherwise. Use '===' for comparing.
If $callback is a callback function, the $key is returned the first time $callback returns true.
If $callback is not a callback, we are looking for the first $value in $arr to be === $callback.

### Parameters
  **&$arr**

  **$callback**

### Return
  void

### Examples
**Example 1**
```php
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
);
echo enumerator::index($name, 'John');
```

```

first

```

**Example 2**
```php
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
);
echo enumerator::index_($name, function($key, &$value) {
	return (strpos($value, '.') !== false); // Has a decimal
});
```

```

title

```


# Methods: rindex, rindex_
mixed **rindex** (array $arr , mixed $callback )
mixed **rindex_** (array &$arr , mixed $callback )

Similar to index but looks for the last occurace of $callback.
If $callback is a callback function, the $key is returned the last time $callback returns true.
If $callback is not a callback, we are looking for the last $value in $arr to be === $callback.

### Parameters
  **&$arr**

  **$callback**

### Return
  void

### Examples
**Example 1**
```php
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
);
echo enumerator::rindex($name, 'John');
```

```

first

```

**Example 2**
```php
$name = array(
	'name' => 'John Doe',
	'first' => 'John',
	'middle' => 'M',
	'last' => 'Doe',
	'title' => 'Dr.',
	'suffix' => 'Jr.'
);
echo enumerator::rindex_($name, function($key, &$value) {
	return (strpos($value, '.') !== false);
});
```

```

suffix

```


# Methods: compact, compact_
void **compact** (array $arr )
void **compact_** (array &$arr )

Will remove all null values inside of $arr. If $recursive is set to true, it will crawl sub-arrays.

### Parameters
  **&$arr**

### Return
  void

### Examples
**Example 1**
```php
$arr = array(1,2,3,null,array(2,3,4,null));
$o = enumerator::compact($arr);
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

**Example 2**
```php
$arr = array(1,2,3,null,array(2,3,4,null));
$o = enumerator::compact($arr, true);
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

