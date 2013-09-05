<?php
/**
 * PrettyArray
 *
 * A object oriented approach to handling arrays in PHP.
 *
 * @package PrettyArray
 * @author Blaine Schmeisser <BlaineSch@gmail.com>
 */

namespace prettyArray;

use prettyArray\Enumerator;
use ArrayAccess;
use Iterator;
use Countable;

/**
 * PrettyArray
 *
 * This class does not have very much in it, and is planning on staying that way. Instead, it makes magic calls to the 'enumerator' class.
 * All methods in enumerator are static, which allows this class to call them statically or non-statically making PrettyArray very versatile.
 * When you are calling methods in enumerator through PrettyArray non-statically it will always prepend the current array to the paramater list.
 *
 * Destructive methods
 * -------------------
 * Some methods that this class provides are 'destructive' similar to methods in Ruby that end in an exclamation mark (!).
 * Every destructive methods has a 'magic' alias which allow for non-destructive calls.
 *
 * For example the method 'count_' has a callback which could modify the array, even though it never returns it.
 * The method 'select_' returns nothing by default and simply modifies the input array, however it's non-destructive alias would return the array.
 * The underscore is simply an extra precaution.
 *
 * Method Aliases
 * --------------
 * Methods often have various aliases which are pointed out in the documentation. They work identically to the real function call.
 *
 * Continue / Break
 * ----------------
 * You can throw new continue/break statements as exceptions. You can throw them in the following methods and their respective aliases:
 * * collect
 * * each_slice
 * * collect_concat
 * * grep
 * * inject
 * * reverse_collect
 * * cycle
 * * each_cons
 *
 * Throwing a continue:
 * <code>
 * 	throw new ContinueException;
 * </code>
 *
 * Throwing a break:
 * <code>
 * 	throw new BreakException;
 * </code>
 */
class PrettyArray implements ArrayAccess, Iterator, Countable {

	/**
	 * The real data
	 */
	protected $data = array();

	/**
	 * The data position.
	 *
	 * @var integer
	 */
	protected $position = 0;

	/**
	 * Currently only one mixin, but this might change.
	 */
	protected static $mixins = 'prettyArray\Enumerator';

	/**
	 * Remaps non-destructive methods to their destructive counter parts.
	 */
	protected static $destructiveMap = array(
		'getRange' => 'getRange_',
		'getSet' => 'getSet_'
	);

	/**
	 * Caches the enumerator data. This is used to tell if we should chain the method or not.
	 */
	protected static $enumData = array(
		'methodMap' => null,
		'destructiveMap' => null
	);

	/**
	 * The default array can be passed as the first argument in the constructor.
	 * @param array optional $defaults
	 */
	public function __construct($defaults = array()) {
		if(is_null(self::$enumData['methodMap'])) {
			self::$enumData['methodMap'] = Enumerator::get('methodMap');
			self::$enumData['destructiveMap'] = Enumerator::get('destructiveMap');
		}
		$this->position = 0;
		$this->data = is_array($defaults) ? $defaults : array_filter(func_get_args());
	}

	/**
	 * Methods: chain
	 *
	 * Determines if the given method supports chaining.
	 *
	 * @param string $method The method you are testing.
	 * @return bool If the method does not exist false is returned.
	 */
	protected function chain($method) {
		// Is destructive
		if(substr($method, -1) == '_') {
			// The non-destructive name
			$method = substr($method, 0, -1);

			// Absolute name
			if(isset(self::$enumData['methodMap'][$method])) {
				$method = self::$enumData['methodMap'][$method];
			}

			// Give back return value
			if(isset(self::$enumData['destructiveMap'][$method])) {
				return self::$enumData['destructiveMap'][$method];
			}
		}

		// Default return
		return false;
	}


	/**
	 * Methods: offsetSet
	 *
	 * Part of ArrayAccess. Allows PrettyArray to set a value based on the [] operator.
	 *
	 * <code>
	 * $arr = new PrettyArray();
	 * $arr[] = 'new';
	 * $arr->offsetSet(null, 2);
	 * print_r($arr->to_a());
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => new
	 *     [1] => 2
	 * )
	 * </pre>
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
	 * Methods: offsetExists
	 *
	 * Part of ArrayAccess. If the offest exists.
	 *
	 * <code>
	 * $arr = new PrettyArray();
	 * $arr[0] = 'foobar';
	 * var_dump(isset($arr[0])); // true
	 * var_dump($arr->offsetExists(0)); // true
	 * </code>
	 * <pre>
	 * bool(true)
	 * bool(true)
	 * </pre>
	 *
	 * @param mixed $key
	 * @return boolean
	 */
	public function offsetExists($key) {
		return (isset($this->data[$key]));
	}

