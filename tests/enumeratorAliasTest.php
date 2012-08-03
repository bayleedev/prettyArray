<?php

/*

	Tests all non-destructive aliases in enumerator

	This all goes through the same method enumerator::__callStatic so only a handfull of items will be tested.

*/
class enumeratorAliasTest extends PHPUnit_Framework_TestCase {

	public function test_array_slice() {
		// Normal value
		$animals = array('ant', 'bear', 'cat');
		$animals = enumerator::array_slice($animals, 1);
		$this->assertEquals($animals, array('bear', 'cat'));
	}

	public function test_drop() {
		// Normal value
		$animals = array('ant', 'bear', 'cat');
		$animals = enumerator::drop($animals, 1);
		$this->assertEquals($animals, array('bear', 'cat'));
	}

	public function test_find_all() {
		// Basic
		$arr = range(1,10);
		$arr = enumerator::find_all($arr,function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}

	public function test_keep_if() {
		// Basic
		$arr = range(1,10);
		$arr = enumerator::keep_if($arr,function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}

	public function test_select() {
		// Basic
		$arr = range(1,10);
		$arr = enumerator::select($arr,function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}

	public function test_reduce() {
		$arr = range(5, 10);
		$ret = enumerator::reduce($arr, function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$this->assertEquals($ret, 45);
	}

	public function test_inject() {
		$arr = range(5, 10);
		$ret = enumerator::inject($arr, function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$this->assertEquals($ret, 45);
	}

	public function test_include() {
		$fun = 'include';
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		$ret = enumerator::$fun($arr, 'snowcone'); // true
		$this->assertEquals($ret, true);
	}

	public function test_member() {
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		$ret = enumerator::member($arr, 'snowcone'); // true
		$this->assertEquals($ret, true);
	}

	public function test_flat_map() {
		// Basic test
		$arr = array(array(1,2), array(3,4));
		$arr = enumerator::flat_map($arr, function($key, &$value) {
			return ++$value;
		});
		$this->assertEquals($arr, array(2,3,4,5));
	}

	public function test_collect_concat() {
		// Basic test
		$arr = array(array(1,2), array(3,4));
		$arr = enumerator::collect_concat($arr, function($key, &$value) {
			return ++$value;
		});
		$this->assertEquals($arr, array(2,3,4,5));
	}

	public function test_take() {
		// Test without $count
		$animals = array('cat', 'dog', 'cow', 'pig');
		$animals = enumerator::take($animals);
		$this->assertEquals($animals, array('cat'));
	}

	public function test_first() {
		// Test without $count
		$animals = array('cat', 'dog', 'cow', 'pig');
		$animals = enumerator::first($animals);
		$this->assertEquals($animals, array('cat'));
	}

	public function test_find() {
		// Callback 1
		$arr = range(1,10);
		$ret = enumerator::find($arr, function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, null);
	}

	public function test_detect() {
		// Callback 1
		$arr = range(1,10);
		$ret = enumerator::detect($arr, function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, null);
	}

	public function test_size() {
		// Counting specific values
		$arr = array(1,2,4,2);
		$ret = enumerator::size($arr, 2);
		$this->assertEquals($ret, 2);
	}

	public function test_length() {
		// Counting specific values
		$arr = array(1,2,4,2);
		$ret = enumerator::length($arr, 2);
		$this->assertEquals($ret, 2);
	}

	public function test_count() {
		// Counting specific values
		$arr = array(1,2,4,2);
		$ret = enumerator::count($arr, 2);
		$this->assertEquals($ret, 2);
	}

	public function test_array_walk() {
		// Editing 1
		$arr = range(1,4);
		$arr = enumerator::array_walk($arr, function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($arr, array(1, 4, 9, 16));
	}

	public function test_each() {
		// Editing 1
		$arr = range(1,4);
		$arr = enumerator::each($arr, function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($arr, array(1, 4, 9, 16));
	}

	public function test_map() {
		// Editing 1
		$arr = range(1,4);
		$arr = enumerator::map($arr, function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($arr, array(1, 4, 9, 16));
	}

	public function test_foreach() {
		// Editing 1
		$fun = 'foreach';
		$arr = range(1,4);
		$arr = enumerator::$fun($arr, function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($arr, array(1, 4, 9, 16));
	}

	public function test_each_with_index() {
		// Editing 1
		$arr = range(1,4);
		$arr = enumerator::each_with_index($arr, function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($arr, array(1, 4, 9, 16));
	}

	public function test_collect() {
		// Editing 1
		$arr = range(1,4);
		$arr = enumerator::collect($arr, function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($arr, array(1, 4, 9, 16));
	}

	public function test_reverse_map() {
		$arr = array(1, 2, 3);
		$index = 2;
		$arr2 = enumerator::reverse_map($arr, function($key, &$value) {
			$value = 'cat';
			return;
		});
		$this->assertEquals($arr, array(1, 2, 3));
		$this->assertEquals($arr2, array('cat','cat','cat'));
	}

	public function test_reverse_foreach() {
		$arr = array(1, 2, 3);
		$index = 2;
		$arr2 = enumerator::reverse_foreach($arr, function($key, &$value) {
			$value = 'cat';
			return;
		});
		$this->assertEquals($arr, array(1, 2, 3));
		$this->assertEquals($arr2, array('cat','cat','cat'));
	}

	public function test_reverse_each_with_index() {
		$arr = array(1, 2, 3);
		$index = 2;
		$arr2 = enumerator::reverse_each_with_index($arr, function($key, &$value) {
			$value = 'cat';
			return;
		});
		$this->assertEquals($arr, array(1, 2, 3));
		$this->assertEquals($arr2, array('cat','cat','cat'));
	}

	public function test_reverse_collect() {
		$arr = array(1, 2, 3);
		$index = 2;
		$arr2 = enumerator::reverse_collect($arr, function($key, &$value) {
			$value = 'cat';
			return;
		});
		$this->assertEquals($arr, array(1, 2, 3));
		$this->assertEquals($arr2, array('cat','cat','cat'));
	}

	public function test_concat() {
		$arr = array();
		$animals = array('dog', 'cat', 'pig');
		$trees = array('pine');
		$material = array('wool');
		$arr = enumerator::concat($arr, $animals, $trees, $material);
		$this->assertEquals($arr, array('dog', 'cat', 'pig', 'pine', 'wool'));
	}


	public function test_merge() {
		$arr = array();
		$animals = array('dog', 'cat', 'pig');
		$trees = array('pine');
		$material = array('wool');
		$arr = enumerator::merge($arr, $animals, $trees, $material);
		$this->assertEquals($arr, array('dog', 'cat', 'pig', 'pine', 'wool'));
	}

	public function test_sample() {
		$arr = array('pig', 'cow', 'dog', 'horse');
		$arr = enumerator::sample($arr);
		$this->assertInternalType('string', $arr);
		$this->assertContains($arr, array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_random() {
		$arr = array('pig', 'cow', 'dog', 'horse');
		$arr = enumerator::random($arr);
		$this->assertInternalType('string', $arr);
		$this->assertContains($arr, array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_usort() {
		$arr = array('rhea', 'kea', 'flea');
		$arr =enumerator::usort($arr, function($val1, $val2) {
			return strcmp($val2, $val1);
		});
		$this->assertEquals($arr, array('rhea', 'kea', 'flea'));
	}

	public function test_sort() {
		$arr = array('rhea', 'kea', 'flea');
		$arr =enumerator::sort($arr, function($val1, $val2) {
			return strcmp($val2, $val1);
		});
		$this->assertEquals($arr, array('rhea', 'kea', 'flea'));
	}

	public function test_delete_if() {
		$arr = range(1,10);
		$arr = enumerator::delete_if($arr, function($key, $value) {
			return ($value % 3 == 0);
		}); // [1, 2, 4, 5, 7, 8, 10]
		$this->assertEquals($arr, array(0=>1,1=>2,3=>4,4=>5,6=>7,7=>8,9=>10));
	}

	public function test_reject() {
		$arr = range(1,10);
		$arr = enumerator::reject($arr, function($key, $value) {
			return ($value % 3 == 0);
		}); // [1, 2, 4, 5, 7, 8, 10]
		$this->assertEquals($arr, array(0=>1,1=>2,3=>4,4=>5,6=>7,7=>8,9=>10));
	}

	public function test_empty() {
		$fun = 'empty';
		$arr = array();
		$ret = enumerator::$fun($arr);
		$this->assertEquals($ret, true);
	}

	public function test_isEmpty() {
		$arr = array();
		$ret = enumerator::isEmpty($arr);
		$this->assertEquals($ret, true);
	}

	public function test_find_index() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		);
		$ret = enumerator::find_index($name, 'John');
		$this->assertEquals($ret, 'first');
	}

	public function test_index() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		);
		$ret = enumerator::index($name, 'John');
		$this->assertEquals($ret, 'first');
	}

	public function test_all() {
		// Callback testing
		$animals = array('ant', 'bear', 'cat');
		$ret = enumerator::all($animals, function($key, $value) {
			return (strlen($value) >= 3);
		});
		$this->assertEquals($ret, true);
	}

	public function test_any() {
		// Callback 2
		$animals = array('ant', 'bear', 'cat');
		$ret = enumerator::any($animals, function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals($ret, true);
	}

	public function test_each_slice() {
		// Basic
		$arr = range(1,10);
		$arr = enumerator::each_slice($arr, 3, function(&$collection) {
			foreach($collection as $key => &$value) ++$value;
			return;
		});
		$this->assertEquals($arr, array(array(2,3,4), array(5,6,7), array(8,9,10), array(11)));
	}

	public function test_grep() {
		// Destructive callback
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		$arr = enumerator::grep($arr, "/^snow/", function($key, &$value) {
			$value .= '_';
			return;
		});
		$this->assertEquals($arr, array('snowball_', 'snowcone_', 'snowangel_'));
	}

	public function test_group_by() {
		// Basic test
		$arr = range(1,6);
		$arr =enumerator::group_by($arr, function($key, &$value) {
			return ($value % 3);
		});
		$this->assertEquals($arr, array(array(3, 6), array(1, 4), array(2,5)));
	}

	public function test_partition() {
		$arr = range(1,6);
		$arr = enumerator::partition($arr, function($key, $value) {
			return ($value % 2 == 0);
		});
		$this->assertEquals($arr, array(array(2,4,6), array(1,3,5)));
	}

	public function test_sort_by() {
		$arr = array('rhea', 'kea', 'flea');
		$arr = enumerator::sort_by($arr, function($val) {
			return strlen($val);
		});
		$this->assertEquals($arr, array('kea', 'flea', 'rhea'));
	}

	public function test_take_while() {
		$arr = array(1,2,3,4,5,0);
		$arr = enumerator::take_while($arr, function($key, &$value) {
			return ($value < 3);
		});
		$this->assertEquals($arr, array(1, 2));
	}

	public function test_zip() {
		$arr = array(1,2);
		$arr = enumerator::zip($arr, array(4,5,6),array(7,8,9));
		$this->assertEquals($arr, array(array(1, 4, 7), array(2, 5, 8)));
	}

	public function test_drop_while() {
		$arr = array(1,2,3,4,5,0);
		$arr = enumerator::drop_while($arr, function($key, &$value) {
			return ($value < 3);
		});
		$this->assertEquals($arr, array(3,4,5,0));
	}

	public function test_each_cons() {
		$arr = range(1,10);
		$follower = 0;
		$message = '';
		$arr = enumerator::each_cons($arr, 3, function($key, $value, $leader) use (&$follower, &$message) {
			if($follower < $leader) {
				$message .= '||';
				$follower = $leader;
			}
			$message .= $value . ',';
		});
		$this->assertEquals($message, "1,2,3,||2,3,4,||3,4,5,||4,5,6,||5,6,7,||6,7,8,||7,8,9,||8,9,10,");
		$this->assertEquals($arr, array(array(1,2,3), array(2,3,4), array(3,4,5), array(4,5,6), array(5,6,7), array(6,7,8), array(7,8,9), array(8,9,10)));
	}

	public function test_slice_before() {
		$arr = array(1,2,3,4,5,6,7,8,9,0);
		$arr = enumerator::slice_before($arr, "/[02468]/");
		$this->assertEquals($arr, array(array(1), array(2,3), array(4,5), array(6,7), array(8,9), array(0)));
	}

	public function test_rotate_2() {
		$arr = array('Foo', 'bar', 'foobar');
		$arr = enumerator::rotate($arr, -1); // foobar, Foo, bar
		$this->assertEquals($arr, array('foobar', 'Foo', 'bar'));
	}

	public function test_reverse() {
		$arr = array(1,2,3);
		$arr = enumerator::reverse($arr);
		$this->assertEquals($arr, array(3,2,1));
	}

	public function test_values_at_1() {
		$name = array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.'
		);
		$name = enumerator::values_at($name, 'title', 'last'); // ['title' => 'Dr.', 'last' => 'Doe'];
		$this->assertEquals($name, array('title'=>'Dr.', 'last' => 'Doe'));
	}

	public function test_shuffle_2() {
		// How do you test random values?
		// There must be a better way...
		$arr = array('a' => 'apple', 'b' => 'banana', 'c' => 'carrot');
		$arr = enumerator::shuffle($arr, true);
		$this->assertArrayHasKey('a', $arr);
		$this->assertArrayHasKey('b', $arr);
		$this->assertArrayHasKey('c', $arr);
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
		$ret = enumerator::rindex($name, 'John');
		$this->assertEquals($ret, 'first');
	}

	public function test_compact_1() {
		$arr = array(1,2,3,null,array(2,3,4,null));
		$arr = enumerator::compact($arr);
		$this->assertEquals($arr, array(1,2,3,4=>array(2,3,4,null)));
	}

	public function test_cycle_1() {
		$i = 0;
		$arr = array(1,2,3);
		$arr = enumerator::cycle($arr, 3, function($key, $value, $it) use(&$i) {
			$i++;
		});
		$this->assertEquals($i, 9);
	}

	public function test_uniq_1() {
		$arr = array(1,1,2,3,3,2,1,1,1);
		$a = enumerator::uniq($arr);
		$this->assertEquals($a, array(0=>1,2=>2,3=>3));
	}

	public function test_uniq_2() {
		$arr = array(1,1,2,3,3,2,1,1,1);
		$a = enumerator::array_unique($arr);
		$this->assertEquals($a, array(0=>1,2=>2,3=>3));
	}

	public function test_combination_1() {
		$arr = array(1, 2, 3, 4);
		$arr = enumerator::combination($arr, 1);
		$this->assertEquals($arr, array(array(1), array(2), array(3), array(4)));
	}

	public function test_combination_2() {
		$arr = array(1, 2, 3, 4);
		$arr = enumerator::combination($arr, 4);
		$this->assertEquals($arr, array(array(1,2,3,4)));
	}

	public function test_combination_3() {
		$arr = array(1, 2, 3, 4);
		$arr = enumerator::combination($arr, 0);
		$this->assertEquals($arr, array(array()));
	}

	public function test_combinatoin_4() {
		// tests destructive
		$arr = array(1, 2, 3, 4);
		$arr2 = enumerator::combination($arr, 4, function($key, &$value) {
			foreach($value as &$v) {
				$v++;
			}
		});
		$this->assertEquals($arr2, array(array(2,3,4,5)));
		$this->assertEquals($arr, array(1,2,3,4));
	}

	public function test_delete_1() {
		$arr = array('a','b', 'b', 'b', 'c');
		$ret = enumerator::delete($arr, 'b');
		$this->assertEquals($ret, 'b');
		$this->assertEquals($arr, array('a','b', 'b', 'b', 'c'));
	}

	public function test_delete_2() {
		$arr = array('a','b', 'b', 'b', 'c');
		$ret = enumerator::delete($arr, 'z');
		$this->assertEquals($ret, null);
		$this->assertEquals($arr, array('a','b', 'b', 'b', 'c'));
	}

	public function test_delete_3() {
		$arr = array('a','b', 'b', 'b', 'c');
		$ret = enumerator::delete($arr, 'z', function() {
			return false;
		});
		$this->assertEquals($ret, false);
		$this->assertEquals($arr, array('a','b', 'b', 'b', 'c'));
	}

	public function test_delete_at_1() {
		$arr = array('ant', 'bat', 'cat', 'dog');
		$ret = enumerator::delete_at($arr, 2);
		$this->assertEquals($ret, 'cat');
		$this->assertEquals($arr, array('ant', 'bat', 'cat', 'dog'));
	}

	public function test_delete_at_2() {
		$arr = array('ant', 'bat', 'cat', 'dog');
		$ret = enumerator::delete_at($arr, 99);
		$this->assertEquals($ret, null);
	}

}