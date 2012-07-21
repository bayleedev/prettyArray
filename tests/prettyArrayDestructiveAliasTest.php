<?php

/*
	Tests hard/destructive aliases in PrettyArray.
*/

class prettyArrayDestructiveAliasTest extends PHPUnit_Framework_TestCase {

// Hard aliases
	public function test_find_1() {
		// Callback 1
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->find_(function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, null);
	}

	public function test_find_2() {
		// Callback 2
		$arr = new PrettyArray(range(1,100));
		$ret = $arr->find_(function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, 35);
	}

	public function test_find_3() {
		// Destructive
		$arr = new PrettyArray(range(1,3));
		$arr->find_(function($key, &$value) {
			$value *= 2;
			return false;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_find_all_1() {
		// Basic
		$arr = new PrettyArray(range(1,10));
		$arr->find_all_(function($key, $value) {
			return ($value % 3 == 0);
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}

	public function test_find_all_2() {
		// Destructive
		$arr = new PrettyArray(range(1,3));
		$arr->find_all_(function($key, &$value) {
			$value *= 2;
			return true;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_keep_if_1() {
		// Basic
		$arr = new PrettyArray(range(1,10));
		$arr->keep_if_(function($key, $value) {
			return ($value % 3 == 0);
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}

	public function test_keep_if_2() {
		// Destructive
		$arr = new PrettyArray(range(1,3));
		$arr->keep_if_(function($key, &$value) {
			$value *= 2;
			return true;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_flat_map_1() {
		// Basic test
		$arr = new PrettyArray(array(array(1,2), array(3,4)));
		$arr->flat_map_(function($key, &$value) {
			return ++$value;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,3,4,5));
	}

	public function test_reduce_1() {
		$arr = new PrettyArray(range(5, 10));
		$ret = $arr->reduce_(function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$this->assertEquals($ret, 45);
	}

	public function test_reduce_2() {
		$arr = new PrettyArray(range(5, 10));
		$ret = $arr->reduce_(function($key, &$value, &$memo){
			$memo *= $value;
			return;
		}, 1); // 151200
		$this->assertEquals($ret, 151200);
	}

	public function test_delete_if_1() {
		$arr = new PrettyArray(range(1,10));
		$arr->delete_if_(function($key, $value) {
			return ($value % 3 == 0);
		}); // [1, 2, 4, 5, 7, 8, 10]
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(0=>1,1=>2,3=>4,4=>5,6=>7,7=>8,9=>10));
	}

	public function test_reverse_each_1() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$arr->reverse_each_(function($key, &$value) {
			$value *= 2;
			return;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_each_2() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$index = 2;
		$arr->reverse_each_(function($key, &$value) use(&$index) {
			$this->assertEquals($key, $index--);
			return;
		});
	}

	public function test_reverse_map_1() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$arr->reverse_map_(function($key, &$value) {
			$value *= 2;
			return;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_map_2() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$index = 2;
		$arr->reverse_map_(function($key, &$value) use(&$index) {
			$this->assertEquals($key, $index--);
			return;
		});
	}

	public function test_reverse_foreach_1() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$arr->reverse_foreach_(function($key, &$value) {
			$value *= 2;
			return;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_foreach_2() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$index = 2;
		$arr->reverse_foreach_(function($key, &$value) use(&$index) {
			$this->assertEquals($key, $index--);
			return;
		});
	}

	public function test_reverse_each_with_index_1() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$arr->reverse_each_with_index_(function($key, &$value) {
			$value *= 2;
			return;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_each_with_index_2() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$index = 2;
		$arr->reverse_each_with_index_(function($key, &$value) use(&$index) {
			$this->assertEquals($key, $index--);
			return;
		});
	}

	public function test_concat_1() {
		$arr = new PrettyArray();
		$animals = array('dog', 'cat', 'pig');
		$trees = array('pine');
		$material = array('wool');
		$arr->concat_($animals, $trees, $material);
		$arr = $arr->to_a();
		$this->assertEquals($arr, array('dog', 'cat', 'pig', 'pine', 'wool'));
	}

	public function test_sample_1() {
		$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
		$arr->sample_();
		$arr = $arr->to_a();
		$this->assertInternalType('string', $arr);
		$this->assertContains($arr, array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_sample_2() {
		$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
		$arr->sample_(2);
		$arr = $arr->to_a();
		$this->assertInternalType('array', $arr);
		$this->assertEquals(count($arr), 2);
		$this->assertContains($arr[0], array('pig', 'cow', 'dog', 'horse'));
		$this->assertContains($arr[1], array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_find_index_1() {
		$name = new PrettyArray(array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		));
		$ret = $name->find_index_('John');
		$this->assertEquals($ret, 'first');
	}

	public function test_find_index_2() {
		$name = new PrettyArray(array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		));
		$ret = $name->find_index_(function($key, &$value) {
			return (strpos($value, '.') !== false); // Has a decimal
		});
		$this->assertEquals($ret, 'title');
	}

	public function test_uniq_1() {
		$arr = new PrettyArray(array(1,1,2,3,3,2,1,1,1));
		$arr->array_unique_();
		$this->assertEquals($arr->to_a(), array(0=>1,2=>2,3=>3));
	}

}