<?php

/*

	This will test the core functionality of PrettyArray

*/
class prettyArrayTest extends PHPUnit_Framework_TestCase {

	public function test_set_get_1() {
		$arr = new PrettyArray();
		$arr2 = array();

		$arr[] = 'foo';
		$arr2[] = 'foo';

		$arr[2] = 'bar';
		$arr2[2] = 'bar';

		$arr[] = 'foobar';
		$arr2[] = 'foobar';

		$this->assertEquals($arr->count(), count($arr2));
		$this->assertEquals($arr->to_a(), $arr2);

	}

	public function test_set_get_2() {
		$arr = new PrettyArray();
		$arr2 = array();

		$iterations = 10000;
		
		for($i = 0;$i<$iterations;$i++) {
			// Value
			$value = mt_rand(1000,2000);
			// Change to not have a key
			$key = (mt_rand(0,3) == 0) ? null : mt_rand(0,1000);
			if(is_null($key)) {
				// No key
				$arr[] = $value;
				$arr2[] = $value;
			} else {
				// Key
				$arr[$key] = $value;
				$arr2[$key] = $value;
			}
		}

		$this->assertEquals($arr->count(), count($arr2));
		$this->assertEquals($arr->to_a(), $arr2);
	}

	public function test_reference_1() {
		$arr = new PrettyArray();
		$a = 'foo';
		$arr->setByReference(0, $a);
		$a = 'bar';
		$this->assertEquals($a, $arr[0]);
	}

	public function test_reference_2() {
		// Create Array
		$arr = new PrettyArray();
		$arr2 = array();
		$iterations = 10000;
		for($i = 0;$i<$iterations;$i++) {
			$value = mt_rand(1000,2000);
			$key = mt_rand(0,1000);
			$arr2[$key] = $value;
			$arr->setByReference($key, $arr2[$key]);

		}

		// Update arr2
		$iterations = 10000;
		for($i = 0;$i<$iterations;$i++) {
			$arr2[array_rand($arr2)] = mt_rand(2000,3000);
		}

		// Check accuracy
		$this->assertEquals($arr->count(), count($arr2));
		$this->assertEquals($arr->to_a(), $arr2);

	}

	public function test_range_1() {
		$arr = new PrettyArray(array('swamp', 'desert', 'snow', 'rain', 'fog'));
		$ret = $arr->getSet(1,3)->to_a();
		$this->assertEquals($ret, array(1=>'desert', 2=>'snow', 3=>'rain'));
	}

	public function test_range_2() {
		$arr = new PrettyArray(array('swamp', 'desert', 'snow', 'rain', 'fog'));
		$arr2 = $arr->getSet_(1,3);
		$arr2[1] = 'foobar';
		$this->assertEquals($arr2[1], $arr[1]);
	}

	public function test_getset_1() {
		$arr = new PrettyArray(array(1,2,3,4,5));
		$ret = $arr->getSet(1, 2)->to_a();
		$this->assertEquals($ret, array(1=>2,2=>3));
	}

	public function test_getset_2() {
		$arr = new PrettyArray(array(1,2,3,4,5));
		$ret = $arr->getSet_(1, 2);
		$ret[1] = 'foobar';
		$this->assertEquals($ret[1], $arr[1]);
	}

	public function test_call_1() {
		$arr = new PrettyArray(array(1,2,3));
		$arr->collect_(function($key, &$value) {
			$value--;
			return;
		});
		$this->assertEquals($arr->to_a(), array(0,1,2));
	}
	public function test_call_2() {
		$arr = new PrettyArray(array(1,2,3));
		$arr->collect(function($key, &$value) {
			$value--;
			return;
		});
		$this->assertEquals($arr->to_a(), array(1,2,3));
	}
	public function test_call_3() {
		$arr = new PrettyArray(array(1,2,3));
		$arr->each(function($key, &$value) {
			$value--;
			return;
		});
		$this->assertEquals($arr->to_a(), array(1,2,3));
	}

	public function test_call_4() {
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->grep("/^snow/"); // [snowball, snowcone, snowangel]
		$this->assertEquals($ret->to_a(), array('snowball', 'snowcone', 'snowangel'));
		$this->assertEquals($arr->to_a(), array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
	}

	public function test_call_5() {
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->grep_("/^snow/"); // [snowball, snowcone, snowangel]
		$this->assertEquals($ret, $arr);
		$this->assertEquals($arr->to_a(), array('snowball', 'snowcone', 'snowangel'));
	}

	public function test_call_6() {
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->count();
		$this->assertEquals($ret, 5);
	}

// Next 3 methods test instance destructive methods
	public function test_enumerator_destructive_instance_count() {
		// Counting specific values
		$arr = new PrettyArray(array(1,2,4,2));
		$ret = $arr->count_(2);
		$this->assertEquals($ret, 2);
	}
	public function test_enumerator_destructive_instance_all() {
		// Destructive testing
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$animals->all_(function($key, &$value) {
			$value .= '_';
			return true;
		});
		$animals = $animals->to_a();
		$this->assertEquals($animals, array('ant_', 'bear_', 'cat_'));
	}
	public function test_enumerator_destructive_instance_index() {
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

// Next 3 methods test instance non-destructive methods
	public function test_enumerator_instance_none() {
		$arr = new PrettyArray(array(null, false));
		$ret = $arr->none();
		$this->assertEquals($ret, true);
	}
	public function test_enumerator_instance_one() {
		$arr = new PrettyArray(array(null, true, false));
		$ret = $arr->one();
		$this->assertEquals($ret, true);
	}
	public function test_enumerator_instance_sort() {
		$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
		$out = $arr->sort();
		$this->assertEquals($out->to_a(), array('flea', 'kea', 'rhea'));
	}

// Next 3 methods test static non-destructive methods
	public function test_enumerator_static_find_all() {
		$arr = range(1,10);
		$arr = PrettyArray::find_all($arr,function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals($arr, array(2=>3, 5=>6, 8=>9));
	}
	public function test_enumerator_static_count() {
		// Counting specific values
		$arr = array(1,2,4,2);
		$ret = PrettyArray::count($arr, 2);
		$this->assertEquals($ret, 2);
	}
	public function test_any() {
		// Callback 2
		$animals = array('ant', 'bear', 'cat');
		$ret = PrettyArray::any($animals, function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals($ret, true);
	}

}