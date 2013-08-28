<?php
/*
	Tests the core functionality of Enumerator
*/

use prettyArray\Enumerator;

class EnumeratorTest extends PHPUnit_Framework_TestCase {

// The next 3 methods tests non-destructive aliases
	public function test_alias_drop() {
		// Normal value
		$animals = array('ant', 'bear', 'cat');
		$animals = Enumerator::drop($animals, 1);
		$this->assertEquals(array('bear', 'cat'), $animals);
	}
	public function test_alias_size() {
		// Counting specific values
		$arr = array(1,2,4,2);
		$ret = Enumerator::size($arr, 2);
		$this->assertEquals(2, $ret);
	}
	public function test_alias_group_by() {
		// Basic test
		$arr = range(1,6);
		$arr =Enumerator::group_by($arr, function($key, &$value) {
			return ($value % 3);
		});
		$this->assertEquals(array(array(3, 6), array(1, 4), array(2,5)), $arr);
	}

// The next 3 methods test destructive aliases
	public function test_destructive_alias_reduce() {
		$arr = range(5, 10);
		$ret = Enumerator::reduce_($arr, function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$this->assertEquals(45, $ret);
	}
	public function test_destructive_alias_keep_if() {
		// Destructive
		$arr = range(1,3);
		Enumerator::keep_if_($arr, function($key, &$value) {
			$value *= 2;
			return true;
		});
		$this->assertEquals(array(2,4,6), $arr);
	}
	public function test_destructive_alias_unique() {
		$arr = array(1,1,2,3,3,2,1,1,1);
		Enumerator::array_unique_($arr);
		$this->assertEquals(array(0=>1,2=>2,3=>3), $arr);
	}

// The rest test core Enumerator methods

	public function test_all_1() {
		// Callback testing
		$animals = array('ant', 'bear', 'cat');
		$ret = Enumerator::all_($animals, function($key, $value) {
			return (strlen($value) >= 3);
		});
		$this->assertEquals(true, $ret);
	}

	public function test_all_2() {
		// Callback testing 2
		$animals = array('ant', 'bear', 'cat');
		$ret = Enumerator::all_($animals, function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals(false, $ret);
	}

	public function test_all_3() {
		// Destructive testing
		$animals = array('ant', 'bear', 'cat');
		Enumerator::all_($animals, function($key, &$value) {
			$value .= '_';
			return true;
		});
		$this->assertEquals(array('ant_', 'bear_', 'cat_'), $animals);
	}

	public function test_all_4() {
		// Without callback test
		$values = array(null, true, 99);
		$ret = Enumerator::all_($values);
		$this->assertEquals(false, $ret);
	}

	public function test_drop_1() {
		// Normal value
		$animals = array('ant', 'bear', 'cat');
		Enumerator::drop_($animals, 1);
		$this->assertEquals(array('bear', 'cat'), $animals);
	}

	public function test_drop_2() {
		// High Value
		$animals = array('ant', 'bear', 'cat');
		Enumerator::drop_($animals, 6);
		$this->assertEquals(array(), $animals);
	}

	public function test_any_1() {
		// Callback 1
		$animals = array('ant', 'bear', 'cat');
		$ret = Enumerator::any_($animals, function($key, $value) {
			return (strlen($value) >= 3);
		});
		$this->assertEquals(true, $ret);
	}

	public function test_any_2() {
		// Callback 2
		$animals = array('ant', 'bear', 'cat');
		$ret = Enumerator::any_($animals, function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals(true, $ret);
	}

	public function test_any_3() {
		// Destructive
		$animals = array('ant', 'bear', 'cat');
		Enumerator::any_($animals, function($key, &$value) {
			$value .= '_';
			return false;
		});
		$this->assertEquals(array('ant_', 'bear_', 'cat_'), $animals);
	}

	public function test_any_4() {
		// No callback 1
		$arr = array(null, true, 99);
		$ret = Enumerator::any_($arr);
		$this->assertEquals(true, $ret);
	}

	public function test_each_1() {
		// Editing 1
		$arr = range(1,4);
		Enumerator::each_($arr, function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals(array(1, 4, 9, 16), $arr);
	}

	public function test_each_2() {
		// Editing 2
		$arr = range(1,4);
		Enumerator::each_($arr, function($key, &$value) {
			$value = "cat";
			return;
		});
		$this->assertEquals(array("cat", "cat", "cat", "cat"), $arr);
	}

	public function test_collect_1() {
		// Editing 1
		$arr = range(1,4);
		Enumerator::collect_($arr, function($key, &$value) {
			return $value * $value;
		});
		$this->assertEquals(array(1, 4, 9, 16), $arr);
	}

	public function test_collect_2() {
		// Editing 2
		$arr = range(1,4);
		Enumerator::collect_($arr, function($key, &$value) {
			return 'cat';
		});
		$this->assertEquals(array("cat", "cat", "cat", "cat"), $arr);
	}

	public function test_count_1() {
		// Basic count
		$arr = array(1,2,4,2);
		$ret = Enumerator::count_($arr);
		$this->assertEquals(4, $ret);
	}

	public function test_count_2() {
		// Counting specific values
		$arr = array(1,2,4,2);
		$ret = Enumerator::count_($arr, 2);
		$this->assertEquals(2, $ret);
	}

	public function test_count_3() {
		// Count all true values based on callback return value
		$arr = array(1,2,4,2);
		$ret = Enumerator::count_($arr, function($key, &$value) {
			return ($value % 2 == 0);
		});
		$this->assertEquals(3, $ret);
	}

	public function test_count_4() {
		// Testing destructive callback
		$arr = array(1,2,4,2);
		Enumerator::count_($arr, function($key, &$value) {
			$value *= 2;
			return true;
		});
		$this->assertEquals(array(2,4,8, 4), $arr);
	}

	public function test_detect_1() {
		// Callback 1
		$arr = range(1,10);
		$ret = Enumerator::detect_($arr, function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals(null, $ret);
	}

	public function test_detect_2() {
		// Callback 2
		$arr = range(1,100);
		$ret = Enumerator::detect_($arr, function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals(35, $ret);
	}

	public function test_detect_3() {
		// Destructive
		$arr = range(1,3);
		Enumerator::detect_($arr, function($key, &$value) {
			$value *= 2;
			return false;
		});
		$this->assertEquals(array(2,4,6), $arr);
	}

	public function test_select_1() {
		// Basic
		$arr = range(1,10);
		Enumerator::select_($arr,function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals(array(2=>3, 5=>6, 8=>9), $arr);
	}

	public function test_select_2() {
		// Destructive
		$arr = range(1,3);
		Enumerator::select_($arr, function($key, &$value) {
			$value *= 2;
			return true;
		});
		$this->assertEquals(array(2,4,6), $arr);
	}

	public function test_each_slice_1() {
		// Basic
		$arr = range(1,10);
		Enumerator::each_slice_($arr, 3, function(&$collection) {
			foreach($collection as $key => &$value) ++$value;
			return;
		});
		$this->assertEquals(array(array(2,3,4), array(5,6,7), array(8,9,10), array(11)), $arr);
	}

	public function test_find_index_1() {
		// Can't find value
		$arr = range(1,10);
		$ret = Enumerator::find_index_($arr, function($key, $value) {
			return ($value % 5 == 0 && $value % 7 == 0);
		}); // null
		$this->assertEquals(null, $ret);
	}

	public function test_find_index_2() {
		// Finds value
		$arr = range(1,100);
		$ret = Enumerator::find_index_($arr, function($key, &$value) {
			return ($value % 5 == 0 && $value % 7 == 0);
		}); // 34
		$this->assertEquals(34, $ret);
	}

	public function test_find_index_3() {
		// No callback
		$arr = range(1,100);
		$ret = Enumerator::find_index_($arr, 50); // 49
		$this->assertEquals(49, $ret);
	}

	public function test_first_1() {
		// Test without $count
		$animals = array('cat', 'dog', 'cow', 'pig');
		Enumerator::first_($animals);
		$this->assertEquals(array('cat'), $animals);
	}

	public function test_first_2() {
		// With count
		$animals = array('cat', 'dog', 'cow', 'pig');
		Enumerator::first_($animals, 2); // cat, dog
		$this->assertEquals(array('cat', 'dog'), $animals);
	}

	public function test_collect_concat_1() {
		// Basic test
		$arr = array(array(1,2), array(3,4));
		Enumerator::collect_concat_($arr, function($key, &$value) {
			return ++$value;
		});
		$this->assertEquals(array(2,3,4,5), $arr);
	}

	public function test_grep_1() {
		// No callback
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		Enumerator::grep_($arr, "/^snow/");
		$this->assertEquals(array('snowball', 'snowcone', 'snowangel'), $arr);
	}
	public function test_grep_2() {
		// Destructive callback
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		Enumerator::grep_($arr, "/^snow/", function($key, &$value) {
			$value .= '_';
			return;
		});
		$this->assertEquals(array('snowball_', 'snowcone_', 'snowangel_'), $arr);
	}

	public function test_group_by_1() {
		// Basic test
		$arr = range(1,6);
		Enumerator::group_by_($arr, function($key, &$value) {
			return ($value % 3);
		});
		$this->assertEquals(array(array(3, 6), array(1, 4), array(2,5)), $arr);
	}

	public function test_member_1() {
		// Basic test
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		$ret = Enumerator::member($arr, 'snowcone'); // true
		$this->assertEquals(true, $ret);
	}

	public function test_member_2() {
		// Basic test
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		$ret = Enumerator::member($arr, 'snowman'); // false
		$this->assertEquals(false, $ret);
	}
	public function test_min_1() {
		// Basic test
		$array = array('albatross','dog','horse');
		$ret = Enumerator::min($array); // albatross
		$this->assertEquals('albatross', $ret);
	}

	public function test_min_2() {
		// Basic test
		$array = array('albatross','dog','horse');
		$ret = Enumerator::min($array, function($val1, $val2) {
			return strcmp(strlen($val1), strlen($val2));
		}); // dog
		$this->assertEquals('dog', $ret);
	}

	public function test_max_1() {
		// Basic test
		$array = array('albatross','dog','horse');
		$ret = Enumerator::max($array); // horse
		$this->assertEquals('horse', $ret);
	}

	public function test_max_2() {
		// Basic test
		$array = array('albatross','dog','horse');
		$ret = Enumerator::max($array, function($val1, $val2) {
			return strcmp(strlen($val1), strlen($val2));
		}); // albatross
		$this->assertEquals('albatross', $ret);
	}

	public function test_min_by_1() {
		$array = array('albatross','dog','horse');
		$ret = Enumerator::min_by($array, function($val) {
			return strlen($val);
		}); // dog
		$this->assertEquals('dog', $ret);
	}

	public function test_max_by_1() {
		$array = array('albatross','dog','horse');
		$ret = Enumerator::max_by($array, function($val) {
			return strlen($val);
		}); // albatross
		$this->assertEquals('albatross', $ret);
	}

	public function test_minmax_1() {
		$array = array('albatross','dog','horse');
		$ret = Enumerator::minmax($array, function($val1, $val2) {
			return strcmp(strlen($val1), strlen($val2));
		}); // array(dog, albatross)
		$this->assertEquals(array('dog', 'albatross'), $ret);
	}

	public function test_minmax_by_1() {
		$array = array('albatross','dog','horse');
		$ret = Enumerator::minmax_by($array, function($val) {
			return strlen($val);
		}); // array(dog, albatross)
		$this->assertEquals(array('dog', 'albatross'), $ret);
	}

	public function test_none_1() {
		$arr = array('ant', 'bear', 'cat');
		$ret = Enumerator::none($arr, function($key, $value) {
			return (strlen($value) == 5);
		}); // true
		$this->assertEquals(true, $ret);
	}

	public function test_none_2() {
		$arr = array('ant', 'bear', 'cat');
		$ret = Enumerator::none($arr, function($key, $value) {
			return (strlen($value) >= 4);
		}); // false
		$this->assertEquals(false, $ret);
	}

	public function test_none_3() {
		$ret = Enumerator::none(array()); // true
		$this->assertEquals(true, $ret);
	}

	public function test_none_4() {
		$ret = Enumerator::none(array(null)); // true
		$this->assertEquals(true, $ret);
	}

	public function test_none_5() {
		$ret = Enumerator::none(array(null, false)); // true
		$this->assertEquals(true, $ret);
	}

	public function test_one_1() {
		$array = array('ant','bear','cat');
		$ret = Enumerator::one($array, function($key, $value) {
			return (strlen($value) == 4);
		}); // true
		$this->assertEquals(true, $ret);
	}

	public function test_one_2() {
		$ret = Enumerator::one(array(null, true, 99)); // false
		$this->assertEquals(false, $ret);
	}

	public function test_one_3() {
		$ret = Enumerator::one(array(null, true, false)); // true
		$this->assertEquals(true, $ret);
	}

	public function test_partition_1() {
		$arr = range(1,6);
		Enumerator::partition_($arr, function($key, $value) {
			return ($value % 2 == 0);
		});
		$this->assertEquals(array(array(2,4,6), array(1,3,5)), $arr);
	}

	public function test_inject_1() {
		$arr = range(5, 10);
		$ret = Enumerator::inject_($arr, function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$this->assertEquals(45, $ret);
	}

	public function test_inject_2() {
		$arr = range(5, 10);
		$ret = Enumerator::inject_($arr, function($key, &$value, &$memo){
			$memo *= $value;
			return;
		}, 1); // 151200
		$this->assertEquals(151200, $ret);
	}

	public function test_rejct_1() {
		$arr = range(1,10);
		Enumerator::reject_($arr, function($key, $value) {
			return ($value % 3 == 0);
		}); // [1, 2, 4, 5, 7, 8, 10]
		$this->assertEquals(array(0=>1,1=>2,3=>4,4=>5,6=>7,7=>8,9=>10), $arr);
	}

	public function test_reverse_collect_1() {
		// Test destruction
		$arr = array(1, 2, 3);
		Enumerator::reverse_collect_($arr, function($key, &$value) {
			$value *= 2;
			return;
		});
		$this->assertEquals(array(2,4,6), $arr);
	}

	public function test_reverse_collect_2() {
		// Test destruction
		$arr = array(1, 2, 3);
		$index = 2;
		$that = $this;
		Enumerator::reverse_collect_($arr, function($key, &$value) use(&$index, &$that) {
			$that->assertEquals($index--, $key);
			return;
		});
	}

	public function test_sort_1() {
		$arr = array('rhea', 'kea', 'flea');
		Enumerator::sort_($arr); // [flea, kea, rhea]
		$this->assertEquals(array('flea', 'kea', 'rhea'), $arr);
	}

	public function test_sort_2() {
		$arr = array('rhea', 'kea', 'flea');
		Enumerator::sort_($arr, function($val1, $val2) {
			return strcmp($val2, $val1);
		});
		$this->assertEquals(array('rhea', 'kea', 'flea'), $arr);
	}

	public function test_sort_by_1() {
		$arr = array('rhea', 'kea', 'flea');
		Enumerator::sort_by_($arr, function($val) {
			return strlen($val);
		});
		$this->assertEquals(array('kea', 'flea', 'rhea'), $arr);
	}

	public function test_take_while_1() {
		$arr = array(1,2,3,4,5,0);
		Enumerator::take_while_($arr, function($key, &$value) {
			return ($value < 3);
		});
		$this->assertEquals(array(1, 2), $arr);
	}

	public function test_zip_1() {
		$arr = array(1,2,3);
		Enumerator::zip_($arr, array(4,5,6), array(7,8,9));
		$this->assertEquals(array(array(1,4,7),array(2,5,8),array(3,6,9)), $arr);
	}

	public function test_zip_2() {
		$arr = array(1,2);
		Enumerator::zip_($arr, array(4,5,6),array(7,8,9));
		$this->assertEquals(array(array(1, 4, 7), array(2, 5, 8)), $arr);
	}

	public function test_zip_3() {
		$arr = array(4,5,6);
		Enumerator::zip_($arr, array(1,2), array(8));
		$this->assertEquals(array(array(4, 1, 8), array(5, 2, null), array(6, null, null)), $arr);
	}

	public function test_drop_while_1() {
		$arr = array(1,2,3,4,5,0);
		Enumerator::drop_while_($arr, function($key, &$value) {
			return ($value < 3);
		});
		$this->assertEquals(array(3,4,5,0), $arr);
	}

	public function test_cycle_1() {
		$i = 0;
		$arr = array(1,2,3);
		Enumerator::cycle($arr, 3, function($key, $value, $it) use(&$i) {
			$i++;
		});
		$this->assertEquals(9, $i);
	}

	public function test_each_cons_1() {
		$arr = range(1,10);
		$follower = 0;
		$message = '';
		Enumerator::each_cons_($arr, 3, function($key, $value, $leader) use (&$follower, &$message) {
			if($follower < $leader) {
				$message .= '||';
				$follower = $leader;
			}
			$message .= $value . ',';
		});
		$this->assertEquals("1,2,3,||2,3,4,||3,4,5,||4,5,6,||5,6,7,||6,7,8,||7,8,9,||8,9,10,", $message);
		$this->assertEquals(array(array(1,2,3), array(2,3,4), array(3,4,5), array(4,5,6), array(5,6,7), array(6,7,8), array(7,8,9), array(8,9,10)), $arr);
	}

	public function test_slice_before_1() {
		$arr = array(1,2,3,4,5,6,7,8,9,0);
		Enumerator::slice_before_($arr, "/[02468]/");
		$this->assertEquals(array(array(1), array(2,3), array(4,5), array(6,7), array(8,9), array(0)), $arr);
	}

	public function test_merge_1() {
		$arr = array();
		$animals = array('dog', 'cat', 'pig');
		$trees = array('pine');
		$material = array('wool');
		Enumerator::merge_($arr, $animals, $trees, $material);
		$this->assertEquals(array('dog', 'cat', 'pig', 'pine', 'wool'), $arr);
	}

	public function test_rotate_1() {
		$arr = array('Foo', 'bar', 'foobar');
		Enumerator::rotate_($arr, 1); // bar, foobar, Foo
		$this->assertEquals(array('bar', 'foobar', 'Foo'), $arr);
	}

	public function test_rotate_2() {
		$arr = array('Foo', 'bar', 'foobar');
		Enumerator::rotate_($arr, -1); // foobar, Foo, bar
		$this->assertEquals(array('foobar', 'Foo', 'bar'), $arr);
	}

	public function test_reverse() {
		$arr = array(1,2,3);
		Enumerator::reverse_($arr);
		$this->assertEquals(array(3,2,1), $arr);
	}

	public function test_random_1() {
		$arr = array('pig', 'cow', 'dog', 'horse');
		Enumerator::random_($arr);
		$this->assertInternalType('string', $arr);
		$this->assertContains($arr, array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_random_2() {
		$arr = array('pig', 'cow', 'dog', 'horse');
		Enumerator::random_($arr, 2);
		$this->assertInternalType('array', $arr);
		$this->assertEquals(2, count($arr));
		$this->assertContains($arr[0], array('pig', 'cow', 'dog', 'horse'));
		$this->assertContains($arr[1], array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_shuffle_1() {
		// How do you test random values?
		// There must be a better way...
		$arr = array(1,2,3);
		Enumerator::shuffle_($arr);
		$this->assertContains(1, $arr);
		$this->assertContains(2, $arr);
		$this->assertContains(3, $arr);
	}

	public function test_shuffle_2() {
		// How do you test random values?
		// There must be a better way...
		$arr = array('a' => 'apple', 'b' => 'banana', 'c' => 'carrot');
		Enumerator::shuffle_($arr, true);
		$this->assertArrayHasKey('a', $arr);
		$this->assertArrayHasKey('b', $arr);
		$this->assertArrayHasKey('c', $arr);
	}

	public function test_values_at_1() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.'
		);
		Enumerator::values_at_($name, 'title', 'last'); // ['title' => 'Dr.', 'last' => 'Doe'];
		$this->assertEquals(array('title'=>'Dr.', 'last' => 'Doe'), $name);
	}

	public function test_values_at_extra_key() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.'
		);
		$result = Enumerator::values_at($name, 'title', 'suffix');
		$expected = array(
			'title' => 'Dr.',
			'suffix' => null,
		);
		$this->assertEquals($expected, $result);
	}

	public function test_empty_1() {
		$arr = array();
		$ret = Enumerator::isEmpty($arr);
		$this->assertEquals(true, $ret);
	}

	public function test_empty_2() {
		$arr = array(1,2,3);
		$ret = Enumerator::isEmpty($arr);
		$this->assertEquals(false, $ret);
	}

	public function test_has_value_1() {
		$arr = array(0,false);
		$ret = Enumerator::has_value($arr, null); // false
		$this->assertEquals(false, $ret);
	}

	public function test_has_value_2() {
		$arr = array(false,null);
		$ret = Enumerator::has_value($arr, 0); // false
		$this->assertEquals(false, $ret);
	}

	public function test_has_value_3() {
		$arr = array('apple', 'banana', 'orange');
		$ret = Enumerator::has_value($arr, 'orange'); // true
		$this->assertEquals(true, $ret);
	}

	public function test_index_1() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		);
		$ret = Enumerator::index_($name, 'John');
		$this->assertEquals('first', $ret);
	}

	public function test_index_2() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		);
		$ret = Enumerator::index_($name, function($key, &$value) {
			return (strpos($value, '.') !== false); // Has a decimal
		});
		$this->assertEquals('title', $ret);
	}

	public function test_rindex_1() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		);
		$ret = Enumerator::rindex_($name, 'John');
		$this->assertEquals('first', $ret);
	}

	public function test_rindex_2() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		);
		$ret = Enumerator::rindex_($name, function($key, &$value) {
			return (strpos($value, '.') !== false);
		});
		$this->assertEquals('suffix', $ret);
	}

