<?php

class PrettyArray implements ArrayAccess {

	/**
	 * Contains all the data.
	 */
	protected $data = array();

	/**
	 * These are function aliases.
	 * alias => function
	 */
	protected static $alias = array(
		'each' => 'map',
		'foreach' => 'map',
		'collect' => 'map',
		'reverse_each' => 'reverse_map',
		'reverse_foreach' => 'reverse_map',
		'reverse_collect' => 'reverse_map',
		'find_index' => 'index',
		'find_key' => 'index',
		'reject' => 'delete_if',
		'size' => 'count',
		'length' => 'count',
		'begin' => 'first',
		'rewind' => 'first',
		'end' => 'last',
		'previous' => 'prev',
		'empty' => 'clear',
		'include' => 'has_value',
		'join' => 'implode',
		'curr' => 'current',
		'sample' => 'random',
		'equals' => 'eql',
		'equal_to' => 'eql',
		'skip_to' => 'set_pointer',
		'reverse_array' => 'reverse',
		'array_reverse' => 'reverse',
		'key_exists' => 'offsetExists',
		'delete_at' => 'offsetUnset',
		'delete' => 'offsetUnset'
	);

	/**
	 * Constructor
	 * Will preset items based on parameters. No keys can currently be provided.
	 */
	public function __construct() {
		call_user_func_array(array($this, 'push'), func_get_args());
	}

	/**
	 * Will set a value based on the key and value provided.
	 * @param mixed $key 
	 * @param mixed $value 
	 * @return mixed
	 */
	public function offsetSet($key, $value) {
		if (is_null($key)) {
			$this->data[] = $value;
		} else {
			$this->data[$key] = $value;
		}
	}

	/**
	 * Part of ArrayAccess interface
	 * Will check if an array item exists based on it's key.
	 * @param mixed $key 
	 * @return mixed
	 */
	public function offsetExists($key) {
		return isset($this->data[$key]);
	}

	/**
	 * Part of ArrayAccess interface
	 * Will unset a current item based on a key.
	 * - Alias
	 * 	- delete_at
	 * 	- delete
	 * @param mixed $key 
	 * @return mixed
	 */
	public function offsetUnset($key) {
		unset($this->data[$key]);
	}

	/**
	 * Part of ArrayAccess interface
	 * Will get a current value based on a key.
	 * @param mixed $key 
	 * @return mixed
	 */
	public function offsetGet($key) {
		return isset($this->data[$key]) ? $this->data[$key] : null;
	}

	/**
	 * Does a print_r on the contents. Invoked by casting the object to a string.
	 * For example using "echo" on it.
	 * @return string
	 */
	public function __toString() {
		return print_r($this->data, true);
	}

	/**
	 *	Magic method to alias functions.
	 *	For Example "each" is the same as "map" and "foreach".
	 *	@return mixed
	 */
	public function __call($method, $args) {
		if(isset(self::$alias[$method])) {
			return call_user_func_array(array($this, self::$alias[$method]), $args);
		}
		trigger_error("Method not found.", E_USER_ERROR);
		return;
	}

	/**
	 * Will iterate all items in the array on the first level.
	 * <code>
	 * <?php
	 * $obj = new PrettyArray(1, 2, 3);
	 * $obj->map(function($key, &$value) {
	 * 		$value .= "rawr";
	 * });
	 * </code>
	 * - Alias
	 * 	- each
	 * 	- foreach
	 * 	- collect
	 * @param callable $callback
	 * @return PrettyArray $this (chainable) or a new PrettyArray
	 */
	public function map($callback) {
		if(!is_callable($callback)) {
			trigger_error("Valid callback not defined.", E_USER_ERROR);
			return;
		}
		foreach($this->data as $key => &$value) {
			$callback($key, $value);
		}
		return $this;
	}

	/**
	 * Will sort the array
	 * @link http://php.net/sort
	 * @param boolean $save If the array will be saved or returned.
	 * @return PrettyArray $this (chainable) or a new PrettyArray
	 */
	public function sort($save = false) {
		if(!$save) {
			$temp = clone $this;
			return ($temp->sort(true)) ? $temp : null;
		}
		sort($this->data);
		return $this;
	}

	/**
	 * Will sort an array based on a user function.
	 * @link http://php.net/usort
	 * @param callable $callback 
	 * @param boolean optional $save If you want the sort to save (true) or return (false). Defaults to false.
	 * @return PrettyArray $this (chainable) or a new PrettyArray
	 */
	public function usort($callback, $save = false) {
		if(!is_callable($callback)) {
			trigger_error("Valid callback not defined.", E_USER_ERROR);
			return;
		}
		if(!$save) {
			$temp = clone $this;
			return ($temp->usort($callback, true)) ? $temp : null;
		}
		usort($this->data, $callback);
		return $this;
	}

