<?php
include('PrettyArray.php');

$obj = new PrettyArray('Foo', 'bar', 'foobar');
echo $obj->rotate(3, true); // foobar, Foo, bar