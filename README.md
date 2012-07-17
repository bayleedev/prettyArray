# PrettyArray

A object oriented approach to handling arrays in PHP.
It attempts to combine Ruby (enumerator/array/hash) methods as well as built in PHP functions.

## Example 1
```php
<?php
$arr = new PrettyArray(array(1,2,3,null,array(2,3,4,null)));
$arr->compact_($arr, true);
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
       )

)
```

## More Examples
 * [PrettyArray Examples](examples/PrettyArray.md)
 * [Enumerator Examples](examples/enumerator.md)

## Requirements
 * PHP 5.3+

## Contributing

### Requirements
 * PHP 5.3+
 * PHPUnit

### Testing

After making any pull requests please verify that your methods pass the current unit tests.
```
phpunit ./tests/
```

### Test Files

 * [PrettyArray Test](tests/prettyArrayTest.php) - Tests the core functionality of PrettyArray.
 * [Enumerator Test](tests/enumeratorTest.php) - Tests all the core methods inside of enumerator.
 * [Enumerator Alias Test](tests/enumeratorAliasTest.php) - Tests all non-destructive aliases inside of enumerator.
 * [PrettyArray Alias Test](tests/prettyArrayAliasTest.php) - Tests all non-destructive aliases inside of enumerator.
 * [Enumerator Destructive Alias Test](tests/enumeratorDestructiveAliasTest.php) - Tests all destructive aliases inside of enumerator.
 * [PrettyArray Destructive Alias Test](tests/prettyArrayDestructiveAliasTest.php) - Tests all destructive aliases inside of PrettyArray.
 * [PrettyArray Enumerator Test](tests/prettyArrayEnumeratorTest.php) - Tests alias methods that go directly to a core enumerator method.
 * [PrettyArray Static Test](tests/prettyArrayStaticAliasTest.php) - Tests static calls directly to non-destructive aliases on enumerator.