	/**
	 * Methods: offsetUnset
	 *
	 * Part of ArrayAccess. Will unset the value if it exists.
	 *
	 * <code>
	 * $arr = new PrettyArray();
	 * $arr[0] = 'foobar';
	 * unset($arr[0]);
	 * $arr[1] = 'foo';
	 * $arr->offsetUnset(1);
	 * print_r($arr->to_a());
	 * </code>
	 * <pre>
	 * Array
	 * (
	 * )
	 * </pre>
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
	 * Methods: offsetGet
	 *
	 * Part of ArrayAccess. Will get the value of the current offset.
	 *
	 * <code>
	 * $arr = new PrettyArray();
	 * $arr[0] = 'foobar';
	 * echo $arr[0] . PHP_EOL;
	 * echo $arr->offsetGet(0);
	 * </code>
	 * <pre>
	 * foobar
	 * foobar
	 * </pre>
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
	 * $arr = array(1,2,3);
	 * Enumerator::collect_($arr, function($key, &$value) {
	 * 	$value++;
	 * 	return;
	 * });
	 * print_r($arr);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 2
	 *     [1] => 3
	 *     [2] => 4
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = new PrettyArray(array(2,3,4));
	 * $arr->collect_(function($key, &$value) {
	 * 	$value--;
	 * 	return;
	 * });
	 * print_r($arr->to_a());
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 2
	 *     [2] => 3
	 * )
	 * </pre>
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
			$isDestructive = (substr($method, -1) == '_');
			if($isDestructive) {
				array_unshift($params, 0);
				$params[0] =& $this->data;
			} else {
				array_unshift($params, $this->data);
			}
			$ret = call_user_func_array(array(self::$mixins, $method), $params);
		}
		if(is_array($ret)) {
			// Chainable non-destructive
			$ret = new PrettyArray($ret);
		} else if($this->chain($method)) {
			// Chainable destructive
			return $this;
		}
		// Typical returns
		return $ret;
	}

	/**
	 * Methods: __callStatic
	 *
	 * A basic proxy for static methods on enumerator.
	 *
	 * <code>
	 * $arr = array(1,2,3);
	 * Enumerator::collect($arr, function($key, &$value) {
	 * 	echo $value;
	 * });
	 * </code>
	 * <pre>
	 * 123
	 * </pre>
	 *
	 * <code>
	 * $arr = array(1,2,3);
	 * PrettyArray::collect($arr, function($key, &$value) {
	 * 	echo $value;
	 * });
	 * </code>
	 * <pre>
	 * 123
	 * </pre>
	 *
	 * @param string $method
	 * @param array $params
	 * @return mixed
	 */
	public static function __callStatic($method, $params) {
		$isDestructive = (substr($method, -1) == '_');
		if($isDestructive) {
			trigger_error("Statically calling an enumerator method '{$method}' via the PrettyArray proxy cannot be used destructively. Either use the enumerator class, or this method non-statically.", E_USER_NOTICE);
			$params[0] =& $params[0];
		}
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
	 *
	 * $o = $arr->getRange('hot', 0)->to_a();
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [hot] => desert
	 *     [cold] => snow
	 *     [0] => rain
	 * )
	 * </pre>
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
	 * $arr = new PrettyArray(array(1,2,3,4,5));
	 * $o = $arr->getSet(1, 2)->to_a();
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [1] => 2
	 *     [2] => 3
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-slice
	 * @param mixed $start
	 * @param int $length
	 * @return PrettyArray
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
	 * Methods: setByReference
	 *
	 * By default you can't set by reference. This helps you do so.
	 *
	 * <code>
	 * $arr = new PrettyArray();
	 * $a = 'foo';
	 * $arr->setByReference('a', $a);
	 * $a = 'bar';
	 * echo $arr['a'];
	 * </code>
	 * <pre>
	 * bar
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-slice
	 * @param mixed $key
	 * @param mixed &$value
	 * @return $value from before
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
	 * $arr = new PrettyArray(array(1,2,3));
	 * echo $arr;
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 2
	 *     [2] => 3
	 * )
	 * </pre>
	 *
	 * @return string
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
	 * $arr = new PrettyArray(array(1,2,3));
	 * print_r($arr->to_a());
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 2
	 *     [2] => 3
	 * )
	 * </pre>
	 *
	 * @return array
	 */
	public function to_a() {
		return $this->data;
	}

	/**
	 * Rewind the current position. Part of the Iterator interface.
	 *
	 * @return null
	 */
	public function rewind() {
		$this->position = 0;
	}

	/**
	 * Rewind the current position. Part of the Iterator interface.
	 *
	 * @return null
	 */
	public function current() {
		return $this->data[$this->key()];
	}

	/**
	 * Retrieve the current key. Part of the Iterator interface.
	 *
	 * @return null
	 */
	public function key() {
		$keys = array_keys($this->data);
		return isset($keys[$this->position]) ? $keys[$this->position] : null;
	}

	/**
	 * Increase the pointer position. Part of the Iterator interface.
	 *
	 * @return null
	 */
	public function next() {
		++$this->position;
	}

	/**
	 * Validate the current pointer. Part of the Iterator interface.
	 *
	 * @return null
	 */
	public function valid() {
		return isset($this->data[$this->key()]);
	}

	/**
	 * Counts the number of items in the array. Part of the Countable interface.
	 *
	 * @return int
	 */
	public function count() {
		return $this->__call('count', func_get_args());
	}

}