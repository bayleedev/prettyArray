# PrettyArray

A object oriented approach to handling arrays in PHP.
It attempts to combine Ruby (enumerator/array/hash) methods as well as built in PHP functions.

[![Build Status](https://secure.travis-ci.org/BlaineSch/prettyArray.png?branch=dev)](http://travis-ci.org/BlaineSch/prettyArray)

## Example 1
```php
<?php
require_once('./libraries/PrettyArray/PrettyArray.php');
$arr = new PrettyArray(range(1,6));
$arr->group_by_(function($key, &$value) {
    return ($value % 3);
});
print_r($arr->to_a());
?>
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

## More Examples

More examples can be found inside of the "/examples" directory in markdown format which is viewable on Github.

## Installation
 * cd /libraries/
 * git clone [git@github.com:BlaineSch/PrettyArray.git](https://github.com/BlaineSch/PrettyArray)
 * Enjoy PrettyArray!

## Requirements
 * [PHP 5.3+](http://php.net/downloads.php)

## Contributing

### Requirements
 * [PHP 5.3+](http://php.net/downloads.php)
 * [PHPUnit](http://www.phpunit.de/manual/3.6/en/installation.html/)

### Testing

Before making any pull requests please verify that your methods pass the current unit tests.
```
cd PrettyArray && phpunit ./
```
```
PHPUnit 3.6.12 by Sebastian Bergmann.

Configuration read from /Users/blaineschmeisser/Sites/devup/PrettyArray/phpunit.xml

...............................................................  63 / 159 ( 39%)
............................................................... 126 / 159 ( 79%)
.................................

Time: 1 second, Memory: 10.00Mb

OK (159 tests, 180 assertions)
```

### Test Files

 * [PrettyArray Test](tests/prettyArrayTest.php) - Tests the core functionality of PrettyArray.
 * [Enumerator Test](tests/enumeratorTest.php) - Tests all the core methods inside of enumerator.
 * [Exception Test](tests/exceptionTest.php) - Tests all methods specifically if they are handling exceptions correctly.