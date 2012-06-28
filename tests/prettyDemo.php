<?php
/*

Benchmarked different types of array handling.
The first number, and fastest, is the default PHP arrays.
The second is a simple LinkedList I created using objects.
The third was an array wrapper class.

string(17) "Write Times(1000)"
	float(0.0015439987182617)
	float(0.0068049430847168)
	float(0.0023720264434814)
string(16) "Read Times(1000)"
	float(0.00036978721618652)
	float(0.87737107276917)
	float(0.00080299377441406)
*/

exit;

echo '<pre>';

$a = array();
$b = new PrettyArray();
$c = new PrettyArraySimple();
$d = array(); // Holds random keys

$times = 1000;

// Writing arrays
	// Wrote array
	for($i = 0;$i<$times;$i++) {
		$a[] = microtime(true);
	}

	// Write prettyArray
	for($i = 0;$i<$times;$i++) {
		$b[] = microtime(true);
	}

	// Write prettyArraySimple
	for($i = 0;$i<$times;$i++) {
		$c[] = microtime(true);
	}

	// Write results
	var_dump(
		'Write Times(' . $times . ')',
		$a[999] - $a[0],
		$b[999] - $b[0],
		$c[999] - $c[0]
	);

// Read array
	$read = array('array'=>array(), 'pretty'=>array(), 'simple'=>array());
	// Create array of pointers
	// Only compareable if accessing same values
	$d = array();
	for($i = 0;$i<$times;$i++) {
		$d[] = mt_rand(0, 999);
	}

	// Reading array
	$read['array']['start'] = microtime(true);
	for($i = 0;$i<$times;$i++) {
		$a[$d[$i]];
	}
	$read['array']['end'] = microtime(true);

	// Reading pretty array
	$read['pretty']['start'] = microtime(true);
	for($i = 0;$i<$times;$i++) {
		$b[$d[$i]];
	}
	$read['pretty']['end'] = microtime(true);

	// Reading simple array
	$read['simple']['start'] = microtime(true);
	for($i = 0;$i<$times;$i++) {
		$c[$d[$i]];
	}
	$read['simple']['end'] = microtime(true);

	// Reading resluts
	var_dump(
		'Read Times(' . $times . ')',
		$read['array']['end'] - $read['array']['start'],
		$read['pretty']['end'] - $read['pretty']['start'],
		$read['simple']['end'] - $read['simple']['start']
	);


echo '</pre>';