	public function test_compact_1() {
		$arr = array(1,2,3,null,array(2,3,4,null));
		Enumerator::compact_($arr);
		$this->assertEquals(array(1,2,3,4=>array(2,3,4,null)), $arr);
	}

	public function test_compact_2() {
		$arr = array(1,2,3,null,array(2,3,4,null));
		Enumerator::compact_($arr, true);
		$this->assertEquals(array(1,2,3,4=>array(2,3,4)), $arr);
	}

	public function test_uniq_1() {
		$arr = array(1,1,2,3,3,2,1,1,1);
		Enumerator::uniq_($arr);
		$this->assertEquals(array(0=>1,2=>2,3=>3), $arr);
	}

	public function test_assoc_1() {
		$s1 = array('color', 'red', 'blue', 'green');
		$s2 = array('letters', 'a', 'b', 'c');
		$s3 = 'foo';
		$arr = array($s1, $s2, $s3);
		$o = Enumerator::assoc($arr, 'letters');
		$this->assertEquals($s2, $o);
	}

	public function test_assoc_2() {
		$s1 = array('color', 'red', 'blue', 'green');
		$s2 = array('letters', 'a', 'b', 'c');
		$s3 = 'foo';
		$arr = array($s1, $s2, $s3);
		$o = Enumerator::assoc($arr, 'foo');
		$this->assertEquals(null, $o);
	}

