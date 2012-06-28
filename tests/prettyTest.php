<?php
include('../PrettyArray.php');

// array.map
$obj = new PrettyArray(1, 2, 3);
$obj->map(function($key, &$value) {
	$value .= "_rawr";
});
echo $obj; // 1_rawr, 2_rawr, 3_rawr
echo '<hr />';

// array.index
$obj = new PrettyArray('a', 'b', 'c');
echo $obj->index("b"); // 1
echo $obj->index(function($key, $value) {
	return ($value == "c");
}); // 2
echo '<hr />';

// array.delete_if
$obj = new PrettyArray('Foo', 'bar', 'foobar');
echo $obj->delete_if(function($key, $value) {
	// Deletes if the value has a lowercase 'a'
	return (strstr($value, 'a') !== false);
}, true); // Foo
echo '<hr />';

// array.keep_if
$obj = new PrettyArray('Foo', 'bar', 'foobar');
echo $obj->keep_if(function($key, $value) {
	// Keeps if the value has a lowercase 'a'
	return (strstr($value, 'a') !== false);
}); // bar, foobar
echo '<hr />';

// array.reverse_map
$obj = new PrettyArray('Foo', 'bar', 'foobar');
echo $obj->reverse_map(function($key, &$value) {
	$value .= '_';
}); // foobar_, bar_, foo_
echo '<hr />';

// rotate
$obj = new PrettyArray('Foo', 'bar', 'foobar');
echo $obj->rotate(3, true); // foobar, Foo, bar
echo '<hr />';