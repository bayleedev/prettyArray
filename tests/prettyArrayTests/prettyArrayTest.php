<?php
/*
	This will test the core functionality of PrettyArray
*/

use prettyArray\PrettyArray;

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

		$this->assertEquals(count($arr2), $arr->count());
		$this->assertEquals($arr2, $arr->to_a());

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

		$this->assertEquals(count($arr2), $arr->count());
		$this->assertEquals($arr2, $arr->to_a());
	}

	public function test_reference_1() {
		$arr = new PrettyArray();
		$a = 'foo';
		$arr->setByReference(0, $a);
		$a = 'bar';
		$this->assertEquals($arr[0], $a);
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
		$this->assertEquals(count($arr2), $arr->count());
		$this->assertEquals($arr2, $arr->to_a());

	}

	public function test_range_1() {
		$arr = new PrettyArray(array('swamp', 'desert', 'snow', 'rain', 'fog'));
		$ret = $arr->getSet(1,3)->to_a();
		$this->assertEquals(array(1=>'desert', 2=>'snow', 3=>'rain'), $ret);
	}

	public function test_range_2() {
		$arr = new PrettyArray(array('swamp', 'desert', 'snow', 'rain', 'fog'));
		$arr2 = $arr->getSet_(1,3);
		$arr2[1] = 'foobar';
		$this->assertEquals($arr[1], $arr2[1]);
	}

	public function test_getset_1() {
		$arr = new PrettyArray(array(1,2,3,4,5));
		$ret = $arr->getSet(1, 2)->to_a();
		$this->assertEquals(array(1=>2,2=>3), $ret);
	}

	public function test_getset_2() {
		$arr = new PrettyArray(array(1,2,3,4,5));
		$ret = $arr->getSet_(1, 2);
		$ret[1] = 'foobar';
		$this->assertEquals($arr[1], $ret[1]);
	}

	public function test_call_1() {
		$arr = new PrettyArray(array(1,2,3));
		$arr->each_(function($key, &$value) {
			$value--;
			return;
		});
		$this->assertEquals(array(0,1,2), $arr->to_a());
	}
	public function test_call_2() {
		$arr = new PrettyArray(array(1,2,3));
		$arr->each(function($key, &$value) {
			$value--;
			return;
		});
		$this->assertEquals(array(1,2,3), $arr->to_a());
	}
	public function test_call_3() {
		$arr = new PrettyArray(array(1,2,3));
		$arr->foreach(function($key, &$value) {
			$value--;
			return;
		});
		$this->assertEquals(array(1,2,3), $arr->to_a());
	}

	public function test_call_4() {
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->grep("/^snow/"); // [snowball, snowcone, snowangel]
		$this->assertEquals(array('snowball', 'snowcone', 'snowangel'), $ret->to_a());
		$this->assertEquals(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'), $arr->to_a());
	}

	public function test_call_5() {
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->grep_("/^snow/"); // [snowball, snowcone, snowangel]
		$this->assertEquals($arr, $ret);
		$this->assertEquals(array('snowball', 'snowcone', 'snowangel'), $arr->to_a());
	}

	public function test_call_6() {
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->count();
		$this->assertEquals(5, $ret);
	}

// Next 3 methods test instance destructive methods
	public function test_enumerator_destructive_instance_count() {
		// Counting specific values
		$arr = new PrettyArray(array(1,2,4,2));
		$ret = $arr->count_(2);
		$this->assertEquals(2, $ret);
	}
	public function test_enumerator_destructive_instance_all() {
		// Destructive testing
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$animals->all_(function($key, &$value) {
			$value .= '_';
			return true;
		});
		$animals = $animals->to_a();
		$this->assertEquals(array('ant_', 'bear_', 'cat_'), $animals);
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
		$this->assertEquals('first', $ret);
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
		$this->assertEquals(true, $ret);
	}
	public function test_enumerator_instance_sort() {
		$arr = new PrettyArray(array('rhea', 'kea', 'flea'));
		$out = $arr->sort();
		$this->assertEquals(array('flea', 'kea', 'rhea'), $out->to_a());
	}

// Next 3 methods test static non-destructive methods
	public function test_enumerator_static_find_all() {
		$arr = range(1,10);
		$arr = PrettyArray::find_all($arr,function($key, $value) {
			return ($value % 3 == 0);
		});
		$this->assertEquals(array(2=>3, 5=>6, 8=>9), $arr);
	}
	public function test_any() {
		// Callback 2
		$animals = array('ant', 'bear', 'cat');
		$ret = PrettyArray::any($animals, function($key, $value) {
			return (strlen($value) >= 4);
		});
		$this->assertEquals(true, $ret);
	}

	public function testIteration() {
		$animals = new PrettyArray(array('ant', 'bear', 'cat'));
		$newAnimals = array();
		foreach ($animals as $key => $animal) {
			$newAnimals[$key] = $animal;
		}
		$this->assertEquals(array('ant', 'bear', 'cat'), $newAnimals);
	}

	public function testHashIteration() {
		$animals = new PrettyArray(array(
			'bug' => 'ant',
			'large' => 'bear',
			'small' => 'cat',
		));
		$newAnimals = array();
		foreach ($animals as $key => $animal) {
			$newAnimals[$key] = $animal;
		}
		$this->assertEquals(array(
			'bug' => 'ant',
			'large' => 'bear',
			'small' => 'cat',
		), $newAnimals);
	}

	public function testMultipleParamsToConstructor() {
		$animals = new PrettyArray('ant', 'bear', 'cat');
		$this->assertEquals(array('ant', 'bear', 'cat'), $animals->to_a());
	}

	public function testNoParamsToConstructor() {
		$animals = new PrettyArray();
		$this->assertEquals(array(), $animals->to_a());
	}

	public function testNullParamToConstructor() {
		$animals = new PrettyArray(null);
		$this->assertEquals(array(), $animals->to_a());
	}

	public function testNullParamsToConstructor() {
		$animals = new PrettyArray(null, null);
		$this->assertEquals(array(), $animals->to_a());
	}

	public function testCountable() {
		$animals = new PrettyArray('ant', 'bear', 'cat');
		$this->assertCount(3, $animals);
	}

}
