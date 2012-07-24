<?php

/*
	Will test the __call on PrettyArray which redirects to enumerator.
*/

class prettyArrayEnumeratorTest extends PHPUnit_Framework_TestCase {

	public function pretty_all() {
		// Callback testing
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $animals->all_(function($key, $value) {
			return (strlen($value) >= 3);
		});
		$this->assertEquals($ret, true);
	}

	public function test_all_2() {
		// Callback testing 2
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $animals->all_(function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals($ret, false);
	}

	public function test_all_3() {
		// Destructive testing
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$animals->all_(function($key, &$value) {
			$value .= '_';
			return true;
		});
		$animals = $animals->to_a();
		$this->assertEquals($animals, array('ant_', 'bear_', 'cat_'));
	}

	public function test_all_4() {
		// Without callback test
		$arr = new PrettyArray(array(null, true, 99));
		$ret = $arr->all_();
		$arr = $arr->to_a();
		$this->assertEquals($ret, false);
	}

	public function test_drop_1() {
		// Normal value
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$animals->drop_(1);
		$animals = $animals->to_a();
		$this->assertEquals($animals, array('bear', 'cat'));
	}

	public function test_drop_2() {
		// High Value
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$animals->drop_(6);
		$animals = $animals->to_a();
		$this->assertEquals($animals, array());
	}

	public function test_any_1() {
		// Callback 1
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $animals->any_(function($key, $value) {
			return (strlen($value) >= 3);
		});
		$this->assertEquals($ret, true);
	}

	public function test_any_2() {
		// Callback 2
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $animals->any_(function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals($ret, true);
	}

	public function test_any_3() {
		// Destructive
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$animals->any_(function($key, &$value) {
			$value .= '_';
			return false;
		});
		$animals = $animals->to_a();
		$this->assertEquals($animals, array('ant_', 'bear_', 'cat_'));
	}

	public function test_any_4() {
		// No callback 1
		$arr = new PrettyArray(array(null, true, 99));
		$ret = $arr->any_();
		$this->assertEquals($ret, true);
	}

	public function test_collect_1() {
		// Editing 1
		$arr = new PrettyArray(range(1,4));
		$arr->collect_(function($key, &$value) {
			$value *= $value;
			return;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(1, 4, 9, 16));
	}

	public function test_collect_2() {
		// Editing 2
		$arr = new PrettyArray(range(1,4));
		$arr->collect_(function($key, &$value) {
			$value = "cat";
			return;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array("cat", "cat", "cat", "cat"));
	}

	public function test_count_1() {
		// Basic count
		$arr = new PrettyArray(array(1,2,4,2));
		$ret = $arr->count_();
		$this->assertEquals($ret, 4);
	}

	public function test_count_2() {
		// Counting specific values
		$arr = new PrettyArray(array(1,2,4,2));
		$ret = $arr->count_(2);
		$this->assertEquals($ret, 2);
	}

	public function test_count_3() {
		// Count all true values based on callback return value
		$arr = new PrettyArray(array(1,2,4,2));
		$ret = $arr->count_(function($key, &$value) {
			return ($value % 2 == 0);
		});
		$this->assertEquals($ret, 3);
	}

	public function test_count_4() {
		// Testing destructive callback
		$arr = new PrettyArray(array(1,2,4,2));
		$arr->count_(function($key, &$value) {
			$value *= 2;
			return true;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,8, 4));
	}

	public function test_detect_1() {
		// Callback 1
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->detect_(function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, null);
	}

	public function test_detect_2() {
		// Callback 2
		$arr = new PrettyArray(range(1,100));
		$ret = $arr->detect_(function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, 35);
	}

	public function test_detect_3() {
		// Destructive
		$arr = new PrettyArray(range(1,3));
		$arr->detect_(function($key, &$value) {
			$value *= 2;
			return false;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_select_1() {
		// Basic
		$arr = new PrettyArray(range(1,10));
		$arr->select_(function($key, $value) {
			return ($value % 3 == 0);
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}

	public function test_select_2() {
		// Destructive
		$arr = new PrettyArray(range(1,3));
		$arr->select_(function($key, &$value) {
			$value *= 2;
			return true;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_each_slice_1() {
		// Basic
		$arr = new PrettyArray(range(1,10));
		$arr->each_slice_(3, function(&$collection) {
			foreach($collection as $key => &$value) ++$value;
			return;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(array(2,3,4), array(5,6,7), array(8,9,10), array(11)));
	}

	public function test_find_index_1() {
		// Can't find value
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->find_index_(function($key, $value) {
			return ($value % 5 == 0 && $value % 7 == 0);
		}); // null
		$this->assertEquals($ret, null);
	}

	public function test_find_index_2() {
		// Finds value
		$arr = new PrettyArray(range(1,100));
		$ret = $arr->find_index_(function($key, &$value) {
			return ($value % 5 == 0 && $value % 7 == 0);
		}); // 34
		$this->assertEquals($ret, 34);
	}

	public function test_find_index_3() {
		// No callback
		$arr = new PrettyArray(range(1,100));
		$ret = $arr->find_index_(50); // 49
		$this->assertEquals($ret, 49);
	}

	public function test_first_1() {
		// Test without $count
		$animals = new PrettyArray(array('cat', 'dog', 'cow', 'pig'));
		$animals->first_();
		$animals = $animals->to_a();
		$this->assertEquals($animals, array('cat'));
	}

	public function test_first_2() {
		// With count
		$animals = new PrettyArray(array('cat', 'dog', 'cow', 'pig'));
		$animals->first_(2); // cat, dog
		$animals = $animals->to_a();
		$this->assertEquals($animals, array('cat', 'dog'));
	}

	public function test_collect_concat_1() {
		// Basic test
		$arr = new PrettyArray(array(array(1,2), array(3,4)));
		$arr->collect_concat_(function($key, &$value) {
			return ++$value;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,3,4,5));
	}

	public function test_grep_1() {
		// No callback
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$arr->grep_("/^snow/");
		$arr = $arr->to_a();
		$this->assertEquals($arr, array('snowball', 'snowcone', 'snowangel'));
	}
	public function test_grep_2() {
		// Destructive callback
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$arr->grep_("/^snow/", function($key, &$value) {
			$value .= '_';
			return;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array('snowball_', 'snowcone_', 'snowangel_'));
	}

	public function test_group_by_1() {
		// Basic test
		$arr = new PrettyArray(range(1,6));
		$arr->group_by_(function($key, &$value) {
			return ($value % 3);
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(array(3, 6), array(1, 4), array(2,5)));
	}

	public function test_member_1() {
		// Basic test
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->member('snowcone'); // true
		$this->assertEquals($ret, true);
	}

	public function test_member_2() {
		// Basic test
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->member('snowman'); // false
		$this->assertEquals($ret, false);
	}
	public function test_min_1() {
		// Basic test
		$array = new PrettyArray(array('albatross','dog','horse'));
		$ret = $array->min(); // albatross
		$this->assertEquals($ret, 'albatross');
	}

	public function test_min_2() {
		// Basic test
		$array = new PrettyArray(array('albatross','dog','horse'));
		$ret = $array->min(function($val1, $val2) {
			return strcmp(strlen($val1), strlen($val2));
		}); // dog
		$this->assertEquals($ret, 'dog');
	}

	public function test_max_1() {
		// Basic test
		$array = new PrettyArray(array('albatross','dog','horse'));
		$ret = $array->max(); // horse
		$this->assertEquals($ret, 'horse');
	}

	public function test_max_2() {
		// Basic test
		$array = new PrettyArray(array('albatross','dog','horse'));
		$ret = $array->max(function($val1, $val2) {
			return strcmp(strlen($val1), strlen($val2));
		}); // albatross
		$this->assertEquals($ret, 'albatross');
	}

	public function test_min_by_1() {
		$array = new PrettyArray(array('albatross','dog','horse')); 
		$ret = $array->min_by(function($val) { 
			return strlen($val); 
		}); // dog
		$this->assertEquals($ret, 'dog');
	}

	public function test_max_by_1() {
		$array = new PrettyArray(array('albatross','dog','horse'));
		$ret = $array->max_by(function($val) {
			return strlen($val);
		}); // albatross
		$this->assertEquals($ret, 'albatross');
	}

	public function test_minmax_1() {
		$array = new PrettyArray(array('albatross','dog','horse')); 
		$ret = $array->minmax(function($val1, $val2) { 
			return strcmp(strlen($val1), strlen($val2));
		}); // array(dog, albatross)
		$this->assertEquals($ret->to_a(), array('dog', 'albatross'));
	}

	public function test_minmax_by_1() {
		$array = new PrettyArray(array('albatross','dog','horse')); 
		$ret = $array->minmax_by(function($val) { 
			return strlen($val);
		}); // array(dog, albatross)
		$this->assertEquals($ret->to_a(), array('dog', 'albatross'));
	}

	public function test_none_1() {
		$arr = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $arr->none(function($key, $value) {
			return (strlen($value) == 5);
		}); // true
		$this->assertEquals($ret, true);
	}

	public function test_none_2() {
		$arr = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $arr->none(function($key, $value) {
			return (strlen($value) >= 4);
		}); // false
		$this->assertEquals($ret, false);
	}

	public function test_none_3() {
		$arr = new PrettyArray();
		$ret = $arr->none(); // true
		$this->assertEquals($ret, true);
	}

	public function test_none_4() {
		$arr = new PrettyArray(array(null));
		$ret = $arr->none(); // true
		$this->assertEquals($ret, true);
	}

	public function test_none_5() {
		$arr = new PrettyArray(array(null, false));
		$ret = $arr->none(); // true
		$this->assertEquals($ret, true);
	}

	public function test_one_1() {
		$array = new PrettyArray(array('ant','bear','cat'));
		$ret = $array->one(function($key, $value) {
			return (strlen($value) == 4);
		}); // true
		$this->assertEquals($ret, true);
	}

	public function test_one_2() {
		$arr = new PrettyArray(array(null, true, 99));
		$ret = $arr->one(); // false
		$this->assertEquals($ret, false);
	}

	public function test_one_3() {
		$arr = new PrettyArray(array(null, true, false));
		$ret = $arr->one(); // true
		$this->assertEquals($ret, true);
	}

	public function test_partition_1() {
		$arr = new PrettyArray(range(1,6));
		$arr->partition_(function($key, $value) {
			return ($value % 2 == 0);
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(array(2,4,6), array(1,3,5)));
	}

	public function test_inject_1() {
		$arr = new PrettyArray(range(5, 10));
		$ret = $arr->inject_(function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$arr = $arr->to_a();
		$this->assertEquals($ret, 45);
	}

	public function test_inject_2() {
		$arr = new PrettyArray(range(5, 10));
		$ret = $arr->inject_(function($key, &$value, &$memo){
			$memo *= $value;
			return;
		}, 1); // 151200
		$arr = $arr->to_a();
		$this->assertEquals($ret, 151200);
	}

	public function test_rejct_1() {
		$arr = new PrettyArray(range(1,10));
		$arr->reject_(function($key, $value) {
			return ($value % 3 == 0);
		}); // [1, 2, 4, 5, 7, 8, 10]
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(0=>1,1=>2,3=>4,4=>5,6=>7,7=>8,9=>10));
	}

	public function test_reverse_collect_1() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$arr->reverse_collect_(function($key, &$value) {
			$value *= 2;
			return;
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(2,4,6));
	}

	public function test_reverse_collect_2() {
		// Test destruction
		$arr = new PrettyArray(array(1, 2, 3));
		$index = 2;
		$arr->reverse_collect_(function($key, &$value) use(&$index) {
			$this->assertEquals($key, $index--);
			return;
		});
	}

	public function test_sort_1() {
		$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
		$arr->sort_(); // [flea, kea, rhea]
		$arr = $arr->to_a();
		$this->assertEquals($arr, array('flea', 'kea', 'rhea'));
	}

	public function test_sort_2() {
		$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
		$arr->sort_(function($val1, $val2) {
			return strcmp($val2, $val1);
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array('rhea', 'kea', 'flea'));
	}

	public function test_sort_by_1() {
		$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
		$arr->sort_by_(function($val) {
			return strlen($val);
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array('kea', 'flea', 'rhea'));
	}

	public function test_take_while_1() {
		$arr = new PrettyArray(array(1,2,3,4,5,0));
		$arr->take_while_(function($key, &$value) {
			return ($value < 3);
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(1, 2));
	}

	public function test_zip_1() {
		$arr = new PrettyArray(array(1,2,3));
		$arr->zip_(array(4,5,6), array(7,8,9));
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(array(1,4,7),array(2,5,8),array(3,6,9)));
	}

	public function test_zip_2() {
		$arr = new PrettyArray(array(1,2));
		$arr->zip_(array(4,5,6),array(7,8,9));
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(array(1, 4, 7), array(2, 5, 8)));
	}

	public function test_zip_3() {
		$arr = new PrettyArray(array(4,5,6));
		$arr->zip_(array(1,2), array(8));
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(array(4, 1, 8), array(5, 2, null), array(6, null, null)));
	}

	public function test_drop_while_1() {
		$arr = new PrettyArray(array(1,2,3,4,5,0));
		$arr->drop_while_(function($key, &$value) {
			return ($value < 3);
		});
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(3,4,5,0));
	}

	public function test_cycle_1() {
		$i = 0;
		$arr = new PrettyArray(array(1,2,3));
		$arr->cycle(3, function($key, $value, $it) use(&$i) {
			$i++;
		});
		$arr = $arr->to_a();
		$this->assertEquals($i, 9);
	}

	public function test_each_cons_1() {
		$arr = new PrettyArray(range(1,10));
		$follower = 0;
		$message = '';
		$arr->each_cons_(3, function($key, $value, $leader) use (&$follower, &$message) {
			if($follower < $leader) {
				$message .= '||';
				$follower = $leader;
			}
			$message .= $value . ',';
		});
		$arr = $arr->to_a();
		$this->assertEquals($message, "1,2,3,||2,3,4,||3,4,5,||4,5,6,||5,6,7,||6,7,8,||7,8,9,||8,9,10,");
		$this->assertEquals($arr, array(array(1,2,3), array(2,3,4), array(3,4,5), array(4,5,6), array(5,6,7), array(6,7,8), array(7,8,9), array(8,9,10)));
	}

	public function test_slice_before_1() {
		$arr = new PrettyArray(array(1,2,3,4,5,6,7,8,9,0));
		$arr->slice_before_("/[02468]/");
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(array(1), array(2,3), array(4,5), array(6,7), array(8,9), array(0)));
	}

	public function test_merge() {
		$arr = new PrettyArray();
		$animals = array('dog', 'cat', 'pig');
		$trees = array('pine');
		$material = array('wool');
		$arr->merge_($animals, $trees, $material);
		$arr = $arr->to_a();
		$this->assertEquals($arr, array('dog', 'cat', 'pig', 'pine', 'wool'));
	}

	public function test_rotate_1() {
		$arr = new PrettyArray(array('Foo', 'bar', 'foobar'));
		$arr->rotate_(1); // bar, foobar, Foo
		$arr = $arr->to_a();
		$this->assertEquals($arr, array('bar', 'foobar', 'Foo'));
	}

	public function test_rotate_2() {
		$arr = new PrettyArray(array('Foo', 'bar', 'foobar'));
		$arr->rotate_(-1); // foobar, Foo, bar
		$arr = $arr->to_a();
		$this->assertEquals($arr, array('foobar', 'Foo', 'bar'));
	}

	public function test_reverse() {
		$arr = new PrettyArray(array(1,2,3));
		$arr->reverse_();
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(3,2,1));
	}

	public function test_random_1() {
		$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
		$arr->random_();
		$arr = $arr->to_a();
		$this->assertInternalType('string', $arr);
		$this->assertContains($arr, array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_random_2() {
		$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
		$arr->random_(2);
		$arr = $arr->to_a();
		$this->assertInternalType('array', $arr);
		$this->assertEquals(count($arr), 2);
		$this->assertContains($arr[0], array('pig', 'cow', 'dog', 'horse'));
		$this->assertContains($arr[1], array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_shuffle_1() {
		// How do you test random values?
		// There must be a better way...
		$arr = new PrettyArray(array(1,2,3));
		$arr->shuffle_();
		$arr = $arr->to_a();
		$this->assertContains(1, $arr);
		$this->assertContains(2, $arr);
		$this->assertContains(3, $arr);
	}

	public function test_shuffle_2() {
		// How do you test random values?
		// There must be a better way...
		$arr = new PrettyArray(array('a' => 'apple', 'b' => 'banana', 'c' => 'carrot'));
		$arr->shuffle_(true);
		$arr = $arr->to_a();
		$this->assertArrayHasKey('a', $arr);
		$this->assertArrayHasKey('b', $arr);
		$this->assertArrayHasKey('c', $arr);
	}

	public function test_values_at_1() {
		$name = new PrettyArray(array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.'
		));
		$name->values_at_('title', 'last'); // ['title' => 'Dr.', 'last' => 'Doe'];
		$name = $name->to_a();
		$this->assertEquals($name, array('title'=>'Dr.', 'last' => 'Doe'));
	}

	public function test_empty_1() {
		$arr = new PrettyArray(array());
		$ret = $arr->isEmpty();
		$this->assertEquals($ret, true);
	}

	public function test_empty_2() {
		$arr = new PrettyArray(array(1,2,3));
		$ret = $arr->isEmpty();
		$this->assertEquals($ret, false);
	}

	public function test_has_value_1() {
		$arr = new PrettyArray(array(0,false));
		$ret = $arr->has_value(null); // false
		$this->assertEquals($ret, false);
	}

	public function test_has_value_2() {
		$arr = new PrettyArray(array(false,null));
		$ret = $arr->has_value(0); // false
		$this->assertEquals($ret, false);
	}

	public function test_has_value_3() {
		$arr = new PrettyArray(array('apple', 'banana', 'orange'));
		$ret = $arr->has_value('orange'); // true
		$this->assertEquals($ret, true);
	}

	public function test_index_1() {
		$name = new PrettyArray(array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		));
		$ret = $name->index('John');
		$this->assertEquals($ret, 'first');
	}

	public function test_index_2() {
		$name = new PrettyArray(array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		));
		$ret = $name->index(function($key, &$value) {
			return (strpos($value, '.') !== false); // Has a decimal
		});
		$this->assertEquals($ret, 'title');
	}

	public function test_rindex_1() {
		$name = new PrettyArray(array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		));
		$ret = $name->rindex('John');
		$this->assertEquals($ret, 'first');
	}

	public function test_rindex_2() {
		$name = new PrettyArray(array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		));
		$ret = $name->rindex_(function($key, &$value) {
			return (strpos($value, '.') !== false);
		});
		$this->assertEquals($ret, 'suffix');
	}

	public function test_compact_1() {
		$arr = new PrettyArray(array(1,2,3,null,array(2,3,4,null)));
		$arr->compact_();
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(1,2,3,4=>array(2,3,4,null)));
	}

	public function test_compact_2() {
		$arr = new PrettyArray(array(1,2,3,null,array(2,3,4,null)));
		$arr->compact_(true);
		$arr = $arr->to_a();
		$this->assertEquals($arr, array(1,2,3,4=>array(2,3,4)));
	}

	public function test_uniq_1() {
		$arr = new PrettyArray(array(1,1,2,3,3,2,1,1,1));
		$arr->uniq_();
		$o = $arr->to_a();
		$this->assertEquals($o, array(0=>1,2=>2,3=>3));
	}

	public function test_assoc_1() {
		$s1 = array('color', 'red', 'blue', 'green');
		$s2 = array('letters', 'a', 'b', 'c');
		$s3 = 'foo';
		$arr = new PrettyArray(array($s1, $s2, $s3));
		$o = $arr->assoc('letters');
		$this->assertEquals($o->to_a(), $s2);
	}

	public function test_assoc_2() {
		$s1 = array('color', 'red', 'blue', 'green');
		$s2 = array('letters', 'a', 'b', 'c');
		$s3 = 'foo';
		$arr = new PrettyArray(array($s1, $s2, $s3));
		$o = $arr->assoc('foo');
		$this->assertEquals($o, null);
	}

	public function test_rassoc_1() {
		$arr = new PrettyArray(array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two")));
		$o = $arr->rassoc('two')->to_a();
		$this->assertEquals($o, array(2, 'two'));
	}

	public function test_rassoc_2() {
		$arr = new PrettyArray(array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two")));
		$o = $arr->rassoc('four');
		$this->assertEquals($o, null);
	}

}