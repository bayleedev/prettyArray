<?php
/**
 * PrettyArray
 * 
 * An object oriented approach to array development.
 * 
 * @author Blaine Schmeisser <BlaineSch@gmail.com>
 */

// Dependencies
include('enumerator.php');

/**
 * PrettyArray
 * 
 * This class does not have very much in it, and is planning on staying that way. Instead, it makes magic calls to the 'enumerator' class.
 * All methods in enumerator are static, which allows this class to call them statically or non-statically making PrettyArray very versatile.
 * When you are calling methods in enumerator it will always append the current array to the paramater list.
 * 
 * @see PrettyArray::__call()
 * @see PrettyArray::__callStatic()
 */
class PrettyArray implements ArrayAccess {

	/**
	 * The real data
	 */
	protected $data = array();
	
	/**
	 * Currently only one mixin, but this might change.
	 */
	protected static $mixins = 'enumerator';
	
	/**
	 * Remaps non-destructive methods to their destructive counter parts.
	 */
	protected static $destructiveMap = array(
		'getRange' => 'getRange_',
		'getSet' => 'getSet_'
	);

	/**
	 * The default array can be passed as the first argument in the constructor.
	 * @param array optional $defaults 
	 */
	public function __construct(array $defaults = array()) {
		$this->data = $defaults;
	}


	/**
	 * Method: offsetSet
	 * 
	 * Part of ArrayAccess. Allows PrettyArray to set a value based on the [] operator.
	 * 
	 * <code>
	 * $arr = new PrettyArray();
	 * $arr[] = 'new'; // magic of this method
	 * $arr->offsetSet(null, 2);
	 * </code>
	 * 
	 * @param mixed $key 
	 * @param mixed $value 
	 * @return $value
	 */
	public function offsetSet($key, $value) {
		if(is_null($key)) {
			$this->data[] = $value;
		} else {
			$this->data[$key] = $value;
		}
		return $value;
	}

	/**
	 * Method: offsetExists
	 * 
	 * Part of ArrayAccess. If the offest exists.
	 * 
	 * <code>
	 * $arr = new PrettyArray();
	 * $arr[0] = 'foobar';
	 * var_dump(isset($arr[0])); // true
	 * var_dump($arr->offsetExists(0)); // true
	 * </code>
	 * 
	 * @param mixed $key 
	 * @return boolean
	 */
	public function offsetExists($key) {
		return (isset($this->data[$key]));
	}

	/**
	 * Method: offsetUnset
	 * 
	 * Part of ArrayAccess. Will unset the value if it exists.
	 * 
	 * <code>
	 * $arr = new PrettyArray();
	 * $arr[0] = 'foobar';
	 * unset($arr[0]);
	 * $arr[1] = 'foo';
	 * $arr->offsetUnset(1);
	 * print_r($arr); // array()
	 * </code>
	 * 
	 * @param mixed $key 
	 * @return void
	 */
	public function offsetUnset($key) {
		if(isset($this->data[$key])) {
			unset($this->data[$key]);
		}
		return;
	}

	/**
	 * Method: offsetGet
	 * 
	 * Part of ArrayAccess. Will get the value of the current offset.
	 * 
	 * <code>
	 * $arr = new PrettyArray();
	 * $arr[0] = 'foobar';
	 * echo $arr[0]; // foobar
	 * echo $arr->offsetGet(0); // foobar
	 * </code>
	 * 
	 * @param type $key 
	 * @return type
	 */
	public function offsetGet($key) {
		return (isset($this->data[$key])) ? $this->data[$key] : null;
	}

	/**
	 * Methods: __call
	 * 
	 * This serves two purposes.
	 * The first is that it helps the destructive methods in this class become non-destructive giving them aliases.
	 * The second is that is also proxies/mixins the static enumerable methods to non-static calls on this class and appends the current array as the first param.
	 * 
	 * <code>
	 * $arr = [1,2,3];
	 * enumerator::collect_($arr, function($key, &$value) {
	 * 	$value++;
	 * 	return;
	 * });
	 * print_r($arr); // 2,3,4
	 * 
	 * $arr = new PrettyArray($arr);
	 * $arr->collect_(function($key, &$value) {
	 * 	$value--;
	 * 	return;
	 * });
	 * print_r($arr); // 1,2,3
	 * </code>
	 * 
	 * @param string $method 
	 * @param array $params 
	 * @return mixed
	 */
	public function __call($method, $params) {

		if(isset(self::$destructiveMap[$method])) {
			// Destructive
			$ret = call_user_func_array(array($this, self::$destructiveMap[$method]), $params);
		} else {
			// Mixin
			array_unshift($params, 0);
			$params[0] =& $this->data;
			try {
				$ret = call_user_func_array(array(self::$mixins, $method), $params);
			} catch(BadMethodCallException $e) {
				throw $e;
			}
		}
		return $ret;
	}