	public function test_rassoc_1() {
		$arr = array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two"));
		$o = Enumerator::rassoc($arr, 'two');
		$this->assertEquals(array(2, 'two'), $o);
	}

	public function test_rassoc_2() {
		$arr = array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two"));
		$o = Enumerator::rassoc($arr, 'four');
		$this->assertEquals(null, $o);
	}

	public function test_at_1() {
		$arr = array('a', 'b', 'c', 'd', 'e');
		$o = Enumerator::at($arr, 0);
		$this->assertEquals('a', $o);
	}

	public function test_at_2() {
		$arr = array('a', 'b', 'c', 'd', 'e');
		$o = Enumerator::at($arr, -1);
		$this->assertEquals('e', $o);
	}

	public function test_at_3() {
		$arr = array('a', 'b', 'c', 'd', 'e');
		$o = Enumerator::at($arr, 0, 3, 4);
		$this->assertEquals(array('a', 'd', 'e'), $o);
	}

	public function test_combination_1() {
		$arr = array(1, 2, 3, 4);
		Enumerator::combination_($arr, 1);
		$this->assertEquals(array(array(1), array(2), array(3), array(4)), $arr);
	}

	public function test_combination_2() {
		$arr = array(1, 2, 3, 4);
		Enumerator::combination_($arr, 4);
		$this->assertEquals(array(array(1,2,3,4)), $arr);
	}