	/**
	 * Will find the key based on the input.
	 * You can either put in an index, or a callable function.
	 * <code>
	 * $obj = new PrettyArray('a', 'b', 'c');
	 * $obj->index("b"); // 1
	 * $obj->index(function($key, $value) {
	 * 	return ($value == "c");
	 * }); // 2
	 * </code>
	 * - Alias
	 * 	- find_key
	 * 	- find_index
	 * @param mixed $index 
	 * @return mixed Either the key (if found), or null.
	 */
	public function index($index) {
		if(is_callable($index)) {
			foreach($this->data as $key => &$value) {
				if($index($key, $value)) {
					return $key;
				}
			}
		} else {
			foreach($this->data as $key => &$value) {
				if($value == $index) {
					return $key;
				}
			}
		}
		return null;
	}

	/**
	 * The size of the current array.
	 * - Alias
	 * 	- size
	 * 	- length
	 * @return int
	 */
	public function count() {
		return count($this->data);
	}

	/**
	 * Will delete an element if the callback returns true.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * $obj->delete_if(function($key, $value) {
	 * 	// Deletes if the value has a lowercase 'a'
	 * 	return (strstr($value, 'a') !== false);
	 * }, true);
	 * </code>
	 * - Alias
	 * 	- reject
	 * @param callable $callback
	 * @param boolean $save Defaults to false. If you want to save this (true) or return it (false). 
	 * @return PrettyArray $this (chainable) or a new PrettyArray
	 */
	function delete_if($callback, $save = false) {
		if(!is_callable($callback)) {
			trigger_error("Valid callback not defined.", E_USER_ERROR);
			return;
		}
		if(!$save) {
			// Creates a new copy
			$temp = clone $this;
			return ($temp->delete_if($callback, true)) ? $temp : null;
		}
		foreach($this->data as $key => &$value) {
			if($callback($key, $value)) {
				$this->offsetUnset($key);
			}
		}
		return $this;
	}

	/**
	 * Will keep an element if the callback returns true.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * $obj->keep_if(function($key, $value) {
	 * 	// Keeps if the value has a lowercase 'a'
	 * 	return (strstr($value, 'a') !== false);
	 * });
	 * </code>
	 * @param callable $callback
	 * @param boolean $save Defaults to false. If you want to save this (true) or return it (false). 
	 * @return PrettyArray $this (chainable) or a new PrettyArray
	 */
	function keep_if($callback, $save = false) {
		if(!is_callable($callback)) {
			trigger_error("Valid callback not defined.", E_USER_ERROR);
			return;
		}
		if(!$save) {
			// Creates a new copy
			$temp = clone $this;
			return ($temp->keep_if($callback, true)) ? $temp : null;
		}
		foreach($this->data as $key => &$value) {
			if(!$callback($key, $value)) {
				$this->offsetUnset($key);
			}
		}
		return $this;
	}

	/**
	 * Will give you a new PrettyArray object with just the indexes you specify.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * $obj['tim'] = 'github';
	 * echo $obj->values_at(0, 2, 'tim'); // "Foo", "foobar", "github"
	 * </code>
	 * @param mixed $key The keys you wish to keep.
	 * @return PrettyArray object
	 */
	public function values_at($key) {
		$temp = new PrettyArray();
		foreach(func_get_args() as $key) {
			if(isset($this->data[$key])) {
				$temp[$key] = $this->data[$key];
			}
		}
		return $temp;
	}

	/**
	 * Will shuffle the array.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * echo $obj->shuffle(); // Array ( [0] => bar [1] => Foo [2] => foobar )
	 * echo $obj; // Array ( [0] => Foo [1] => bar [2] => foobar )
	 * </code>
	 * @param boolean $save If you want to save (true) or return (false) this shuffled PrettyArray.
	 * @return mixed
	 */
	public function shuffle($save = false) {
		if($save) {
			return shuffle($this->data);
		}
		$temp = clone $this;
		return ($temp->shuffle(true)) ? $temp : null;
	}

	/**
	 * Will rewind to the first element in the PrettyArray.
	 * - Alias
	 * 	- begin
	 * 	- rewind
	 * @link http://php.net/reset
	 * @return $this so it can be chained.
	 */
	public function first() {
		if(reset($this->data)) {
			current($this->data);
			return $this;
		}
		return false;
	}

