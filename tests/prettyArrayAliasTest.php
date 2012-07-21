<?php

/*

	Tests all non-destructive aliases in PrettyArray->PrettyArray

	This all goes through the same method $arr->__callStatic so only a handfull of items will be tested.

*/
class prettyArrayAliasTest extends PHPUnit_Framework_TestCase {

	public function test_array_slice() {
		// Normal value
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $animals->array_slice(1);
		$this->assertEquals($ret->to_a(), array('bear', 'cat'));
	}

	public function test_drop() {
		// Normal value
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $animals->drop(1);
		$this->assertEquals($ret->to_a(), array('bear', 'cat'));
	}

	public function test_find_all() {
		// Basic
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->find_all(function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($ret->to_a(), array(2=>3, 5=>6, 8=>9));
	}

	public function test_keep_if() {
		// Basic
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->keep_if(function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($ret->to_a(), array(2=>3, 5=>6, 8=>9));
	}

	public function test_select() {
		// Basic
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->select(function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($ret->to_a(), array(2=>3, 5=>6, 8=>9));
	}

	public function test_reduce() {
		$arr = new PrettyArray(range(5, 10));
		$ret = $arr->reduce(function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$this->assertEquals($ret, 45);
	}

	public function test_inject() {
		$arr = new PrettyArray(range(5, 10));
		$ret = $arr->inject(function($key, &$value, &$memo){
			$memo += $value;
			return;
		}); // 45
		$this->assertEquals($ret, 45);
	}

	public function test_include() {
		$fun = 'include';
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->$fun('snowcone'); // true
		$this->assertEquals($ret, true);
	}

	public function test_member() {
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->member('snowcone'); // true
		$this->assertEquals($ret, true);
	}

	public function test_flat_map() {
		// Basic test
		$arr = new PrettyArray(array(array(1,2), array(3,4)));
		$ret = $arr->flat_map(function($key, &$value) {
			return ++$value;
		});
		$this->assertEquals($ret->to_a(), array(2,3,4,5));
	}

	public function test_collect_concat() {
		// Basic test
		$arr = new PrettyArray(array(array(1,2), array(3,4)));
		$ret = $arr->collect_concat(function($key, &$value) {
			return ++$value;
		});
		$this->assertEquals($ret->to_a(), array(2,3,4,5));
	}

	public function test_take() {
		// Test without $count
		$animals = new PrettyArray(array('cat', 'dog', 'cow', 'pig'));
		$ret = $animals->take();
		$this->assertEquals($ret->to_a(), array('cat'));
	}

	public function test_first() {
		// Test without $count
		$animals = new PrettyArray(array('cat', 'dog', 'cow', 'pig'));
		$ret = $animals->first();
		$this->assertEquals($ret->to_a(), array('cat'));
	}

	public function test_find() {
		// Callback 1
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->find(function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, null);
	}

	public function test_detect() {
		// Callback 1
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->detect(function($key, $value) {
			return ($value % 5 == 0 and $value % 7 == 0);
		});
		$this->assertEquals($ret, null);
	}

	public function test_size() {
		// Counting specific values
		$arr = new PrettyArray(array(1,2,4,2));
		$ret = $arr->size(2);
		$this->assertEquals($ret, 2);
	}

	public function test_length() {
		// Counting specific values
		$arr = new PrettyArray(array(1,2,4,2));
		$ret = $arr->length(2);
		$this->assertEquals($ret, 2);
	}

	public function test_count() {
		// Counting specific values
		$arr = new PrettyArray(array(1,2,4,2));
		$ret = $arr->count(2);
		$this->assertEquals($ret, 2);
	}

	public function test_array_walk() {
		// Editing 1
		$arr = new PrettyArray(range(1,4));
		$ret = $arr->array_walk(function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($ret->to_a(), array(1, 4, 9, 16));
	}

	public function test_each() {
		// Editing 1
		$arr = new PrettyArray(range(1,4));
		$ret = $arr->each(function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($ret->to_a(), array(1, 4, 9, 16));
	}

	public function test_map() {
		// Editing 1
		$arr = new PrettyArray(range(1,4));
		$ret = $arr->map(function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($ret->to_a(), array(1, 4, 9, 16));
	}

	public function test_foreach() {
		// Editing 1
		$fun = 'foreach';
		$arr = new PrettyArray(range(1,4));
		$ret = $arr->$fun(function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($ret->to_a(), array(1, 4, 9, 16));
	}

	public function test_each_with_index() {
		// Editing 1
		$arr = new PrettyArray(range(1,4));
		$ret = $arr->each_with_index(function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($ret->to_a(), array(1, 4, 9, 16));
	}

	public function test_collect() {
		// Editing 1
		$arr = new PrettyArray(range(1,4));
		$ret = $arr->collect(function($key, &$value) {
			$value *= $value;
			return;
		});
		$this->assertEquals($ret->to_a(), array(1, 4, 9, 16));
	}

	public function test_reverse_map() {
		$arr = new PrettyArray(array(1, 2, 3));
		$index = 2;
		$arr2 = $arr->reverse_map(function($key, &$value) {
			$value = 'cat';
			return;
		});
		$this->assertEquals($arr->to_a(), array(1, 2, 3));
		$this->assertEquals($arr2->to_a(), array('cat','cat','cat'));
	}

	public function test_reverse_foreach() {
		$arr = new PrettyArray(array(1, 2, 3));
		$index = 2;
		$arr2 = $arr->reverse_foreach(function($key, &$value) {
			$value = 'cat';
			return;
		});
		$this->assertEquals($arr->to_a(), array(1, 2, 3));
		$this->assertEquals($arr2->to_a(), array('cat','cat','cat'));
	}

	public function test_reverse_each_with_index() {
		$arr = new PrettyArray(array(1, 2, 3));
		$index = 2;
		$arr2 = $arr->reverse_each_with_index(function($key, &$value) {
			$value = 'cat';
			return;
		});
		$this->assertEquals($arr->to_a(), array(1, 2, 3));
		$this->assertEquals($arr2->to_a(), array('cat','cat','cat'));
	}

	public function test_reverse_collect() {
		$arr = new PrettyArray(array(1, 2, 3));
		$index = 2;
		$arr2 = $arr->reverse_collect(function($key, &$value) {
			$value = 'cat';
			return;
		});
		$this->assertEquals($arr->to_a(), array(1, 2, 3));
		$this->assertEquals($arr2->to_a(), array('cat','cat','cat'));
	}

	public function test_concat() {
		$arr = new PrettyArray();
		$animals = array('dog', 'cat', 'pig');
		$trees = array('pine');
		$material = array('wool');
		$ret = $arr->concat($animals, $trees, $material);
		$this->assertEquals($ret->to_a(), array('dog', 'cat', 'pig', 'pine', 'wool'));
	}


	public function test_merge() {
		$arr = new PrettyArray();
		$animals = array('dog', 'cat', 'pig');
		$trees = array('pine');
		$material = array('wool');
		$ret = $arr->merge($animals, $trees, $material);
		$this->assertEquals($ret->to_a(), array('dog', 'cat', 'pig', 'pine', 'wool'));
	}

	public function test_sample() {
		$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
		$random = $arr->sample();
		$this->assertInternalType('string', $random);
		$this->assertContains($random, array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_random() {
		$arr = new PrettyArray(array('pig', 'cow', 'dog', 'horse'));
		$random = $arr->random();
		$this->assertInternalType('string', $random);
		$this->assertContains($random, array('pig', 'cow', 'dog', 'horse'));
	}

	public function test_usort() {
		$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
		$ret = $arr->usort(function($val1, $val2) {
			return strcmp($val2, $val1);
		});
		$this->assertEquals($ret->to_a(), array('rhea', 'kea', 'flea'));
	}

	public function test_sort() {
		$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
		$ret = $arr->sort(function($val1, $val2) {
			return strcmp($val2, $val1);
		});
		$this->assertEquals($ret->to_a(), array('rhea', 'kea', 'flea'));
	}

	public function test_delete_if() {
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->delete_if(function($key, $value) {
			return ($value % 3 == 0);
		}); // [1, 2, 4, 5, 7, 8, 10]
		$this->assertEquals($ret->to_a(), array(0=>1,1=>2,3=>4,4=>5,6=>7,7=>8,9=>10));
	}

	public function test_reject() {
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->reject(function($key, $value) {
			return ($value % 3 == 0);
		}); // [1, 2, 4, 5, 7, 8, 10]
		$this->assertEquals($ret->to_a(), array(0=>1,1=>2,3=>4,4=>5,6=>7,7=>8,9=>10));
	}

	public function test_empty() {
		$fun = 'empty';
		$arr = new PrettyArray();
		$ret = $arr->$fun();
		$this->assertEquals($ret, true);
	}

	public function test_isEmpty() {
		$arr = new PrettyArray();
		$ret = $arr->isEmpty();
		$this->assertEquals($ret, true);
	}

	public function test_find_index() {
		$name = new PrettyArray(array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.',
			'suffix' => 'Jr.'
		));
		$ret = $name->find_index('John');
		$this->assertEquals($ret, 'first');
	}

	public function test_index() {
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

	public function test_all() {
		// Callback testing
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $animals->all(function($key, $value) {
			return (strlen($value) >= 3);
		});
		$this->assertEquals($ret, true);
	}

	public function test_any() {
		// Callback 2
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$ret = $animals->any(function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals($ret, true);
	}

	public function test_each_slice() {
		// Basic
		$arr = new PrettyArray(range(1,10));
		$ret = $arr->each_slice(3, function(&$collection) {
			foreach($collection as $key => &$value) ++$value;
			return;
		});
		$this->assertEquals($ret->to_a(), array(array(2,3,4), array(5,6,7), array(8,9,10), array(11)));
	}

	public function test_grep() {
		// Destructive callback
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->grep("/^snow/", function($key, &$value) {
			$value .= '_';
			return;
		});
		$this->assertEquals($ret->to_a(), array('snowball_', 'snowcone_', 'snowangel_'));
	}

	public function test_group_by() {
		// Basic test
		$arr = new PrettyArray(range(1,6));
		$ret = $arr->group_by(function($key, &$value) {
			return ($value % 3);
		});
		$this->assertEquals($ret->to_a(), array(array(3, 6), array(1, 4), array(2,5)));
	}

	public function test_partition() {
		$arr = new PrettyArray(range(1,6));
		$ret = $arr->partition(function($key, $value) {
			return ($value % 2 == 0);
		});
		$this->assertEquals($ret->to_a(), array(array(2,4,6), array(1,3,5)));
	}

	public function test_sort_by() {
		$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
		$ret = $arr->sort_by(function($val) {
			return strlen($val);
		});
		$this->assertEquals($ret->to_a(), array('kea', 'flea', 'rhea'));
	}

	public function test_take_while() {
		$arr = new PrettyArray(array(1,2,3,4,5,0));
		$ret = $arr->take_while(function($key, &$value) {
			return ($value < 3);
		});
		$this->assertEquals($ret->to_a(), array(1, 2));
	}

	public function test_zip() {
		$arr = new PrettyArray(array(1,2));
		$ret = $arr->zip(array(4,5,6),array(7,8,9));
		$this->assertEquals($ret->to_a(), array(array(1, 4, 7), array(2, 5, 8)));
	}

	public function test_drop_while() {
		$arr = new PrettyArray(array(1,2,3,4,5,0));
		$ret = $arr->drop_while(function($key, &$value) {
			return ($value < 3);
		});
		$this->assertEquals($ret->to_a(), array(3,4,5,0));
	}

	public function test_each_cons() {
		$arr = new PrettyArray(range(1,10));
		$follower = 0;
		$message = '';
		$ret = $arr->each_cons(3, function($key, $value, $leader) use (&$follower, &$message) {
			if($follower < $leader) {
				$message .= '||';
				$follower = $leader;
			}
			$message .= $value . ',';
		});
		$this->assertEquals($message, "1,2,3,||2,3,4,||3,4,5,||4,5,6,||5,6,7,||6,7,8,||7,8,9,||8,9,10,");
		$this->assertEquals($ret->to_a(), array(array(1,2,3), array(2,3,4), array(3,4,5), array(4,5,6), array(5,6,7), array(6,7,8), array(7,8,9), array(8,9,10)));
	}

	public function test_slice_before() {
		$arr = new PrettyArray(array(1,2,3,4,5,6,7,8,9,0));
		$ret = $arr->slice_before("/[02468]/");
		$this->assertEquals($ret->to_a(), array(array(1), array(2,3), array(4,5), array(6,7), array(8,9), array(0)));
	}

	public function test_rotate_2() {
		$arr = new PrettyArray(array('Foo', 'bar', 'foobar'));
		$ret = $arr->rotate(-1); // foobar, Foo, bar
		$this->assertEquals($ret->to_a(), array('foobar', 'Foo', 'bar'));
	}

	public function test_reverse() {
		$arr = new PrettyArray(array(1,2,3));
		$ret = $arr->reverse();
		$this->assertEquals($ret->to_a(), array(3,2,1));
	}

	public function test_values_at_1() {
		$name = new PrettyArray(array(
			'name' => 'John Doe',
			'first' => 'John',
			'middle' => 'M',
			'last' => 'Doe',
			'title' => 'Dr.'
		));
		$ret = $name->values_at('title', 'last'); // ['title' => 'Dr.', 'last' => 'Doe'];
		$this->assertEquals($ret->to_a(), array('title'=>'Dr.', 'last' => 'Doe'));
	}

	public function test_shuffle_2() {
		// How do you test random values?
		// There must be a better way...
		$arr = new PrettyArray(array('a' => 'apple', 'b' => 'banana', 'c' => 'carrot'));
		$ret = $arr->shuffle(true);
		$ret = $ret->to_a();
		$this->assertArrayHasKey('a', $ret);
		$this->assertArrayHasKey('b', $ret);
		$this->assertArrayHasKey('c', $ret);
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

	public function test_compact_1() {
		$arr = new PrettyArray(array(1,2,3,null,array(2,3,4,null)));
		$ret = $arr->compact();
		$this->assertEquals($ret->to_a(), array(1,2,3,4=>array(2,3,4,null)));
	}

	public function test_cycle_1() {
		$i = 0;
		$arr = new PrettyArray(array(1,2,3));
		$arr->cycle(3, function($key, $value, $it) use(&$i) {
			$i++;
		});
		$this->assertEquals($i, 9);
	}

	public function test_uniq_1() {
		$arr = new PrettyArray(array(1,1,2,3,3,2,1,1,1));
		$a = $arr->uniq()->to_a();
		$this->assertEquals($a, array(0=>1,2=>2,3=>3));
	}

	public function test_uniq_2() {
		$arr = new PrettyArray(array(1,1,2,3,3,2,1,1,1));
		$a = $arr->array_unique()->to_a();
		$this->assertEquals($a, array(0=>1,2=>2,3=>3));
	}

}