	public function test_combination_3() {
		$arr = array(1, 2, 3, 4);
		Enumerator::combination_($arr, 0);
		$this->assertEquals(array(array()), $arr);
	}

	public function test_combinatoin_4() {
		// tests destructive
		$arr = array(1, 2, 3, 4);
		Enumerator::combination_($arr, 4, function($key, &$value) {
			foreach($value as &$v) {
				$v++;
			}
		});
		$this->assertEquals(array(array(2,3,4,5)), $arr);
	}

	public function test_delete_1() {
		$arr = array('a','b', 'b', 'b', 'c');
		$ret = Enumerator::delete_($arr, 'b');
		$this->assertEquals('b', $ret);
		$this->assertEquals(array(0 => 'a', 4 => 'c'), $arr);
	}

	public function test_delete_2() {
		$arr = array('a','b', 'b', 'b', 'c');
		$ret = Enumerator::delete_($arr, 'z');
		$this->assertEquals(null, $ret);
		$this->assertEquals(array('a','b', 'b', 'b', 'c'), $arr);
	}

	public function test_delete_3() {
		$arr = array('a','b', 'b', 'b', 'c');
		$ret = Enumerator::delete_($arr, 'z', function() {
			return false;
		});
		$this->assertEquals(false, $ret);
		$this->assertEquals(array('a','b', 'b', 'b', 'c'), $arr);
	}

