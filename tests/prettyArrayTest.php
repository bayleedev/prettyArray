<?php

// All tests for pretty array should be in here.

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
		$this->assertEquals($ret, array('snowball', 'snowcone', 'snowangel'));
		$this->assertEquals($arr->to_a(), array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
	}

	public function test_call_5() {
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->grep_("/^snow/"); // [snowball, snowcone, snowangel]
		$this->assertEquals($ret, null);
		$this->assertEquals($arr->to_a(), array('snowball', 'snowcone', 'snowangel'));
	}

	public function test_call_6() {
		$arr = new PrettyArray(array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice'));
		$ret = $arr->count();
		$this->assertEquals($ret, 5);
	}
}