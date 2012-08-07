<?php

/*
	Tests hard/destructive aliases in enumerator.
*/

class enumeratorDestructiveAliasTest extends PHPUnit_Framework_TestCase {

// Hard aliases
	public function test_find_1() {
		// Callback 1
		$arr = range(1,10);
		$ret = enumerator::find_($arr, function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, null);
	}

	public function test_find_2() {
		// Callback 2
		$arr = range(1,100);
		$ret = enumerator::find_($arr, function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, 35);
	}

	public function test_find_3() {
		// Destructive
		$arr = range(1,3);
		enumerator::find_($arr, function($key, &$value) {
			$value *= 2;
			return false;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_find_all_1() {
		// Basic
		$arr = range(1,10);
		enumerator::find_all_($arr,function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}

	public function test_find_all_2() {
		// Destructive
		$arr = range(1,3);
		enumerator::find_all_($arr, function($key, &$value) {
			$value *= 2;
			return true;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_keep_if_1() {
		// Basic
		$arr = range(1,10);
		enumerator::keep_if_($arr,function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}

	public function test_keep_if_2() {
		// Destructive
		$arr = range(1,3);
		enumerator::keep_if_($arr, function($key, &$value) {
			$value *= 2;
			return true;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_flat_map_1() {
		// Basic test
		$arr = array(array(1,2), array(3,4));
		enumerator::flat_map_($arr, function($key, &$value) {
			return ++$value;
		});
		$this->assertEquals($arr, array(2,3,4,5));
	}

	public function test_reduce_1() {
		$arr = range(5, 10);
		$ret = enumerator::reduce_($arr, function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$this->assertEquals($ret, 45);
	}

	public function test_reduce_2() {
		$arr = range(5, 10);
		$ret = enumerator::reduce_($arr, function($key, &$value, &$memo){
			$memo *= $value;
			return;
		}, 1); // 151200
		$this->assertEquals($ret, 151200);
	}

	public function test_delete_if_1() {
		$arr = range(1,10);
		enumerator::delete_if_($arr, function($key, $value) {
			return ($value % 3 == 0);
		}); // [1, 2, 4, 5, 7, 8, 10]
		$this->assertEquals($arr, array(0=>1,1=>2,3=>4,4=>5,6=>7,7=>8,9=>10));
	}

	public function test_reverse_each_1() {
		// Test destruction
		$arr = array(1, 2, 3);
		enumerator::reverse_each_($arr, function($key, &$value) {
			$value *= 2;
			return;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_each_2() {
		// Test destruction
		$arr = array(1, 2, 3);
		$index = 2;
		$that = $this;
		enumerator::reverse_each_($arr, function($key, &$value) use(&$index, &$that) {
			$that->assertEquals($key, $index--);
			return;
		});
	}

	public function test_reverse_map_1() {
		// Test destruction
		$arr = array(1, 2, 3);
		enumerator::reverse_map_($arr, function($key, &$value) {
			$value *= 2;
			return;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_map_2() {
		// Test destruction
		$arr = array(1, 2, 3);
		$index = 2;
		$that = $this;
		enumerator::reverse_map_($arr, function($key, &$value) use(&$index, &$that) {
			$that->assertEquals($key, $index--);
			return;
		});
	}

	public function test_reverse_foreach_1() {
		// Test destruction
		$arr = array(1, 2, 3);
		enumerator::reverse_foreach_($arr, function($key, &$value) {
			$value *= 2;
			return;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_foreach_2() {
		// Test destruction
		$arr = array(1, 2, 3);
		$index = 2;
		$that = $this;
		enumerator::reverse_foreach_($arr, function($key, &$value) use(&$index, &$that) {
			$that->assertEquals($key, $index--);
			return;
		});
	}

	public function test_reverse_each_with_index_1() {
		// Test destruction
		$arr = array(1, 2, 3);
		enumerator::reverse_each_with_index_($arr, function($key, &$value) {
			$value *= 2;
			return;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_each_with_index_2() {
		// Test destruction
		$arr = array(1, 2, 3);
		$index = 2;
		$that = $this;
		enumerator::reverse_each_with_index_($arr, function($key, &$value) use(&$index, &$that) {
			$that->assertEquals($key, $index--);
			return;
		});
	}

	public function test_concat_1() {
		$arr = array();
		$animals = array('dog', 'cat', 'pig');
		$trees = array('pine');
		$material = array('wool');
		enumerator::concat_($arr, $animals, $trees, $material);
		$this->assertEquals($arr, array('dog', 'cat', 'pig', 'pine', 'wool'));
	}

	public function test_sample_1() {
		$arr = array('pig', 'cow', 'dog', 'horse');
		enumerator::sample_($arr);
		$this->assertInternalType('string', $arr);
		$this->assertContains($arr, array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_sample_2() {
		$arr = array('pig', 'cow', 'dog', 'horse');
		enumerator::sample_($arr, 2);
		$this->assertInternalType('array', $arr);
		$this->assertEquals(count($arr), 2);
		$this->assertContains($arr[0], array('pig', 'cow', 'dog', 'horse'));
		$this->assertContains($arr[1], array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_find_index_1() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		);
		$ret = enumerator::find_index_($name, 'John');
		$this->assertEquals($ret, 'first');
	}

	public function test_find_index_2() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		);
		$ret = enumerator::find_index_($name, function($key, &$value) {
			return (strpos($value, '.') !== false); // Has a decimal
		});
		$this->assertEquals($ret, 'title');
	}

	public function test_uniq_1() {
		$arr = array(1,1,2,3,3,2,1,1,1);
		enumerator::array_unique_($arr);
		$this->assertEquals($arr, array(0=>1,2=>2,3=>3));
	}

}