	public function test_delete_at_1() {
		$arr = array('ant', 'bat', 'cat', 'dog');
		$ret = Enumerator::delete_at_($arr, 2);
		$this->assertEquals('cat', $ret);
		$this->assertEquals(array(0 => 'ant', 1 => 'bat', 3 => 'dog'), $arr);
	}

	public function test_delete_at_2() {
		$arr = array('ant', 'bat', 'cat', 'dog');
		$ret = Enumerator::delete_at_($arr, 99);
		$this->assertEquals(null, $ret);
	}

	public function test_fetch_1() {
		$arr = array(11, 22, 33, 44);
		$ret = Enumerator::fetch($arr, 1);
		$this->assertEquals(22, $ret);
	}

	public function test_fetch_2() {
		$arr = array(11, 22, 33, 44);
		$ret = Enumerator::fetch($arr, -1);
		$this->assertEquals(44, $ret);
	}

	public function test_fetch_3() {
		$arr = array(11, 22, 33, 44);
		$ret = Enumerator::fetch($arr, 4, 'cat');
		$this->assertEquals('cat', $ret);
	}

	public function test_fetch_4() {
		$arr = array(11, 22, 33, 44);
		$ret = Enumerator::fetch($arr, 4, function($i) {
			return $i * $i;
		});
		$this->assertEquals(16, $ret);
	}

