<?php

/*
	Tests the core functionality of Enumerator
*/

class exceptionTest extends PHPUnit_Framework_TestCase {
	public function test_collect_break() {
		$o = '';
		$arr = range(1,10);
		enumerator::collect($arr, function($key, $value) use(&$o) {
			if($value == 5) {
				throw new BreakException;
			}
			$o .= $value;
			return;
		});
		$this->assertEquals($o, '1234');
	}
	public function test_collect_continue() {
		$o = '';
		$arr = range(1,10);
		enumerator::collect($arr, function($key, $value) use(&$o) {
			if($value == 5) {
				throw new ContinueException;
			}
			$o .= $value;
			return;
		});
		$this->assertEquals($o, '1234678910');
	}

	public function test_each_slice_break() {
		$arr = range(1,10);
		$count = 0;
		enumerator::each_slice($arr, 3, function(&$collection) use(&$count) {
			if(in_array(4, $collection)) {
				throw new BreakException;
			}
			$count += array_sum($collection);
		});
		$this->assertEquals($count, 6);
	}

	public function test_each_slice_continue() {
		$arr = range(1,10);
		$count = 0;
		enumerator::each_slice($arr, 3, function(&$collection) use(&$count) {
			if(in_array(4, $collection)) {
				throw new ContinueException;
			}
			$count += array_sum($collection);
		});
		$this->assertEquals($count, 40);
	}

	public function test_collect_concat_break() {
		$arr = array(array(1,2),array(3,4));
		$count = 0;
		enumerator::collect_concat($arr, function($key, &$value) use(&$count) {
			if($value == 3) {
				throw new BreakException;
			}
			$count += $value;
		});
		$this->assertEquals($count, 3);
	}

	public function test_collect_concat_continue() {
		$arr = array(array(1,2),array(3,4));
		$count = 0;
		enumerator::collect_concat($arr, function($key, &$value) use(&$count) {
			if($value == 3) {
				throw new ContinueException;
			}
			$count += $value;
		});
		$this->assertEquals($count, 7);
	}

	public function test_grep_break() {
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		$o = '';
		enumerator::grep($arr, "/^snow/", function($key, $value) use (&$o) {
			if($value == 'snowcone') {
				throw new BreakException;
			}
			$o .= $value;
		});
		$this->assertEquals($o, 'snowball');
	}

	public function test_grep_continue() {
		$arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
		$o = '';
		enumerator::grep($arr, "/^snow/", function($key, $value) use (&$o) {
			if($value == 'snowcone') {
				throw new ContinueException;
			}
			$o .= $value;
		});
		$this->assertEquals($o, 'snowballsnowangel');
	}

	public function test_inject_break() {
		$arr = range(5, 10);
		$memo = enumerator::inject($arr, function($key, &$value, &$memo) {
			if($value == 6) {
				throw new BreakException;
			}
			$memo += $value;
			return;
		});
		$this->assertEquals($memo, 5);
	}

	public function test_inject_continue() {
		$arr = range(5, 10);
		$memo = enumerator::inject($arr, function($key, &$value, &$memo) {
			if($value == 6) {
				throw new ContinueException;
			}
			$memo += $value;
			return;
		});
		$this->assertEquals($memo, 39);
	}

	public function test_reverse_collect_break() {
		$arr = array(1, 2, 3);
		$o = '';
		enumerator::reverse_collect($arr, function($key, &$value) use (&$o) {
			if($value == 2) {
				throw new BreakException;
			}
			$o .= $value . ', ';
			return;
		});
		$this->assertEquals($o, '3, ');
	}

	public function test_reverse_collect_continue() {
		$arr = array(1, 2, 3);
		$o = '';
		enumerator::reverse_collect($arr, function($key, &$value) use (&$o) {
			if($value == 2) {
				throw new ContinueException;
			}
			$o .= $value . ', ';
			return;
		});
		$this->assertEquals($o, '3, 1, ');
	}

	public function test_cycle_break() {
		$arr = array(1,2,3);
		$count = 0;
		enumerator::cycle($arr, 3, function($key, $value, $it) use (&$count) {
			if($value == 2 && $it == 1) {
				throw new BreakException;
			}
			$count += $value;
		});
		$this->assertEquals($count, 7);
	}

	public function test_cycle_continue() {
		$arr = array(1,2,3);
		$count = 0;
		enumerator::cycle($arr, 3, function($key, $value, $it) use (&$count) {
			if($value == 2 && $it == 1) {
				throw new ContinueException;
			}
			$count += $value;
		});
		$this->assertEquals($count, 16);
	}

	public function test_each_cons_break() {
		$arr = range(1,10);
		$count = 0;
		$o = enumerator::each_cons($arr, 8, function($key, $value) use(&$count) {
			if($value == 9) {
				throw new BreakException;
			}
			$count += $value;
		}); // 132
		$this->assertEquals($count, 71);
	}

	public function test_each_cons_continue() {
		$arr = range(1,10);
		$count = 0;
		$o = enumerator::each_cons($arr, 8, function($key, $value) use(&$count) {
			if($value == 9) {
				throw new ContinueException;
			}
			$count += $value;
		}); // 132
		$this->assertEquals($count, 114);
	}

	public function test_combinatoin_1() {
		$arr = array(1, 2, 3, 4);
		enumerator::combination_($arr, 1, function($key, &$value) {
			if($value[0] == 3) {
				throw new BreakException;
			}
			$value[0]++;
		});
		$this->assertEquals($arr, array(array(2), array(3), array(3), array(4)));
	}

	public function test_combinatoin_2() {
		$arr = array(1, 2, 3, 4);
		enumerator::combination_($arr, 1, function($key, &$value) {
			if($value[0] == 3) {
				throw new ContinueException;
			}
			$value[0]++;
		});
		$this->assertEquals($arr, array(array(2), array(3), array(3), array(5)));
	}
}