	/**
	 * Will fast forward to the last element in the array.
	 * - Alias
	 * 	- end
	 * @link http://php.net/end
	 * @return $this so it can be chained.
	 */
	public function last() {
		end($this->data);
		return $this;
	}

	/**
	 * Will return the key of the current PrettyArray element.
	 * @link http://php.net/key
	 * @return mixed
	 */
	public function key() {
		return key($this->data);
	}

	/**
	 * Will return the value (and reposition) the next PrettyArray element.
	 * @link http://php.net/next
	 * @return $this so it can be chained.
	 */
	public function next() {
		next($this->data);
		return $this;
	}


	/**
	 * Will return the value of the current PrettyArray element.
	 * - Alias
	 * 	- curr
	 * @link http://php.net/current
	 * @return mixed
	 */
	public function current() {
		return current($this->data);
	}


	/**
	 * Will return the value (and reposition) the previous PrettyArray element.
	 * - Alias
	 * 	- previous
	 * @link http://php.net/prev
	 * @return $this so it can be chained.
	 */
	public function prev() {
		prev($this->data);
		return $this;
	}

	/**
	 * Advance the internal PrettyArray pointer to a specific index
	 * - Alias
	 * 	- skip_to
	 * @param int $index 
	 * @return int The real non-negative index
	 */
	public function set_pointer($index) {

		// Get index
		$count = $this->count();
		if($index == 0) {
			return $index;
		} else if($index < 0) {
			while($index < 0) {
				$index += $count;
			}
		} else {
			while($index >= $count) {
				$index -= $count;
			}
		}

		// Fast Forward
		$this->first(); // reset
		$i = 0;
		while($i != $index) {
			$this->next();
			$i++;
		}

		return $index;

	}

	/**
	 * Will clear all of the current data in the PrettyArray.
	 * - Alias
	 * 	- empty
	 * @return $this
	 */
	public function clear() {
		$this->data = array();
		return $this;
	}

	/**
	 * Will tell you if the current PrettyArray is empty or not.
	 * @return boolean
	 */
	public function isEmpty() {
		return ($this->count() === 0);
	}