	public function test_fetch_5() {
		$arr = array(11, 22, 33, 44);
		try {
			$ret = Enumerator::fetch($arr, 4);
		} catch(\OutOfBoundsException $e) {
			// Testing the catch
			$this->assertEquals(true, true);
			return;
		}
		$this->assertEquals(false, true);
	}

	public function test_flatten_1() {
		$arr = array(1, 2, array(3, array(4, 5)));
		Enumerator::flatten_($arr);
		$this->assertEquals(array(1,2,3,4,5), $arr);

		$ret = Enumerator::flatten_($arr);
		$this->assertEquals(null, $ret);
	}

	public function test_flatten_2() {
		$arr = array(1, 2, array(3, array(4, 5)));
		Enumerator::flatten_($arr, 1);
		$this->assertEquals(array(1,2,3, array(4,5)), $arr);
	}

	public function test_array_column_1() {
		$records = array(
			array(
				'id' => 1,
				'first_name' => 'John',
				'last_name' => 'Doe'
			),
			array(
				'id' => 2,
				'first_name' => 'Sally',
				'last_name' => 'Smith'
			),
			array(
				'id' => 3,
				'first_name' => 'Jane',
				'last_name' => 'Jones'
			)
		);
		Enumerator::array_column_($records, 'first_name');
		$this->assertEquals(array('John', 'Sally', 'Jane'), $records);
	}