	/**
	 * Methods: __callStatic
	 * 
	 * A basic proxy for static methods on enumerator.
	 * 
	 * <code>
	 * $arr = [1,2,3];
	 * 
	 * enumerator::collect($arr, function($key, &$value) {
	 * 	echo $value;
	 * }); // 123
	 * 
	 * PrettyArray::collect($arr, function($key, &$value) {
	 * 	echo $value;
	 * }); // 123
	 * </code>
	 * 
	 * @param string $method 
	 * @param array $params 
	 * @return mixed
	 */
	public static function __callStatic($method, $params) {
		return call_user_func_array(array(self::$mixins, $method), $params);
	}

	/**
	 * Will get a 'range' from PrettyArray. Calling it destructively will force the return value to be references to the current PrettyArray.
	 * 
	 * <code>
	 * $arr = new PrettyArray(['swamp', 'desert', 'snow', 'rain', 'fog']);
	 * $arr->getSet(1,3); // [ 1 => desert, 2 => snow, 3 => rain]
	 * </code>
	 * 
	 * <code>
	 * $arr = new PrettyArray();
	 * $arr['nasty'] = 'swamp';
	 * $arr['hot'] = 'desert';
	 * $arr['cold'] = 'snow';
	 * $arr[] = 'rain';
	 * $arr[] = 'fog';
	 * $arr->getRange('hot', 0); // [ hot => desert, cold => snow, 0 => rain ]
	 * </code>
	 * 
	 * @param mixed $start 
	 * @param mixed $end 
	 * @return PrettyArray
	 */
	public function getRange_($start, $end) {
		$ret = new PrettyArray();
		$collecting = false;
		$start = (string)$start;
		$end = (string)$end;
		foreach($this->data as $key => &$value) {
			$key = (string)$key;
			if($start == $key || $collecting) {
				$collecting = true;
				$ret->setByReference($key, $value);
				if($end == $key) {
					break;
				}
			}
		}
		return $ret;
	}

	/**
	 * Methods: getSet, getSet_
	 * 
	 * Will get a 'set' from PrettyArray. Calling it destructively will force the return value to be references to the current PrettyArray.
	 * 
	 * <code>
	 * $arr = new PrettyArray([1,2,3,4,5]);
	 * $arr->getSet(1, 2); //[ 1 => 2, 2 => 3 ]
	 * </code>
	 * 
	 * @param mixed $start 
	 * @param int $length 
	 * @return PrettyArray
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-slice
	 */
	public function getSet_($start, $length) {
		$ret = new PrettyArray();
		$count = 0;
		foreach($this->data as $key => &$value) {
			if($start == $key || $count > 0) {
				$ret->setByReference($key, $value);
				$count++;
				if($count == $length) {
					break;
				}
			}
		}
		return $ret;
	}

	/**
	 * By default you can't set by reference. This helps you do so.
	 * @param mixed $key 
	 * @param mixed &$value 
	 * @return $value from before
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-slice
	 */
	public function setByReference($key, &$value) {
		if(is_null($key)) {
			$this->data[] =& $value;
		} else {
			$this->data[$key] =& $value;
		}
		return $value;
	}

	/**
	 * Method: __toString
	 * 
	 * Converts the PrettyArray into a print_r string.
	 * 
	 * <code>
	 * $arr = new PrettyArray([1,2,3]);
	 * echo $arr; // Array ( [0] => 1 [1] => 2 [2] => 3 )
	 * </code>
	 */
	public function __toString() {
		return print_r($this->data, true);
	}

	/**
	 * Methods: to_a
	 * 
	 * Will return the array of data that PrettyArray has stored.
	 * 
	 * <code>
	 * $arr = new PrettyArray([1,2,3]);
	 * print_r($arr->to_a()); // Array ( [0] => 1 [1] => 2 [2] => 3 )
	 * </code>
	 * 
	 * @return array
	 */
	public function to_a() {
		return $this->data;
	}
}