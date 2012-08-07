<?php

/*
	Tests the core functionality of Enumerator
*/

class enumeratorTest extends PHPUnit_Framework_TestCase {

	public function test_all_1() {
		// Callback testing
		$animals = array('ant', 'bear', 'cat');
		$ret = enumerator::all_($animals, function($key, $value) {
			return (strlen($value) >= 3);
		});
		$this->assertEquals($ret, true);
	}

	public function test_all_2() {
		// Callback testing 2
		$animals = array('ant', 'bear', 'cat');
		$ret = enumerator::all_($animals, function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals($ret, false);
	}

	public function test_all_3() {
		// Destructive testing
		$animals = array('ant', 'bear', 'cat');
		enumerator::all_($animals, function($key, &$value) {
			$value .= '_';
			return true;
		});
		$this->assertEquals($animals, array('ant_', 'bear_', 'cat_'));
	}

	public function test_all_4() {
		// Without callback test
		$values = array(null, true, 99);
		$ret = enumerator::all_($values);
		$this->assertEquals($ret, false);
	}

	public function test_drop_1() {
		// Normal value
		$animals = array('ant', 'bear', 'cat');
		enumerator::drop_($animals, 1);
		$this->assertEquals($animals, array('bear', 'cat'));
	}

	public function test_drop_2() {
		// High Value
		$animals = array('ant', 'bear', 'cat');
		enumerator::drop_($animals, 6);
		$this->assertEquals($animals, array());
	}

	public function test_any_1() {
		// Callback 1
		$animals = array('ant', 'bear', 'cat');
		$ret = enumerator::any_($animals, function($key, $value) {
			return (strlen($value) >= 3);
		});
		$this->assertEquals($ret, true);
	}

	public function test_any_2() {
		// Callback 2
		$animals = array('ant', 'bear', 'cat');
		$ret = enumerator::any_($animals, function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals($ret, true);
	}

	public function test_any_3() {
		// Destructive
		$animals = array('ant', 'bear', 'cat');
		enumerator::any_($animals, function($key, &$value) {
			$value .= '_';
			return false;
		});
		$this->assertEquals($animals, array('ant_', 'bear_', 'cat_'));
	}

	public function test_any_4() {
		// No callback 1
		$arr = array(null, true, 99);
		$ret = enumerator::any_($arr);
		$this->assertEquals($ret, true);
	}

	public function test_collect_1() {
		// Editing 1
		$arr = range(1,4);
		enumerator::collect_($arr, function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($arr, array(1, 4, 9, 16));
	}

	public function test_collect_2() {
		// Editing 2
		$arr = range(1,4);
		enumerator::collect_($arr, function($key, &$value) {
			$value = "cat";
			return;
		});
		$this->assertEquals($arr, array("cat", "cat", "cat", "cat"));
	}

	public function test_count_1() {
		// Basic count
		$arr = array(1,2,4,2);
		$ret = enumerator::count_($arr);
		$this->assertEquals($ret, 4);
	}

	public function test_count_2() {
		// Counting specific values
		$arr = array(1,2,4,2);
		$ret = enumerator::count_($arr, 2);
		$this->assertEquals($ret, 2);
	}

	public function test_count_3() {
		// Count all true values based on callback return value
		$arr = array(1,2,4,2);
		$ret = enumerator::count_($arr, function($key, &$value) {
			return ($value % 2 == 0);
		});
		$this->assertEquals($ret, 3);
	}

	public function test_count_4() {
		// Testing destructive callback
		$arr = array(1,2,4,2);
		enumerator::count_($arr, function($key, &$value) {
			$value *= 2;
			return true;
		});
		$this->assertEquals($arr, array(2,4,8, 4));
	}

	public function test_detect_1() {
		// Callback 1
		$arr = range(1,10);
		$ret = enumerator::detect_($arr, function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, null);
	}

	public function test_detect_2() {
		// Callback 2
		$arr = range(1,100);
		$ret = enumerator::detect_($arr, function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, 35);
	}

	public function test_detect_3() {
		// Destructive
		$arr = range(1,3);
		enumerator::detect_($arr, function($key, &$value) {
			$value *= 2;
			return false;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_select_1() {
		// Basic
		$arr = range(1,10);
		enumerator::select_($arr,function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}

	public function test_select_2() {
		// Destructive
		$arr = range(1,3);
		enumerator::select_($arr, function($key, &$value) {
			$value *= 2;
			return true;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_each_slice_1() {
		// Basic
		$arr = range(1,10);
		enumerator::each_slice_($arr, 3, function(&$collection) {
			foreach($collection as $key => &$value) ++$value;
			return;
		});
		$this->assertEquals($arr, array(array(2,3,4), array(5,6,7), array(8,9,10), array(11)));
	}

	public function test_find_index_1() {
		// Can't find value
		$arr = range(1,10);
		$ret = enumerator::find_index_($arr, function($key, $value) {
			return ($value % 5 == 0 && $value % 7 == 0);
		}); // null
		$this->assertEquals($ret, null);
	}

	public function test_find_index_2() {
		// Finds value
		$arr = range(1,100);
		$ret = enumerator::find_index_($arr, function($key, &$value) {
			return ($value % 5 == 0 && $value % 7 == 0);
		}); // 34
		$this->assertEquals($ret, 34);
	}

	public function test_find_index_3() {
		// No callback
		$arr = range(1,100);
		$ret = enumerator::find_index_($arr, 50); // 49
		$this->assertEquals($ret, 49);
	}

	public function test_first_1() {
		// Test without $count
		$animals = array('cat', 'dog', 'cow', 'pig');
		enumerator::first_($animals);
		$this->assertEquals($animals, array('cat'));
	}

	public function test_first_2() {
		// With count
		$animals = array('cat', 'dog', 'cow', 'pig');
		enumerator::first_($animals, 2); // cat, dog
		$this->assertEquals($animals, array('cat', 'dog'));
	}

	public function test_collect_concat_1() {
		// Basic test
		$arr = array(array(1,2), array(3,4));
		enumerator::collect_concat_($arr, function($key, &$value) {
			return ++$value;
		});
		$this->assertEquals($arr, array(2,3,4,5));
	}

	public function test_grep_1() {
		// No callback
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		enumerator::grep_($arr, "/^snow/");
		$this->assertEquals($arr, array('snowball', 'snowcone', 'snowangel'));
	}
	public function test_grep_2() {
		// Destructive callback
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		enumerator::grep_($arr, "/^snow/", function($key, &$value) {
			$value .= '_';
			return;
		});
		$this->assertEquals($arr, array('snowball_', 'snowcone_', 'snowangel_'));
	}

	public function test_group_by_1() {
		// Basic test
		$arr = range(1,6);
		enumerator::group_by_($arr, function($key, &$value) {
			return ($value % 3);
		});
		$this->assertEquals($arr, array(array(3, 6), array(1, 4), array(2,5)));
	}

	public function test_member_1() {
		// Basic test
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		$ret = enumerator::member($arr, 'snowcone'); // true
		$this->assertEquals($ret, true);
	}

	public function test_member_2() {
		// Basic test
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		$ret = enumerator::member($arr, 'snowman'); // false
		$this->assertEquals($ret, false);
	}
	public function test_min_1() {
		// Basic test
		$array = array('albatross','dog','horse');
		$ret = enumerator::min($array); // albatross
		$this->assertEquals($ret, 'albatross');
	}

	public function test_min_2() {
		// Basic test
		$array = array('albatross','dog','horse');
		$ret = enumerator::min($array, function($val1, $val2) {
			return strcmp(strlen($val1), strlen($val2));
		}); // dog
		$this->assertEquals($ret, 'dog');
	}

	public function test_max_1() {
		// Basic test
		$array = array('albatross','dog','horse');
		$ret = enumerator::max($array); // horse
		$this->assertEquals($ret, 'horse');
	}

	public function test_max_2() {
		// Basic test
		$array = array('albatross','dog','horse');
		$ret = enumerator::max($array, function($val1, $val2) {
			return strcmp(strlen($val1), strlen($val2));
		}); // albatross
		$this->assertEquals($ret, 'albatross');
	}

	public function test_min_by_1() {
		$array = array('albatross','dog','horse'); 
		$ret = enumerator::min_by($array, function($val) { 
			return strlen($val); 
		}); // dog
		$this->assertEquals($ret, 'dog');
	}

	public function test_max_by_1() {
		$array = array('albatross','dog','horse');
		$ret = enumerator::max_by($array, function($val) {
			return strlen($val);
		}); // albatross
		$this->assertEquals($ret, 'albatross');
	}

	public function test_minmax_1() {
		$array = array('albatross','dog','horse'); 
		$ret = enumerator::minmax($array, function($val1, $val2) { 
			return strcmp(strlen($val1), strlen($val2));
		}); // array(dog, albatross)
		$this->assertEquals($ret, array('dog', 'albatross'));
	}

	public function test_minmax_by_1() {
		$array = array('albatross','dog','horse'); 
		$ret = enumerator::minmax_by($array, function($val) { 
			return strlen($val);
		}); // array(dog, albatross)
		$this->assertEquals($ret, array('dog', 'albatross'));
	}

	public function test_none_1() {
		$arr = array('ant', 'bear', 'cat');
		$ret = enumerator::none($arr, function($key, $value) {
			return (strlen($value) == 5);
		}); // true
		$this->assertEquals($ret, true);
	}

	public function test_none_2() {
		$arr = array('ant', 'bear', 'cat');
		$ret = enumerator::none($arr, function($key, $value) {
			return (strlen($value) >= 4);
		}); // false
		$this->assertEquals($ret, false);
	}

	public function test_none_3() {
		$ret = enumerator::none(array()); // true
		$this->assertEquals($ret, true);
	}

	public function test_none_4() {
		$ret = enumerator::none(array(null)); // true
		$this->assertEquals($ret, true);
	}

	public function test_none_5() {
		$ret = enumerator::none(array(null, false)); // true
		$this->assertEquals($ret, true);
	}

	public function test_one_1() {
		$array = array('ant','bear','cat');
		$ret = enumerator::one($array, function($key, $value) {
			return (strlen($value) == 4);
		}); // true
		$this->assertEquals($ret, true);
	}

	public function test_one_2() {
		$ret = enumerator::one(array(null, true, 99)); // false
		$this->assertEquals($ret, false);
	}

	public function test_one_3() {
		$ret = enumerator::one(array(null, true, false)); // true
		$this->assertEquals($ret, true);
	}

	public function test_partition_1() {
		$arr = range(1,6);
		enumerator::partition_($arr, function($key, $value) {
			return ($value % 2 == 0);
		});
		$this->assertEquals($arr, array(array(2,4,6), array(1,3,5)));
	}

	public function test_inject_1() {
		$arr = range(5, 10);
		$ret = enumerator::inject_($arr, function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$this->assertEquals($ret, 45);
	}

	public function test_inject_2() {
		$arr = range(5, 10);
		$ret = enumerator::inject_($arr, function($key, &$value, &$memo){
			$memo *= $value;
			return;
		}, 1); // 151200
		$this->assertEquals($ret, 151200);
	}

	public function test_rejct_1() {
		$arr = range(1,10);
		enumerator::reject_($arr, function($key, $value) {
			return ($value % 3 == 0);
		}); // [1, 2, 4, 5, 7, 8, 10]
		$this->assertEquals($arr, array(0=>1,1=>2,3=>4,4=>5,6=>7,7=>8,9=>10));
	}

	public function test_reverse_collect_1() {
		// Test destruction
		$arr = array(1, 2, 3);
		enumerator::reverse_collect_($arr, function($key, &$value) {
			$value *= 2;
			return;
		});
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_collect_2() {
		// Test destruction
		$arr = array(1, 2, 3);
		$index = 2;
		enumerator::reverse_collect_($arr, function($key, &$value) use(&$index) {
			$this->assertEquals($key, $index--);
			return;
		});
	}

	public function test_sort_1() {
		$arr = array('rhea', 'kea', 'flea');
		enumerator::sort_($arr); // [flea, kea, rhea]
		$this->assertEquals($arr, array('flea', 'kea', 'rhea'));
	}

	public function test_sort_2() {
		$arr = array('rhea', 'kea', 'flea');
		enumerator::sort_($arr, function($val1, $val2) {
			return strcmp($val2, $val1);
		});
		$this->assertEquals($arr, array('rhea', 'kea', 'flea'));
	}

	public function test_sort_by_1() {
		$arr = array('rhea', 'kea', 'flea');
		enumerator::sort_by_($arr, function($val) {
			return strlen($val);
		});
		$this->assertEquals($arr, array('kea', 'flea', 'rhea'));
	}

	public function test_take_while_1() {
		$arr = array(1,2,3,4,5,0);
		enumerator::take_while_($arr, function($key, &$value) {
			return ($value < 3);
		});
		$this->assertEquals($arr, array(1, 2));
	}

	public function test_zip_1() {
		$arr = array(1,2,3);
		enumerator::zip_($arr, array(4,5,6), array(7,8,9));
		$this->assertEquals($arr, array(array(1,4,7),array(2,5,8),array(3,6,9)));
	}

	public function test_zip_2() {
		$arr = array(1,2);
		enumerator::zip_($arr, array(4,5,6),array(7,8,9));
		$this->assertEquals($arr, array(array(1, 4, 7), array(2, 5, 8)));
	}

	public function test_zip_3() {
		$arr = array(4,5,6);
		enumerator::zip_($arr, array(1,2), array(8));
		$this->assertEquals($arr, array(array(4, 1, 8), array(5, 2, null), array(6, null, null)));
	}

	public function test_drop_while_1() {
		$arr = array(1,2,3,4,5,0);
		enumerator::drop_while_($arr, function($key, &$value) {
			return ($value < 3);
		});
		$this->assertEquals($arr, array(3,4,5,0));
	}

	public function test_cycle_1() {
		$i = 0;
		$arr = array(1,2,3);
		enumerator::cycle($arr, 3, function($key, $value, $it) use(&$i) {
			$i++;
		});
		$this->assertEquals($i, 9);
	}

	public function test_each_cons_1() {
		$arr = range(1,10);
		$follower = 0;
		$message = '';
		enumerator::each_cons_($arr, 3, function($key, $value, $leader) use (&$follower, &$message) {
			if($follower < $leader) {
				$message .= '||';
				$follower = $leader;
			}
			$message .= $value . ',';
		});
		$this->assertEquals($message, "1,2,3,||2,3,4,||3,4,5,||4,5,6,||5,6,7,||6,7,8,||7,8,9,||8,9,10,");
		$this->assertEquals($arr, array(array(1,2,3), array(2,3,4), array(3,4,5), array(4,5,6), array(5,6,7), array(6,7,8), array(7,8,9), array(8,9,10)));
	}

	public function test_slice_before_1() {
		$arr = array(1,2,3,4,5,6,7,8,9,0);
		enumerator::slice_before_($arr, "/[02468]/");
		$this->assertEquals($arr, array(array(1), array(2,3), array(4,5), array(6,7), array(8,9), array(0)));
	}

	public function test_merge_1() {
		$arr = array();
		$animals = array('dog', 'cat', 'pig');
		$trees = array('pine');
		$material = array('wool');
		enumerator::merge_($arr, $animals, $trees, $material);
		$this->assertEquals($arr, array('dog', 'cat', 'pig', 'pine', 'wool'));
	}

	public function test_rotate_1() {
		$arr = array('Foo', 'bar', 'foobar');
		enumerator::rotate_($arr, 1); // bar, foobar, Foo
		$this->assertEquals($arr, array('bar', 'foobar', 'Foo'));
	}

	public function test_rotate_2() {
		$arr = array('Foo', 'bar', 'foobar');
		enumerator::rotate_($arr, -1); // foobar, Foo, bar
		$this->assertEquals($arr, array('foobar', 'Foo', 'bar'));
	}

	public function test_reverse() {
		$arr = array(1,2,3);
		enumerator::reverse_($arr);
		$this->assertEquals($arr, array(3,2,1));
	}

	public function test_random_1() {
		$arr = array('pig', 'cow', 'dog', 'horse');
		enumerator::random_($arr);
		$this->assertInternalType('string', $arr);
		$this->assertContains($arr, array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_random_2() {
		$arr = array('pig', 'cow', 'dog', 'horse');
		enumerator::random_($arr, 2);
		$this->assertInternalType('array', $arr);
		$this->assertEquals(count($arr), 2);
		$this->assertContains($arr[0], array('pig', 'cow', 'dog', 'horse'));
		$this->assertContains($arr[1], array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_shuffle_1() {
		// How do you test random values?
		// There must be a better way...
		$arr = array(1,2,3);
		enumerator::shuffle_($arr);
		$this->assertContains(1, $arr);
		$this->assertContains(2, $arr);
		$this->assertContains(3, $arr);
	}

	public function test_shuffle_2() {
		// How do you test random values?
		// There must be a better way...
		$arr = array('a' => 'apple', 'b' => 'banana', 'c' => 'carrot');
		enumerator::shuffle_($arr, true);
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
		enumerator::values_at_($name, 'title', 'last'); // ['title' => 'Dr.', 'last' => 'Doe'];
		$this->assertEquals($name, array('title'=>'Dr.', 'last' => 'Doe'));
	}

	public function test_empty_1() {
		$arr = array();
		$ret = enumerator::isEmpty($arr);
		$this->assertEquals($ret, true);
	}

	public function test_empty_2() {
		$arr = array(1,2,3);
		$ret = enumerator::isEmpty($arr);
		$this->assertEquals($ret, false);
	}

	public function test_has_value_1() {
		$arr = array(0,false);
		$ret = enumerator::has_value($arr, null); // false
		$this->assertEquals($ret, false);
	}

	public function test_has_value_2() {
		$arr = array(false,null);
		$ret = enumerator::has_value($arr, 0); // false
		$this->assertEquals($ret, false);
	}

	public function test_has_value_3() {
		$arr = array('apple', 'banana', 'orange');
		$ret = enumerator::has_value($arr, 'orange'); // true
		$this->assertEquals($ret, true);
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
		$ret = enumerator::index_($name, 'John');
		$this->assertEquals($ret, 'first');
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
		$ret = enumerator::index_($name, function($key, &$value) {
			return (strpos($value, '.') !== false); // Has a decimal
		});
		$this->assertEquals($ret, 'title');
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
		$ret = enumerator::rindex_($name, 'John');
		$this->assertEquals($ret, 'first');
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
		$ret = enumerator::rindex_($name, function($key, &$value) {
			return (strpos($value, '.') !== false);
		});
		$this->assertEquals($ret, 'suffix');
	}

	public function test_compact_1() {
		$arr = array(1,2,3,null,array(2,3,4,null));
		enumerator::compact_($arr);
		$this->assertEquals($arr, array(1,2,3,4=>array(2,3,4,null)));
	}

	public function test_compact_2() {
		$arr = array(1,2,3,null,array(2,3,4,null));
		enumerator::compact_($arr, true);
		$this->assertEquals($arr, array(1,2,3,4=>array(2,3,4)));
	}

	public function test_uniq_1() {
		$arr = array(1,1,2,3,3,2,1,1,1);
		enumerator::uniq_($arr);
		$this->assertEquals($arr, array(0=>1,2=>2,3=>3));
	}

	public function test_assoc_1() {
		$s1 = array('color', 'red', 'blue', 'green');
		$s2 = array('letters', 'a', 'b', 'c');
		$s3 = 'foo';
		$arr = array($s1, $s2, $s3);
		$o = enumerator::assoc($arr, 'letters');
		$this->assertEquals($o, $s2);
	}

	public function test_assoc_2() {
		$s1 = array('color', 'red', 'blue', 'green');
		$s2 = array('letters', 'a', 'b', 'c');
		$s3 = 'foo';
		$arr = array($s1, $s2, $s3);
		$o = enumerator::assoc($arr, 'foo');
		$this->assertEquals($o, null);
	}

	public function test_rassoc_1() {
		$arr = array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two"));
		$o = enumerator::rassoc($arr, 'two');
		$this->assertEquals($o, array(2, 'two'));
	}

	public function test_rassoc_2() {
		$arr = array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two"));
		$o = enumerator::rassoc($arr, 'four');
		$this->assertEquals($o, null);
	}

	public function test_at_1() {
		$arr = array('a', 'b', 'c', 'd', 'e');
		$o = enumerator::at($arr, 0);
		$this->assertEquals($o, 'a');
	}

	public function test_at_2() {
		$arr = array('a', 'b', 'c', 'd', 'e');
		$o = enumerator::at($arr, -1);
		$this->assertEquals($o, 'e');
	}

	public function test_at_3() {
		$arr = array('a', 'b', 'c', 'd', 'e');
		$o = enumerator::at($arr, 0, 3, 4);
		$this->assertEquals($o, array('a', 'd', 'e'));
	}

	public function test_combination_1() {
		$arr = array(1, 2, 3, 4);
		enumerator::combination_($arr, 1);
		$this->assertEquals($arr, array(array(1), array(2), array(3), array(4)));
	}

	public function test_combination_2() {
		$arr = array(1, 2, 3, 4);
		enumerator::combination_($arr, 4);
		$this->assertEquals($arr, array(array(1,2,3,4)));
	}

	public function test_combination_3() {
		$arr = array(1, 2, 3, 4);
		enumerator::combination_($arr, 0);
		$this->assertEquals($arr, array(array()));
	}

	public function test_combinatoin_4() {
		// tests destructive
		$arr = array(1, 2, 3, 4);
		enumerator::combination_($arr, 4, function($key, &$value) {
			foreach($value as &$v) {
				$v++;
			}
		});
		$this->assertEquals($arr, array(array(2,3,4,5)));
	}

	public function test_delete_1() {
		$arr = array('a','b', 'b', 'b', 'c');
		$ret = enumerator::delete_($arr, 'b');
		$this->assertEquals($ret, 'b');
		$this->assertEquals($arr, array(0 => 'a', 4 => 'c'));
	}

	public function test_delete_2() {
		$arr = array('a','b', 'b', 'b', 'c');
		$ret = enumerator::delete_($arr, 'z');
		$this->assertEquals($ret, null);
		$this->assertEquals($arr, array('a','b', 'b', 'b', 'c'));
	}

	public function test_delete_3() {
		$arr = array('a','b', 'b', 'b', 'c');
		$ret = enumerator::delete_($arr, 'z', function() {
			return false;
		});
		$this->assertEquals($ret, false);
		$this->assertEquals($arr, array('a','b', 'b', 'b', 'c'));
	}

	public function test_delete_at_1() {
		$arr = array('ant', 'bat', 'cat', 'dog');
		$ret = enumerator::delete_at_($arr, 2);
		$this->assertEquals($ret, 'cat');
		$this->assertEquals($arr, array(0 => 'ant', 1 => 'bat', 3 => 'dog'));
	}

	public function test_delete_at_2() {
		$arr = array('ant', 'bat', 'cat', 'dog');
		$ret = enumerator::delete_at_($arr, 99);
		$this->assertEquals($ret, null);
	}

	public function test_fetch_1() {
		$arr = array(11, 22, 33, 44);
		$ret = enumerator::fetch($arr, 1);
		$this->assertEquals($ret, 22);
	}

	public function test_fetch_2() {
		$arr = array(11, 22, 33, 44);
		$ret = enumerator::fetch($arr, -1);
		$this->assertEquals($ret, 44);
	}

	public function test_fetch_3() {
		$arr = array(11, 22, 33, 44);
		$ret = enumerator::fetch($arr, 4, 'cat');
		$this->assertEquals($ret, 'cat');
	}

	public function test_fetch_4() {
		$arr = array(11, 22, 33, 44);
		$ret = enumerator::fetch($arr, 4, function($i) {
			return $i * $i;
		});
		$this->assertEquals($ret, 16);
	}

	public function test_fetch_5() {
		$arr = array(11, 22, 33, 44);
		try {
			$ret = enumerator::fetch($arr, 4);
		} catch(\OutOfBoundsException $e) {
			// Testing the catch
			$this->assertEquals(true, true);
			return;
		}
		$this->assertEquals(true, false);
	}

	public function test_flatten_1() {
		$arr = array(1, 2, array(3, array(4, 5)));
		enumerator::flatten_($arr);
		$this->assertEquals($arr, array(1,2,3,4,5));

		$ret = enumerator::flatten_($arr);
		$this->assertEquals($ret, null);
	}

	public function test_flatten_2() {
		$arr = array(1, 2, array(3, array(4, 5)));
		enumerator::flatten_($arr, 1);
		$this->assertEquals($arr, array(1,2,3, array(4,5)));
	}

}