	/**
	 * Will return true/false if the value exists in the base PrettyArray
	 * - Alias
	 * 	- include
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * $obj->include('bar'); // true
	 * $obj->include('github'); // false
	 * </code>
	 * @param mixed $val 
	 * @return boolean
	 */
	public function has_value($val) {
		foreach($this->data as $key => $value) {
			if($val == $value) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Will implode data for you.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * echo $obj->join(','); // Foo,bar,foobar
	 * </code>
	 * - Alias
	 * 	- join
	 * @param string $glue 
	 * @return string
	 */
	public function implode($glue = '') {
		return implode($glue, $this->data);
	}

	/**
	 * Will remove all null values from the array.
	 * <code>
	 * $obj = new PrettyArray('Foo', null, 'bar', 'foobar', null);
	 * echo $obj->compact(true)->rewind()->last()->curr(); // foobar
	 * </code>
	 * @param boolean $save If you wish to save (true) or return (false) a new PrettyArray.
	 * @return PrettyArray Either $this (chainable) or a new PrettyArray
	 */
	public function compact($save = false) {
		if(!$save) {
			$temp = clone $this;
			return ($temp->compact(true)) ? $temp : null;
		}
		foreach($this->data as $key => &$value) {
			if(is_null($value)) {
				unset($this->data[$key]);
			}
		}
		return $this;
	}

	/**
	 * Will return a random value from the PrettyArray.
	 * <code>
	 * $obj = new PrettyArray('Foo', null, 'bar', 'foobar', null);
	 * echo $obj->compact(true)->random(); // bar
	 * </code>
	 * - Alias
	 * 	- sample
	 * @return mixed
	 */
	public function random() {
		$keys = array_keys($this->data);
		shuffle($keys);
		return $this->data[current($keys)];
	}

	/**
	 * Will reverse the PrettyArray and preverse keys.
	 * - Alias
	 * 	- reverse_array
	 * 	- array_reverse
	 * @param boolean $save If you wish to save (true) or return (false) a new PrettyArray.
	 * @return PrettyArray Either $this (chainable) or a new PrettyArray
	 */
	public function reverse($save = false) {
		if(!$save) {
			$temp = clone $this;
			return ($temp->reverse(true)) ? $temp : null;
		}
		$this->data = array_reverse($this->data, true);
		return $this;
	}

	/**
	 * Will iterate over the PrettyArray in reverse.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * echo $obj->reverse_map(function($key, &$value) {
	 * 	$value .= '_';
	 * }); // foobar_, bar_, foo_
	 * </code>
	 * - Alias
	 * 	- reverse_each
	 * 	- reverse_foreach
	 * 	- reverse_collect
	 * @param callable $callback 
	 * @param boolean $save If you wish to save (true) or return (false) a new PrettyArray.
	 * @return PrettyArray Either $this (chainable) or a new PrettyArray
	 */
	public function reverse_map($callback, $save = false) {
		if(!is_callable($callback)) {
			trigger_error("Valid callback not defined.", E_USER_ERROR);
			return;
		}
		if(!$save) {
			// Don't save, make a new instance
			$temp = clone $this;
			return ($temp->reverse_map($callback, true)) ? $temp : null;
		}
		$this->data = array_reverse($this->data, true);
		foreach($this->data as $key => &$value) {
			$callback($key, $value);
		}
		return $this;
	}

	/**
	 * Will tell you if two PrettyArray classes match each other.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * $obj2 = $obj;
	 * $obj3 = new PrettyArray('Foo', 'bar');
	 * echo (int) $obj->eql($obj2); // true
	 * echo (int) $obj->eql($obj3); // false
	 * </code>
	 * - Alias
	 * 	- equals
	 * 	- equal_to
	 * @param PrettyArray $other 
	 * @return boolean
	 */
	public function eql(PrettyArray $other) {
		return ($this->data === $other->data);
	}

	/**
	 * Will push elements onto the end of the PrettyArray
	 * @link http://php.net/array_push
	 * @param mixed $value Any number of arguments you want to push onto the array.
	 * @return PrettyArray $this (chainable)
	 */
	public function push($value) {
		$params = func_get_args();
		array_unshift($params, ''); // Can't unshift by reference
		$params[0] =& $this->data;
		call_user_func_array("array_push", $params);
		return $this;
	}

	/**
	 * Will push elements onto the end of the PrettyArray
	 * @link http://php.net/array_push
	 * @param mixed $value Any number of arguments you want to push onto the array.
	 * @return PrettyArray $this (chainable)
	 */
	public function unshift($value) {
		$params = func_get_args();
		array_unshift($params, ''); // Can't unshift by reference
		$params[0] =& $this->data;
		call_user_func_array("array_unshift", $params);
		return $this;
	}

	/**
	 * Will pop, and return, an element off of the end of the PrettyArray.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * echo $obj->pop(); // foobar
	 * </code>
	 * @link http://www.php.net/manual/en/function.array-pop.php
	 * @return mixed
	 */
	public function pop() {
		return array_pop($this->data);
	}

	/**
	 * Will shift, and return, an element off of the beginning of the PrettyArray.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * echo $obj->shift(); // Foo
	 * </code>
	 * @link http://www.php.net/manual/en/function.array-shift.php
	 * @return mixed
	 */
	public function shift() {
		return array_shift($this->data);
	}

	/**
	 * Will slice the PrettyArray starting at $start for $length items.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * echo $obj->slice(1, 2); // bar, foobar
	 * </code>
	 * @param int $start 
	 * @param int $length 
	 * @param boolean $preserve_keys 
	 * @param boolean $save If you wish to save (true) or return (false) a new PrettyArray.
	 * @return PrettyArray Either $this (chainable) or a new PrettyArray
	 */
	public function slice($start, $length = null, $preserve_keys = false, $save = false) {
		if(!$save) {
			$temp = clone $this;
			return ($temp->slice($start, $length, $preserve_keys, true)) ? $temp : null;
		}
		$this->data = array_slice($this->data, $start, $length, $preserve_keys);
		return $this;
	}

	/**
	 * Will rotate the array so that $index is the first element in the array. Negative indexs are allowed.
	 * <code>
	 * $obj = new PrettyArray('Foo', 'bar', 'foobar');
	 * echo $obj->rotate(1); // bar, foobar, Foo
	 * echo $obj->rotate(-1); // foobar, Foo, bar
	 * </code>
	 * @param int $index
	 * @param boolean $save If you wish to save (true) or return (false) a new PrettyArray.
	 * @return PrettyArray Either $this (chainable) or a new PrettyArray
	 */
	public function rotate($index = 1, $save = false) {
		if(!$save) {
			$temp = clone $this;
			return ($temp->rotate($index, true)) ? $temp : null;
		}
		$index = $this->set_pointer($index);
		$this->data = array_merge($this->slice($index)->data, $this->slice(0, $index)->data);
		return $this;
	}
}