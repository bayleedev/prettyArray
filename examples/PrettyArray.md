PrettyArray
===========
This class does not have very much in it, and is planning on staying that way. Instead, it makes magic calls to the 'enumerator' class.
All methods in enumerator are static, which allows this class to call them statically or non-statically making PrettyArray very versatile.
When you are calling methods in enumerator it will always append the current array to the paramater list.

### see ###
* PrettyArray::__call()
* PrettyArray::__callStatic()

# Methods: __construct
void **__construct** (array optional )

The default array can be passed as the first argument in the constructor.

### Parameters
  **optional**
    ```
    $defaults
    ```

### Return
  void


# Methods: offsetSet
$value **offsetSet** (mixed $key , mixed $value )

Method: offsetSet

Part of ArrayAccess. Allows PrettyArray to set a value based on the [] operator.

### Parameters
  **$key**

  **$value**

### Return
  void


# Methods: offsetExists
boolean **offsetExists** (mixed $key )

Method: offsetExists

Part of ArrayAccess. If the offest exists.

### Parameters
  **$key**

### Return
  void


# Methods: offsetUnset
void **offsetUnset** (mixed $key )

Method: offsetUnset

Part of ArrayAccess. Will unset the value if it exists.

### Parameters
  **$key**

### Return
  void


# Methods: offsetGet
type **offsetGet** (type $key )

Method: offsetGet

Part of ArrayAccess. Will get the value of the current offset.

### Parameters
  **$key**

### Return
  void


# Methods: __call
mixed **__call** (string $method , array $params )

This serves two purposes.
The first is that it helps the destructive methods in this class become non-destructive giving them aliases.
The second is that is also proxies/mixins the static enumerable methods to non-static calls on this class and appends the current array as the first param.

### Parameters
  **$method**

  **$params**

### Return
  void


# Methods: __callStatic
mixed **__callStatic** (string $method , array $params )

A basic proxy for static methods on enumerator.

### Parameters
  **$method**

  **$params**

### Return
  void


# Methods: getRange_
PrettyArray **getRange_** (mixed $start , mixed $end )

Will get a 'range' from PrettyArray. Calling it destructively will force the return value to be references to the current PrettyArray.

### Parameters
  **$start**

  **$end**

### Return
  void


# Methods: getSet, getSet_
PrettyArray **getSet** (mixed $start , int $length )
PrettyArray **getSet_** (mixed $start , int $length )

Will get a 'set' from PrettyArray. Calling it destructively will force the return value to be references to the current PrettyArray.

### Parameters
  **$start**

  **$length**

### Return
  void


# Methods: setByReference
$value **setByReference** (mixed $key , mixed $value )

By default you can't set by reference. This helps you do so.

### Parameters
  **$key**

  **&$value**

### Return
$value
    ```
    from before
    ```


# Methods: __toString
void **__toString** ()

Method: __toString

Converts the PrettyArray into a print_r string.

### Return
  void


# Methods: to_a
array **to_a** ()

Will return the array of data that PrettyArray has stored.

### Return
  void