	public function test_array_column_2() {
		$records = array(
			array(1, 'John', 'Doe'),
			array(2, 'Sally', 'Smith'),
			array(3, 'Jane', 'Jones')
		);
		Enumerator::array_column_($records, 2);
		$this->assertEquals(array('Doe', 'Smith', 'Jones'), $records);
	}

	public function testSliceBothNumbers() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::slice_($records, 0, 1);
		$this->assertEquals(array('John'), $records);
	}

	public function testSliceSingleNumber() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::slice_($records, 2);
		$this->assertEquals(array('Jane'), $records);
	}

	public function testSliceSingleNegativeNumber() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::slice_($records, -2);
		$this->assertEquals(array('Sallie', 'Jane'), $records);
	}

	public function testSliceNoNumber() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::slice_($records);
		$this->assertEquals(array('John', 'Sallie', 'Jane'), $records);
	}

	public function testSliceNonDestructiveKeptOriginal() {
		$records = array('John', 'Sallie', 'Jane');
		$results = Enumerator::slice($records, 0, 1);
		$this->assertEquals(array('John', 'Sallie', 'Jane'), $records);
	}

	public function testSliceNonDestructiveGaveNew() {
		$records = array('John', 'Sallie', 'Jane');
		$results = Enumerator::slice($records, 0, 1);
		$this->assertEquals(array('John'), $results);
	}

	public function testFillNoRangeWithString() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::fill_($records, 'x');
		$this->assertEquals(array('x', 'x', 'x'), $records);
	}

	public function testFillStartRangeWithString() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::fill_($records, 'x', 1);
		$this->assertEquals(array('John', 'x', 'x'), $records);
	}

	public function testFillBothRangesWithString() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::fill_($records, 'x', 1, 1);
		$this->assertEquals(array('John', 'x', 'Jane'), $records);
	}

	public function testFillWithNegativeStartRange() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::fill_($records, 'x', -1);
		$this->assertEquals(array('John', 'Sallie', 'x'), $records);
	}

	public function testFillCallbackNoRange() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::fill_($records, function() {
			return 'x';
		});
		$this->assertEquals(array('x', 'x', 'x'), $records);
	}

	public function testFillWithCallbackAndStartRange() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::fill_($records, 1, function() {
			return 'x';
		});
		$this->assertEquals(array('John', 'x', 'x'), $records);
	}

	public function testFillWithCallbackAndBothRanges() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::fill_($records, 1, 1, function() {
			return 'x';
		});
		$this->assertEquals(array('John', 'x', 'Jane'), $records);
	}

	public function testFillWithCallbackAndWithNegativeStartRange() {
		$records = array('John', 'Sallie', 'Jane');
		Enumerator::fill_($records, -1, function() {
			return 'x';
		});
		$this->assertEquals(array('John', 'Sallie', 'x'), $records);
	}

	public function testNonDestructiveFillDoesntDestroy() {
		$records = array('John', 'Sallie', 'Jane');
		$return = Enumerator::fill($records, 'x');
		$this->assertEquals(array('John', 'Sallie', 'Jane'), $records);
	}

	public function testNonDestructiveFillReturns() {
		$records = array('John', 'Sallie', 'Jane');
		$return = Enumerator::fill($records, 'x');
		$this->assertEquals(array('x', 'x', 'x'), $return);
	}

}
