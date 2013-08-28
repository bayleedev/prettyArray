<?php
/**
 * Enumerator
 *
 * A object oriented approach to handling arrays in PHP.
 *
 * @package PrettyArray
 * @author Blaine Schmeisser <BlaineSch@gmail.com>
 */

namespace prettyArray;

use prettyArray\exceptions\BreakException;
use prettyArray\exceptions\ContinueException;
use BadMethodCallException;

/**
 * Enumerator
 *
 * A handy static class for handling array methods similar to the methods available to ruby.
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
 *
 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html
 */
class Enumerator {

	/**
	 * Will map their "alias" to their real method.
	 */
	protected static $methodMap = array(
		'array_slice' => 'drop',
		'find_all' => 'select',
		'keep_if' => 'select',
		'reduce' => 'inject',
		'include' => 'member',
		'flat_map' => 'collect_concat',
		'take' => 'first',
		'find' => 'detect',
		'size' => 'count',
		'length' => 'count',
		'array_walk' => 'each',
		'foreach' => 'each',
		'each_with_index' => 'each',
		'map' => 'collect',
		'reverse_each' => 'reverse_collect',
		'reverse_map' => 'reverse_collect',
		'reverse_foreach' => 'reverse_collect',
		'reverse_each_with_index' => 'reverse_collect',
		'concat' => 'merge',
		'sample' => 'random',
		'usort' => 'sort',
		'delete_if' => 'reject',
		'empty' => 'isEmpty',
		'find_index' => 'index',
		'array_unique' => 'uniq',
		'array_pluck' => 'array_column',
	);

	/**
	 * This is a list of destructive methods. Hard coded aliases will not be in this array.
	 * If the value is true, the edited array will be returned.
	 * If the value is false, the return value of the method call is returned.
	 */
	protected static $destructiveMap = array(
		'merge' => true,
		'drop' => true,
		'reverse_collect' => true,
		'inject' => false,
		'all' => false,
		'any' => false,
		'each' => true,
		'collect' => true,
		'count' => false,
		'detect' => false,
		'select' => true,
		'each_slice' => true,
		'first' => true,
		'collect_concat' => true,
		'grep' => true,
		'group_by' => true,
		'partition' => true,
		'reject' => true,
		'sort' => true,
		'sort_by' => true,
		'take_while' => true,
		'zip' => true,
		'drop_while' => true,
		'each_cons' => true,
		'slice_before' => true,
		'rotate' => true,
		'reverse' => true,
		'values_at' => true,
		'shuffle' => true,
		'random' => true,
		'index' => false,
		'rindex' => false,
		'compact' => true,
		'cycle' => true,
		'uniq' => true,
		'combination' => true,
		'delete' => false,
		'delete_at' => false,
		'flatten' => false,
		'array_column' => false,
		'slice' => true,
		'fill' => true,
	);

	/**
	 * Methods: get
	 *
	 * A generic getter method.
	 *
	 * @param string $name
	 * @return mixed
	 */
	public static function get($name) {
		if(isset(self::$$name)) {
			return self::$$name;
		}
		return;
	}

	/**
	 * Methods: __callStatic
	 *
	 * This magic method helps with method aliases and calling destrucitve methods in a non-destructive way.
	 * For example the real method "partition_" will take over your $array, but calling the magic method "partition" will not.
	 * All methods implemented in this class that have an underscore at the end are destructive and have a non-destructive alias.
	 *
	 * @param string $method The method name
	 * @param array $params An array of parrams you wish to pass
	 * @return mixed
	 */
	public static function __callStatic($method, $params) {
		// Make pass by reference methods/functions happy
		$params[0] =& $params[0];

		// Look for method Startup
		$destructiveCall = (substr($method, -1, 1) == "_"); // ture if a "_" is at the end of the method. example: "call_"
		$key = ($destructiveCall) ? substr($method, 0, -1) : $method; // Get the real name if they have a "_" at the end.
		$hasMethodMap = isset(self::$methodMap[$key]); // an alias exists
		$hasDestructiveMap = (!$hasMethodMap) ? isset(self::$destructiveMap[$key]) : isset(self::$destructiveMap[self::$methodMap[$key]]);
			// This may not be an alias, but a non-destructive method OR an alias to a non-destructive method.

		// Look for method logic
		if($hasMethodMap && !$hasDestructiveMap) {
			// Method alias
			$key = self::$methodMap[$key];
			return call_user_func_array(array(__CLASS__, $key), $params);
		} else if($hasDestructiveMap) {
			// Non-destructive call and possible alias
			$key = (($hasMethodMap) ? self::$methodMap[$key] : $key) . '_';
			$arrReturn = self::$destructiveMap[substr($key, 0, -1)];
			if($destructiveCall) {
				trigger_error("The alias '{$method}' cannot be destructive. Use it's non-alias form to be destructive: '{$key}'.", E_USER_NOTICE);
			}
			$ret = call_user_func_array(array(__CLASS__, $key), $params);
			return ($arrReturn) ? $params[0] : $ret;
		} else {
			throw new BadMethodCallException('Method ' . $method . ' does not exist.');
		}
		return;
	}

	/**
	 * Methods: all, all_
	 *
	 * Passes each element of the collection to the $callback, if it ever turns false or null this function will return false, else true.
	 *
	 * <code>
	 * $animals = array('ant', 'bear', 'cat');
	 * $o = Enumerator::all($animals, function($key, &$value) {
	 * 	return (strlen($value) >= 3);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * <code>
	 * $animals = array('ant', 'bear', 'cat');
	 * $o = Enumerator::all($animals, function($key, &$value) {
	 * 	return (strlen($value) >= 4);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * <code>
	 * $arr = array(null, true, 99);
	 * $o = Enumerator::all($arr);
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-all-3F
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return boolean
	 */
	public static function all_(array &$arr, $callback = null) {
		if(!is_callable($callback)) {
			$callback = function($key, $value) {
				return $value;
			};
		}
		foreach($arr as $key => &$value) {
			$ret = $callback($key, $value);
			if(is_null($ret) OR $ret === false) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Methods: drop, drop_
	 *
	 * Drops the first $count elements.
	 *
	 * <code>
	 * $animals = array('ant', 'bear', 'cat');
	 * $o = Enumerator::drop($animals, 1);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => bear
	 *     [1] => cat
	 * )
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop
	 * @param array &$arr
	 * @param int $count
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function drop_(array &$arr, $count) {
		$arr = array_slice($arr, $count);
		return;
	}

	/**
	 * Methods: any, any_
	 *
	 * Passes each element of the collection to the $callback, if it ever returns anything besides null or false I'll return true, else I'll return false.
	 *
	 * <code>
	 * $animals = array('ant', 'bear', 'cat');
	 * $o = Enumerator::any($animals, function($key, &$value) {
	 * 	return (strlen($value) >= 3);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * <code>
	 * $animals = array('ant', 'bear', 'cat');
	 * $o = Enumerator::any($animals, function($key, &$value) {
	 * 	return (strlen($value) >= 4);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * <code>
	 * $arr = array(null, true, 99);
	 * $o = Enumerator::any($arr);
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-any-3F
	 * @param array $arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return boolean
	 */
	public static function any_(array &$arr, $callback = null) {
		if(!is_callable($callback)) {
			$callback = function($key, $value) {
				return $value;
			};
		}
		foreach($arr as $key => &$value) {
			$ret = $callback($key, $value);
			if(!is_null($ret) && $ret !== false) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Methods: each, each_, foreach, foreach_, each_with_index, each_with_index_, array_walk
	 *
	 * Will iterate the elements in the array. Has the potential to change the values.
	 *
	 * <code>
	 * $arr = range(1,4);
	 * $o = Enumerator::each($arr, function($key, &$value) {
	 * 	$value *= $value;
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 4
	 *     [2] => 9
	 *     [3] => 16
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = range(1,4);
	 * $o = Enumerator::each($arr, function($key, &$value) {
	 * 	$value = "cat";
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => cat
	 *     [1] => cat
	 *     [2] => cat
	 *     [3] => cat
	 * )
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-each
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function array_walk_(array &$arr, $callback) {
		// Alias destructive method
		return self::each_($arr, $callback);
	}
	public static function each_with_index_(array &$arr, $callback) {
		// Alias destructive method
		return self::each_($arr, $callback);
	}
	public static function foreach_(array &$arr, $callback) {
		// Alias destructive method
		return self::each_($arr, $callback);
	}
	public static function each_(array &$arr, $callback) {
		foreach($arr as $key => &$value) {
			try {
				$callback($key, $value);
			} catch(BreakException $e) {
				break;
			} catch(ContinueException $e) {
				continue;
			}
		}
		return;
	}


	/**
	 * Methods: collect, collect_, map, map_
	 *
	 * Will iterate the elements in the array. The return value will modify the value.
	 *
	 * <code>
	 * $arr = range(1,4);
	 * $o = Enumerator::each($arr, function($key, &$value) {
	 * 	return $value * $value;
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 4
	 *     [2] => 9
	 *     [3] => 16
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = range(1,4);
	 * $o = Enumerator::each($arr, function($key, &$value) {
	 * 	return 'cat';
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => cat
	 *     [1] => cat
	 *     [2] => cat
	 *     [3] => cat
	 * )
	 * </pre>
	 * @link   http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-collect
	 * @param  array     &$arr
	 * @param  callable  $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return mixed               Nothing if called destructively, otherwise a new array.
	 */
	public static function map_(array &$arr, $callback) {
		// Alias destructive method
		return self::collect_($arr, $callback);
	}
	public static function collect_(array &$arr, $callback) {
		foreach($arr as $key => $value) {
			try {
				$arr[$key] = $callback($key, $value);
			} catch(BreakException $e) {
				break;
			} catch(ContinueException $e) {
				continue;
			}
		}
		return;
	}

	/**
	 * Methods: count, count_, size, size_, length, length_
	 *
	 * If the callback is null, this function give you the total size of the array.
	 * If the callback is a anonymous function, each time it returns 'true' will count as 1.
	 * Otherwise this function will count how many times $callback is equal to $value.
	 *
	 * <code>
	 * $arr = array(1,2,4,2);
	 * echo Enumerator::count($arr);
	 * </code>
	 * <pre>
	 * 4
	 * </pre>
	 *
	 * <code>
	 * $arr = array(1,2,4,2);
	 * echo Enumerator::count($arr, 2);
	 * </code>
	 * <pre>
	 * 2
	 * </pre>
	 *
	 * <code>
	 * $arr = array(1,2,4,2);
	 * echo Enumerator::count($arr, function($key, &$value) {
	 * 	return ($value % 2 == 0);
	 * });
	 * </code>
	 * <pre>
	 * 3
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Enumerable.html#method-i-count
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return int
	 */
	public static function size_(array &$arr, $callback) {
		// Alias destructive method
		return self::count_($arr, $callback);
	}
	public static function length_(array &$arr, $callback) {
		// Alias destructive method
		return self::count_($arr, $callback);
	}
	public static function count_(array &$arr, $callback = null) {
		if(is_null($callback)) {
			return count($arr);
		} else if(!is_callable($callback)) {
			$i = $callback;
			$callback = function($key, $value) use($i) {
				return ($value == $i);
			};
		}
		$total = 0;
		foreach($arr as $key => &$value) {
			if($callback($key, $value) === true) {
				$total++;
			}
		}
		return $total;
	}

	/**
	 * Methods: detect, detect_, find, find_
	 *
	 * Will pass the key and value to $callback the first result that does not return false is returned.
	 * If no results are found this function will return the result of $ifnone (mixed) if none is provided false will be returned.
	 *
	 * <code>
	 * $arr = range(1,10);
	 * $o = Enumerator::detect($arr, function($key, &$value) {
	 * 	return ($value % 5 == 0 and $value % 7 == 0);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * NULL
	 * </pre>
	 *
	 * <code>
	 * $arr = range(1,100);
	 * echo Enumerator::detect($arr, function($key, &$value) {
	 * 	return ($value % 5 == 0 and $value % 7 == 0);
	 * });
	 * </code>
	 * <pre>
	 * 35
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-detect
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @param mixed $ifnone
	 * @return mixed
	 */
	public static function find_(array &$arr, $callback, $ifnone = null) {
		// Alias destructive method
		return self::detect_($arr, $callback, $ifnone);
	}
	public static function detect_(array &$arr, $callback, $ifnone = null) {
		foreach($arr as $key => &$value) {
			if($callback($key, $value) !== false) {
				return $value;
			}
		}
		if(is_null($ifnone)) {
			return null;
		} else if(is_callable($ifnone)) {
			return $ifnone();
		}
		return $ifnone;
	}

	/**
	 * Methods: select, select_, find_all, find_all_, keep_if, keep_if_
	 *
	 * Will pass the elements to the callback and unset them if the callback returns false.
	 *
	 * <code>
	 * $arr = range(1,10);
	 * $o = Enumerator::select($arr, function($key, &$value) {
	 * 	return ($value % 3 == 0);
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [2] => 3
	 *     [5] => 6
	 *     [8] => 9
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-select
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return array Nothing if called destructively, otherwise a new array.
	 */
	public static function find_all_(array &$arr, $callback) {
		// Alias destructive method
		return self::select_($arr, $callback);
	}
	public static function keep_if_(array &$arr, $callback) {
		// Alias destructive method
		return self::select_($arr, $callback);
	}
	public static function select_(array &$arr, $callback) {
		foreach($arr as $key => &$value) {
			if($callback($key, $value) === false) {
				unset($arr[$key]);
			}
		}
		return;
	}

	/**
	 * Methods: each_slice, each_slice_
	 *
	 * Will slice the elements into $size collections and pass to $callback if defined. If not defined, the slized array is returned.
	 *
	 * <code>
	 * $arr = range(1,10);
	 * $o = Enumerator::each_slice($arr, 3, function(&$collection) {
	 * 	foreach($collection as $key => &$value) ++$value;
	 * 	return;
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 2
	 *             [1] => 3
	 *             [2] => 4
	 *         )
	 *
	 *     [1] => Array
	 *         (
	 *
	 *             [0] => 5
	 *             [1] => 6
	 *             [2] => 7
	 *         )
	 *
	 *     [2] => Array
	 *         (
	 *             [0] => 8
	 *             [1] => 9
	 *             [2] => 10
	 *         )
	 *
	 *     [3] => Array
	 *         (
	 *             [0] => 11
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-each_slice
	 * @param array &$arr
	 * @param int $size The size of each slice.
	 * @param mixed $callback The callback will be passed each collection. This can be passed by reference.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function each_slice_(array &$arr, $size, $callback = null) {
		$count = self::count($arr);
		$iterations = ceil($count/$size);
		$newArr = array();
		for($i = 0;$i<$iterations;$i++) {
			$newArr[] = array_slice($arr, $i * $size, $size);
		}
		if(is_callable($callback)) {
			foreach($newArr as &$item) {
				try {
					$callback($item);
				} catch(BreakException $e) {
					break;
				} catch(ContinueException $e) {
					continue;
				}
			}
		}
		$arr = $newArr;
		return;
	}

	/**
	 * Methods: first, first_
	 *
	 * Will overwrite $arr with the first $count items in array.
	 *
	 * <code>
	 * $animals = array('cat', 'dog', 'cow', 'pig');
	 * $o = Enumerator::first($animals);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => cat
	 * )
	 * </pre>
	 *
	 * <code>
	 * $animals = array('cat', 'dog', 'cow', 'pig');
	 * $o = Enumerator::first($animals, 2);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => cat
	 *     [1] => dog
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-first
	 * @param array &$arr
	 * @param int $count The number of items you wish to return. Defaults to 1
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function first_(array &$arr, $count = 1) {
		$arr = array_slice($arr, 0, $count, true);
		return;
	}

	/**
	 * Methods: collect_concat, collect_concat_, flat_map, flat_map_
	 *
	 * Will flatten the input $arr into a non-multi-dimensional array.
	 * It will pass the current key and the value to $callback which has the potential to change the value.
	 *
	 * <code>
	 * $arr = array(array(1,2),array(3,4));
	 * $o = Enumerator::collect_concat($arr, function($key, &$value) {
	 * 	return ++$value;
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 2
	 *     [1] => 3
	 *     [2] => 4
	 *     [3] => 5
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-flat_map
	 * @param array &$arr
	 * @param callable $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function flat_map_(array &$arr, $callback) {
		// Alias destructive method
		return self::collect_concat_($arr, $callback);
	}
	public static function collect_concat_(array &$arr, $callback) {
		$newArr = array();
		array_walk_recursive($arr, function(&$value, $key) use (&$newArr) {
			$newArr[] = $value;
		});
		foreach($newArr as $key => &$value) {
			try {
				$callback($key, $value);
			} catch(BreakException $e) {
				break;
			} catch(ContinueException $e) {
				continue;
			}
		}
		$arr = $newArr;
		return;
	}

	/**
	 * Methods: grep, grep_
	 *
	 * Will only keep an item if the value of the item matches $pattern.
	 * If a callback is provided, it will pass the $key and $value into the array.
	 *
	 * <code>
	 * $arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
	 * $o = Enumerator::grep($arr, "/^snow/");
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => snowball
	 *     [1] => snowcone
	 *     [2] => snowangel
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-grep
	 * @param array &$arr
	 * @param string $pattern The regex pattern.
	 * @param mixed $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function grep_(array &$arr, $pattern, $callback = null) {
		$arr = preg_grep($pattern, $arr);
		if(is_callable($callback)) {
			foreach($arr as $key => &$value) {
				try{
					$callback($key, $value);
				} catch(BreakException $e) {
					break;
				} catch(ContinueException $e) {
					continue;
				}
			}
		}
		return;
	}

	/**
	 * Methods: group_by, group_by_
	 *
	 * Each item will be passed into $callback and the return value will be the new "category" of this item.
	 * The param $arr will be replaced with an array of these categories with all of their items.
	 *
	 * <code>
	 * $arr = range(1,6);
	 * $o = Enumerator::group_by($arr, function($key, &$value) {
	 * 	return ($value % 3);
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 3
	 *             [1] => 6
	 *         )
	 *
	 *     [1] => Array
	 *         (
	 *             [0] => 1
	 *             [1] => 4
	 *         )
	 *
	 *     [2] => Array
	 *         (
	 *             [0] => 2
	 *             [1] => 5
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-group_by
	 * @param array &$arr
	 * @param callable $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @param boolean $preserve_keys If you want to preserve the keys or not.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function group_by_(array &$arr, $callback, $preserve_keys = false) {
		$newArr = array();
		foreach($arr as $key => &$value) {
			$category = $callback($key, $value);
			if(!isset($newArr[$category])) {
				$newArr[$category] = array();
			}
			if($preserve_keys) {
				$newArr[$category][$key] = $value;
			} else {
				$newArr[$category][] = $value;
			}
		}
		ksort($newArr);
		$arr = $newArr;
		return;
	}

	/**
	 * Methods: member, include
	 *
	 * This function will iterate over $arr, if any value is equal (===) to $needle this function will return true. If nothing is found this function will return false.
	 * NOTICE: that 'include' alias is a language construct so this alias cannot be called directly. Refer to example #2.
	 *
	 * <code>
	 * $arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
	 * $o = Enumerator::member($arr, 'snowcone');
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * <code>
	 * $arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
	 * $o = Enumerator::member($arr, 'snowman');
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * <code>
	 * $fun = 'include';
	 * $arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
	 * $o = Enumerator::$fun($arr, 'snowcone');
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-member-3F
	 * @param array $arr
	 * @param mixed $needle
	 * @return boolean
	 */
	public static function member(array $arr, $needle) {
		foreach($arr as $key => $value) {
			if($needle === $value) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Methods: min
	 *
	 * Will find the lowest value. If callback is defined it will compare them.
	 *
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * echo Enumerator::min($arr);
	 * </code>
	 * <pre>
	 * albatross
	 * </pre>
	 *
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * echo Enumerator::min($arr, function($val1, $val2) {
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * });
	 * </code>
	 * <pre>
	 * dog
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-min
	 * @param array $arr
	 * @param mixed optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
	 * @return mixed
	 */
	public static function min(array $arr, $callback = null) {
		if(!is_callable($callback)) {
			return min($arr);
		}
		usort($arr, $callback);
		return array_shift($arr);
	}

	/**
	 * Methods: max
	 *
	 * Will find the highest value. If callback is defined it will compare them.
	 *
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * echo Enumerator::max($arr);
	 * </code>
	 * <pre>
	 * horse
	 * </pre>
	 *
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * echo Enumerator::max($arr, function($val1, $val2) {
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * });
	 * </code>
	 * <pre>
	 * albatross
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-max
	 * @param array $arr
	 * @param callback optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
	 * @return mixed
	 */
	public static function max(array $arr, $callback = null) {
		if(!is_callable($callback)) {
			return max($arr);
		}
		usort($arr, $callback);
		return array_pop($arr);
	}

	/**
	 * Methods: min_by
	 *
	 * Will find the lowest item in the array but comparing the output os $callback against every item.
	 *
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * echo Enumerator::min_by($arr, function($val) {
	 * 	return strlen($val);
	 * });
	 * </code>
	 * <pre>
	 * dog
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-min_by
	 * @param array $arr
	 * @param callable $callback
	 * @return mixed
	 */
	public static function min_by(array $arr, $callback) {
		usort($arr, function($key1, $key2) use (&$callback) {
			return strcmp($callback($key1), $callback($key2));
		});
		return array_shift($arr);
	}

	/**
	 * Methods: max_by
	 *
	 * Will find the highest item in the array but comparing the output os $callback against every item.
	 *
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * echo Enumerator::max_by($arr, function($val) {
	 * 	return strlen($val);
	 * });
	 * </code>
	 * <pre>
	 * albatross
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-max_by
	 * @param array $arr
	 * @param callable $callback
	 * @return mixed
	 */
	public static function max_by(array $arr, $callback) {
		usort($arr, function($key1, $key2) use (&$callback) {
			return strcmp($callback($key1), $callback($key2));
		});
		return array_pop($arr);
	}

	/**
	 * Methods: minmax
	 *
	 * Will return an array of min and max. Optionally you can provide a callback to sort them.
	 *
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * $o = Enumerator::minmax($arr, function($val1, $val2) {
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => dog
	 *     [1] => albatross
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-minmax
	 * @param array $arr
	 * @param mixed optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
	 * @return array
	 */
	public static function minmax(array $arr, $callback = null) {
		if(!is_callable($callback)) {
			return max($arr);
		}
		usort($arr, $callback);
		return array(array_shift($arr), array_pop($arr));
	}

	/**
	 * Methods: minmax_by
	 *
	 * Will find the lowest and highest item in the array but comparing the output os $callback against every item.
	 *
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * $o = Enumerator::minmax_by($arr, function($val) {
	 * 	return strlen($val);
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => dog
	 *     [1] => albatross
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-minmax_by
	 * @param array $arr
	 * @param callable $callback
	 * @return array
	 */
	public static function minmax_by(array $arr, $callback) {
		usort($arr, function($key1, $key2) use (&$callback) {
			return strcmp($callback($key1), $callback($key2));
		});
		return array(array_shift($arr), array_pop($arr));
	}

	/**
	 * Methods: none
	 *
	 * Passes each element of the collection to $callback. This will return true if $callback never returns true, else false.
	 *
	 * <code>
	 * $arr = array('ant', 'bear', 'cat');
	 * $o = Enumerator::none($arr, function($key, $value) {
	 * 	return (strlen($value) == 5);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * <code>
	 * $arr = array('ant', 'bear', 'cat');
	 * $o = Enumerator::none($arr, function($key, $value) {
	 * 	return (strlen($value) >= 4);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * <code>
	 * $o = Enumerator::none(array());
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * <code>
	 * $o = Enumerator::none(array(null));
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * <code>
	 * $arr = array(null, false);
	 * $o = Enumerator::none($arr);
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-none-3F
	 * @param array $arr
	 * @param mixed $callback A $key, $value are passed to this callback.
	 * @return boolean
	 */
	public static function none(array $arr, $callback = null) {
		if(!is_callable($callback)) {
			$callback = function($key, $value) {
				return $value;
			};
		}
		foreach($arr as $key => &$value) {
			$ret = $callback($key, $value);
			if($ret === true) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Methods: one
	 *
	 * Pases each element of the collection to $callback. If $callback returns true once, the function will return true. Otherwise, the function will return false.
	 *
	 * <code>
	 * $arr = array('ant','bear','cat');
	 * $o = Enumerator::one($arr, function($key, $value) {
	 * 	return (strlen($value) == 4);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * <code>
	 * $o = Enumerator::one(array(null, true, 99));
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * <code>
	 * $o = Enumerator::one(array(null, true, false));
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-one-3F
	 * @param array $arr
	 * @param mixed $callback A $key, $value are passed to this callback.
	 * @return boolean
	 */
	public static function one(array $arr, $callback = null) {
		if(!is_callable($callback)) {
			$callback = function($key, $value) {
				return $value;
			};
		}
		$trueCount = 0;
		foreach($arr as $key => $value) {
			if((boolean)$callback($key, $value) == true) {
				if($trueCount == 1) {
					return false;
				}
				$trueCount++;
			}
		}
		return ($trueCount == 1);
	}

	/**
	 * Methods: partition, partition_
	 *
	 * Passes each element into $callback. If $callback returns true the item will be in the first category, otherwise the second.
	 *
	 * <code>
	 * $arr = range(1,6);
	 * $o = Enumerator::partition($arr, function($key, $value) {
	 * 	return ($value % 2 == 0);
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 2
	 *             [1] => 4
	 *             [2] => 6
	 *         )
	 *
	 *     [1] => Array
	 *         (
	 *             [0] => 1
	 *             [1] => 3
	 *             [2] => 5
	 *         )
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-partition
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback.
	 * @param boolean $preserve_keys
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function partition_(array &$arr, $callback, $preserve_keys = false) {
		$newArr = array(array(), array());
		foreach($arr as $key => &$value) {
			$category = !(int)(boolean)$callback($key, $value);
			if($preserve_keys) {
				$newArr[$category][$key] = $value;
			} else {
				$newArr[$category][] = $value;
			}
		}
		$arr = $newArr;
		return;
	}

	/**
	 * Methods: inject, inject_, reduce, reduce_
	 *
	 * Will iterate the items in $arr passing each one to $callback with $memo as the third argument.
	 *
	 * <code>
	 * $arr = range(5, 10);
	 * echo Enumerator::inject($arr, function($key, &$value, &$memo){
	 * 	$memo += $value;
	 * 	return;
	 * });
	 * </code>
	 * <pre>
	 * 45
	 * </pre>
	 *
	 * <code>
	 * $arr = range(5, 10);
	 * echo Enumerator::inject($arr, function($key, &$value, &$memo){
	 * 	$memo *= $value;
	 * 	return;
	 * }, 1);
	 * </code>
	 * <pre>
	 * 151200
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-inject
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback.
	 * @param mixed optional $memo This value is passed to all callback. Be sure to accept it by reference. Defaults to 0 (zero).
	 * @return mixed The memo variable.
	 */
	public static function reduce_(array &$arr, $callback, $memo = 0) {
		// Alias destructive method
		return self::inject_($arr, $callback, $memo);
	}
	public static function inject_(array &$arr, $callback, $memo = 0) {
		foreach($arr as $key => &$value) {
			try{
				$callback($key, $value, $memo);
			} catch(BreakException $e) {
				break;
			} catch(ContinueException $e) {
				continue;
			}
		}
		return $memo;
	}

	/**
	 * Methods: reject: reject_, delete_if, delete_if_
	 *
	 * Will unset an item in $arr if $callback returns true for it.
	 *
	 * <code>
	 * $arr = range(1,10);
	 * $o = Enumerator::reject($arr, function($key, $value) {
	 * 	return ($value % 3 == 0);
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 2
	 *     [3] => 4
	 *     [4] => 5
	 *     [6] => 7
	 *     [7] => 8
	 *     [9] => 10
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-reject
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback. The $value can be passed by reference.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function delete_if_(array &$arr, $callback) {
		// Alias destructive method
		self::reject_($arr, $callback);
	}
	public static function reject_(array &$arr, $callback) {
		foreach($arr as $key => &$value) {
			if($callback($key, $value)) {
				unset($arr[$key]);
			}
		}
		return;
	}

	/**
	 * Methods: reverse_collect, reverse_collect_, reverse_each, reverse_each_, reverse_map, reverse_map_, reverse_foreach, reverse_foreach_, reverse_each_with_index
	 *
	 * Will iterate the array in reverse, but will NOT save the order.
	 *
	 * <code>
	 * $arr = array(1, 2, 3);
	 * Enumerator::reverse_collect($arr, function($key, &$value) {
	 * 	echo $value . ', ';
	 * 	return;
	 * });
	 * </code>
	 * <pre>
	 * 3, 2, 1,
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-reverse_each
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback. The $value can be passed by reference.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function reverse_each_(array &$arr, $callback) {
		// Alias destructive method
		return self::reverse_collect_($arr, $callback);
	}
	public static function reverse_map_(array &$arr, $callback) {
		// Alias destructive method
		return self::reverse_collect_($arr, $callback);
	}
	public static function reverse_foreach_(array &$arr, $callback) {
		// Alias destructive method
		return self::reverse_collect_($arr, $callback);
	}
	public static function reverse_each_with_index_(array &$arr, $callback) {
		// Alias destructive method
		return self::reverse_collect_($arr, $callback);
	}
	public static function reverse_collect_(array &$arr, $callback) {
		for(end($arr);!is_null($key = key($arr));prev($arr)) {
			try {
				$callback($key, $arr[$key]);
			} catch(BreakException $e) {
				break;
			} catch(ContinueException $e) {
				continue;
			}
		}
		return;
	}

	/**
	 * Methods: sort, sort_
	 *
	 * Will sort the contents of $arr. A callback can be used to sort.
	 *
	 * <code>
	 * $arr = array('rhea', 'kea', 'flea');
	 * $o = Enumerator::sort($arr);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => flea
	 *     [1] => kea
	 *     [2] => rhea
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array('rhea', 'kea', 'flea');
	 * $o = Enumerator::sort($arr, function($val1, $val2) {
	 * 	return strcmp($val2, $val1);
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => rhea
	 *     [1] => kea
	 *     [2] => flea
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-sort
	 * @param array &$arr
	 * @param mixed $callback A $key, $value are passed to this callback. The $value can be passed by reference.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function sort_(array &$arr, $callback = null, $preserve_keys = false) {
		if(!is_callable($callback)) {
			sort($arr);
			return;
		}
		if($preserve_keys) {
			uasort($arr, $callback);
		} else {
			usort($arr, $callback);
		}
		return;
	}

	/**
	 * Methods: sort_by, sort_by_
	 *
	 * Will sort based off of the return of $callback.
	 *
	 * <code>
	 * $arr = array('rhea', 'kea', 'flea');
	 * $o = Enumerator::sort_by($arr, function($val) {
	 * 	return strlen($val);
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => kea
	 *     [1] => flea
	 *     [2] => rhea
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-sort_by
	 * @param array &$arr
	 * @param callable $callback
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function sort_by_(array &$arr, $callback, $preserve_keys = false) {
		$method = ($preserve_keys) ? 'uasort' : 'usort';
		$method($arr, function($key1, $key2) use ($callback) {
			return strcmp($callback($key1), $callback($key2));
		});
		return;
	}

	/**
	 * Methods: take_while, take_while_
	 *
	 * Passes elements into $callback until it returns false or null, at which point this function will stop and set $arr to all prior elements.
	 *
	 * <code>
	 * $arr = array(1,2,3,4,5,0);
	 * $o = Enumerator::take_while($arr, function($key, &$value) {
	 * 	return ($value < 3);
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 2
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-take_while
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function take_while_(array &$arr, $callback) {
		$i = 0;
		foreach($arr as $key => &$value) {
			$r = $callback($key, $value);
			if($r === false || is_null($r)) {
				$arr = array_slice($arr, 0, $i, true);
				return;
			}
			$i++;
		}
		return;
	}

	/**
	 * Methods: zip, zip_
	 *
	 * Will turn each element in $arr into an array then appending the associated indexs from the other arrays into this array as well.
	 *
	 * <code>
	 * $arr = array(1,2,3);
	 * $o = Enumerator::zip($arr, array(4,5,6), array(7,8,9));
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 1
	 *             [1] => 4
	 *             [2] => 7
	 *         )
	 *
	 *     [1] => Array
	 *         (
	 *             [0] => 2
	 *             [1] => 5
	 *             [2] => 8
	 *         )
	 *
	 *     [2] => Array
	 *        (
	 *
	 *             [0] => 3
	 *             [1] => 6
	 *             [2] => 9
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array(1,2);
	 * $o = Enumerator::zip($arr, array(4,5,6),array(7,8,9));
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 1
	 *             [1] => 4
	 *             [2] => 7
	 *         )
	 *
	 *     [1] => Array
	 *         (
	 *             [0] => 2
	 *             [1] => 5
	 *             [2] => 8
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array(4,5,6);
	 * $o = Enumerator::zip($arr, array(1,2), array(8));
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 4
	 *             [1] => 1
	 *             [2] => 8
	 *         )
	 *
	 *     [1] => Array
	 *         (
	 *             [0] => 5
	 *             [1] => 2
	 *             [2] =>
	 *         )
	 *
	 *     [2] => Array
	 *         (
	 *             [0] => 6
	 *             [1] =>
	 *             [2] =>
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-zip
	 * @param array &$arr
	 * @param array $one Unlimited of this.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function zip_(array &$arr, array $one) {
		$args = func_get_args();
		array_shift($args); // get $arr out of the way
		foreach($arr as $key => $value) {
			$arr[$key] = array($value);
			foreach($args as $k => $v) {
				$arr[$key][] = current($args[$k]);
				if(next($args[$k]) === false && $args[$k] != array(null)) {
					$args[$k] = array(null);
				}
			}
		}
		return;
	}

	/**
	 * Methods: drop_while, drop_while_
	 *
	 * Will pass elements into $callback until false is returned at which point all elements before the current one will be removed.
	 *
	 * <code>
	 * $arr = array(1,2,3,4,5,0);
	 * $o = Enumerator::drop_while($arr, function($key, &$value) {
	 * 	return ($value < 3);
	 * });
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 3
	 *     [1] => 4
	 *     [2] => 5
	 *     [3] => 0
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop_while
	 * @param array &$arr
	 * @param callable $callback
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function drop_while_(array &$arr, $callback) {
		$i = 0;
		foreach($arr as $key => &$value) {
			if($callback($key, $value) == false) {
				$arr = array_slice($arr, $i);
				return;
			}
			$i++;
		}
	}

	/**
	 * Methods: cycle, cycle_
	 *
	 * Will pass every element of $arr into $callback exactly $it times.
	 *
	 * <code>
	 * $arr = array(1,2,3);
	 * Enumerator::cycle($arr, 3, function($key, $value, $it) {
	 * 	echo $value . ',';
	 * });
	 * </code>
	 * <pre>
	 * 1,2,3,1,2,3,1,2,3,
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-cycle
	 * @param array $arr
	 * @param int $it
	 * @param callable $callback This can accept 3 arguments: $key - The key in the array, $value - The value of this key, $it - The current iteration.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function cycle_(array $arr, $it, $callback) {
		for($i = 0;$i<$it;$i++) {
			foreach($arr as $key => &$value) {
				try {
					$callback($key, $value, $i);
				} catch(BreakException $e) {
					return;
				} catch(ContinueException $e) {
					continue;
				}
			}
		}
		return;
	}

	/**
	 * Methods: each_cons, each_cons_
	 *
	 * This will return each section as an item in an array.
	 * A section is each consecutive $size of $arr.
	 * It will also iterate over each item in every section.
	 *
	 * <code>
	 * $arr = range(1,10);
	 * $o = Enumerator::each_cons($arr, 8);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 1
	 *             [1] => 2
	 *             [2] => 3
	 *             [3] => 4
	 *             [4] => 5
	 *             [5] => 6
	 *             [6] => 7
	 *             [7] => 8
	 *         )
	 *
	 *     [1] => Array
	 *         (
	 *             [0] => 2
	 *             [1] => 3
	 *             [2] => 4
	 *             [3] => 5
	 *             [4] => 6
	 *             [5] => 7
	 *             [6] => 8
	 *             [7] => 9
	 *         )
	 *
	 *     [2] => Array
	 *         (
	 *             [0] => 3
	 *             [1] => 4
	 *             [2] => 5
	 *             [3] => 6
	 *             [4] => 7
	 *             [5] => 8
	 *             [6] => 9
	 *             [7] => 10
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-each_cons
	 * @param array &$arr
	 * @param int $size
	 * @param mixed $callback
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function each_cons_(array &$arr, $size, $callback = null) {
		$newArr = array();
		$count = count($arr);
		$current = 0;
		$break = false;
		foreach($arr as $k => $v) {
			if($current + $size > $count) {
				break;
			}
			$newArr[$current] = array_slice($arr, $current, $size);
			if(is_callable($callback) && !$break) {
				foreach($newArr[$current] as $key => &$value) {
					try {
						$callback($key, $value, $current);
					} catch(BreakException $e) {
						$break = true;
						break;
					} catch(ContinueException $e) {
						continue;
					}
				}
			}
			$current++;
		}
		$arr = $newArr;
		return;
	}

	/**
	 * Methods: slice_before, slice_before_
	 *
	 * When $pattern is matched in an element, all previous elements not include previous chunks are placed into a new chunk.
	 *
	 * <code>
	 * $arr = array(1,2,3,4,5,6,7,8,9,0);
	 * $o = Enumerator::slice_before($arr, "/[02468]/"); // will "splice before" an even number.
	 * print_r($o);
	 * </code>
	 * <pre>
	 *
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 1
	 *         )
	 *
	 *     [1] => Array
	 *         (
	 *             [0] => 2
	 *             [1] => 3
	 *         )
	 *
	 *     [2] => Array
	 *         (
	 *             [0] => 4
	 *             [1] => 5
	 *         )
	 *
	 *     [3] => Array
	 *         (
	 *             [0] => 6
	 *             [1] => 7
	 *         )
	 *
	 *     [4] => Array
	 *         (
	 *             [0] => 8
	 *             [1] => 9
	 *         )
	 *
	 *     [5] => Array
	 *         (
	 *             [0] => 0
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-slice_before
	 * @param array &$arr
	 * @param string $pattern
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function slice_before_(array &$arr, $pattern) {
		$newArr = array();
		$follower = 0;
		$leader = 0;
		$size = count($arr);
		foreach($arr as $key => $value) {
			if(preg_match($pattern, $value, $matches) !== 0) {
				$newArr[] = array_slice($arr, $follower, $leader-$follower);
				$follower = $leader;
			}
			$leader++;
		}
		if($leader > $follower) {
			$newArr[] = array_slice($arr, $follower, $leader-$follower);
		}
		$arr = $newArr;
		return;
	}

	/**
	 * Methods: merge, merge_, concat, concat_
	 *
	 * Will merge two or more arrays together.
	 *
	 * <code>
	 * $animals = array('dog', 'cat', 'pig');
	 * $trees = array('pine');
	 * $o = Enumerator::merge($animals, $trees, array('wool'));
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => dog
	 *     [1] => cat
	 *     [2] => pig
	 *     [3] => pine
	 *     [4] => wool
	 * )
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-2B
	 * @param array &$arr
	 * @param array $arr2
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function concat_(array &$arr, array $arr2) {
		// Alias destructive method
		$params = func_get_args();
		$params[0] =& $arr;
		return call_user_func_array('Enumerator::merge_', $params);
	}
	public static function merge_(array &$arr, array $arr2) {
		$arr = call_user_func_array('array_merge', func_get_args());
		return;
	}

	/**
	 * Methods: rotate, rotate_
	 *
	 * Will rotate the array so that $index is the first element in the array. Negative indexs are allowed.
	 *
	 * <code>
	 * $arr = array('Foo', 'bar', 'foobar');
	 * $o = Enumerator::rotate($arr, 1);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => bar
	 *     [1] => foobar
	 *     [2] => Foo
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array('Foo', 'bar', 'foobar');
	 * $o = Enumerator::rotate($arr, -1);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => foobar
	 *     [1] => Foo
	 *     [2] => bar
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-rotate
	 * @param array &$arr
	 * @param int $index The starting index
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function rotate_(array &$arr, $index) {
		$arr = array_merge(array_slice($arr, $index), array_slice($arr, 0, $index));
		return;
	}

	/**
	 * Methods: reverse, reverse_
	 *
	 * Will reverse an array.
	 *
	 * <code>
	 * $arr = array(1,2,3);
	 * $o = Enumerator::reverse($arr);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 3
	 *     [1] => 2
	 *     [2] => 1
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-reverse
	 * @param array &$arr
	 * @param boolean optional $preserve_keys Defaults to false. If you want to preserve the keys or not.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function reverse_(array &$arr, $preserve_keys = false) {
		$arr = array_reverse($arr, $preserve_keys);
		return;
	}

	/**
	 * Methods: random, random_, sample, sample_
	 *
	 * Will get $count random values from $arr. If $count is 1 then it'll return the value, otherwise it'll return an array of values.
	 *
	 * <code>
	 * $arr = array('pig', 'cow', 'dog', 'horse');
	 * $o = Enumerator::random($arr);
	 * echo $o;
	 * </code>
	 * <pre>
	 * dog
	 * </pre>
	 *
	 * <code>
	 * $arr = array('pig', 'cow', 'dog', 'horse');
	 * $o = Enumerator::random($arr, 2);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => dog
	 *     [1] => cow
	 * )
	 * </pre>
	 *
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-sample
	 * @param array &$arr
	 * @param int optional $count Defaults to 1
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function sample_(array &$arr, $count = 1) {
		// Alias destructive method
		return self::random_($arr, $count);
	}
	public static function random_(array &$arr, $count = 1) {
		shuffle($arr);
		$ret = array_slice($arr, 0, $count, true);
		$arr = (count($ret) == 1) ? $ret[0] : $ret;
		return;
	}

	/**
	 * Methods: shuffle, shuffle_
	 *
	 * Will shuffle the inputted array.
	 *
	 * <code>
	 * $arr = array(1,2,3);
	 * $o = Enumerator::shuffle($arr);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 2
	 *     [1] => 1
	 *     [2] => 3
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array('a' => 'apple', 'b' => 'banana', 'c' => 'carrot');
	 * $o = Enumerator::shuffle($arr, true);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [a] => apple
	 *     [c] => carrot
	 *     [b] => banana
	 * )
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-shuffle
	 * @param array &$arr
	 * @param boolean $preserve_keys If you want to preserve keys or not. Defaults to false.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function shuffle_(array &$arr, $preserve_keys = false) {
		if(!$preserve_keys) {
			// Who needs keys anyways?
			shuffle($arr);
			return;
		}
		// Wait, hold on. I need keys! :o
		$ret = array();
		$keys = array_keys($arr);
		shuffle($keys);
		foreach($keys as $key) {
			$ret[$key] = $arr[$key];
		}
		$arr = $ret;
		return;
	}

	/**
	 * Methods: values_at, values_at_
	 *
	 * Will replace the current array with only the inserted indexs. Use the non-destructive form to get the array returned instead.
	 *
	 * <code>
	 * $name = array(
	 * 	'name' => 'John Doe',
	 * 	'first' => 'John',
	 * 	'middle' => 'M',
	 * 	'last' => 'Doe',
	 * 	'title' => 'Dr.'
	 * );
	 * $o = Enumerator::values_at($name, 'title', 'last');
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [title] => Dr.
	 *     [last] => Doe
	 * )
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-values_at
	 * @param array &$arr
	 * @param mixed $index Put in as many indexes as you please.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function values_at_(array &$arr, $index) {
		$ret = array();
		$keys = func_get_args();
		array_shift($keys);
		foreach($keys as $key) {
			$ret[$key] = isset($arr[$key]) ? $arr[$key] : null;
		}
		$arr = $ret;
		return;
	}

	/**
	 * Methods: empty, isEmpty
	 *
	 * If the array is empty or not.
	 * NOTICE: that 'empty' alias is a language construct so this alias cannot be called directly. Refer to example #3.
	 *
	 * <code>
	 * $arr = array();
	 * var_dump(Enumerator::isEmpty($arr));
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * <code>
	 * $arr = array(1,2,3);
	 * var_dump(Enumerator::isEmpty($arr));
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * <code>
	 * $empty = 'empty';
	 * $arr = array(1,2,3);
	 * var_dump(Enumerator::$empty($arr));
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * @param array $arr
	 * @return boolean
	 */
	public static function isEmpty(array $arr) {
		return (count($arr) == 0);
	}


	/**
	 * Methods: has_value
	 *
	 * Will return a boolean based on the condition that $value exists inside of $arr and are the same data type.
	 *
	 * <code>
	 * $arr = array(0,false);
	 * var_dump(Enumerator::has_value($arr, null));
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * <code>
	 * $arr = array(false,null);
	 * var_dump(Enumerator::has_value($arr, 0));
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * <code>
	 * $arr = array('apple', 'banana', 'orange');
	 * var_dump(Enumerator::has_value($arr, 'orange'));
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 *
	 * @param array $arr
	 * @param mixed $value
	 * @return boolean
	 */
	public static function has_value(array $arr, $value) {
		foreach($arr as $key => $val) {
			if($value === $val) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Methods: index, index_, find_index, find_index_
	 *
	 * Will return the first index if found or false otherwise. Use '===' for comparing.
	 * If $callback is a callback function, the $key is returned the first time $callback returns true.
	 * If $callback is not a callback, we are looking for the first $value in $arr to be === $callback.
	 *
	 * <code>
	 * $name = array(
	 * 	'name' => 'John Doe',
	 * 	'first' => 'John',
	 * 	'middle' => 'M',
	 * 	'last' => 'Doe',
	 * 	'title' => 'Dr.',
	 * 	'suffix' => 'Jr.'
	 * );
	 * echo Enumerator::index($name, 'John');
	 * </code>
	 * <pre>
	 * first
	 * </pre>
	 *
	 * <code>
	 * $name = array(
	 * 	'name' => 'John Doe',
	 * 	'first' => 'John',
	 * 	'middle' => 'M',
	 * 	'last' => 'Doe',
	 * 	'title' => 'Dr.',
	 * 	'suffix' => 'Jr.'
	 * );
	 * echo Enumerator::index_($name, function($key, &$value) {
	 * 	return (strpos($value, '.') !== false); // Has a decimal
	 * });
	 * </code>
	 * <pre>
	 * title
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-index
	 * @param array &$arr
	 * @param mixed $callback
	 * @return mixed
	 */
	public static function find_index_(array &$arr, $callback = null) {
		// Alias destructive method
		return self::index_($arr, $callback);
	}
	public static function index_(array &$arr, $callback = null) {
		if(!is_callable($callback)) {
			return array_search($callback, $arr);
		}
		foreach($arr as $key => &$value) {
			if($callback($key, $value) === true) {
				return $key;
			}
		}
		return false;
	}

	/**
	 * Methods: rindex, rindex_
	 *
	 * Similar to index but looks for the last occurace of $callback.
	 * If $callback is a callback function, the $key is returned the last time $callback returns true.
	 * If $callback is not a callback, we are looking for the last $value in $arr to be === $callback.
	 *
	 * <code>
	 * $name = array(
	 * 	'name' => 'John Doe',
	 * 	'first' => 'John',
	 * 	'middle' => 'M',
	 * 	'last' => 'Doe',
	 * 	'title' => 'Dr.',
	 * 	'suffix' => 'Jr.'
	 * );
	 * echo Enumerator::rindex($name, 'John');
	 * </code>
	 * <pre>
	 * first
	 * </pre>
	 *
	 * <code>
	 * $name = array(
	 * 	'name' => 'John Doe',
	 * 	'first' => 'John',
	 * 	'middle' => 'M',
	 * 	'last' => 'Doe',
	 * 	'title' => 'Dr.',
	 * 	'suffix' => 'Jr.'
	 * );
	 * echo Enumerator::rindex_($name, function($key, &$value) {
	 * 	return (strpos($value, '.') !== false);
	 * });
	 * </code>
	 * <pre>
	 * suffix
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-rindex
	 * @param array &$arr
	 * @param callable $callback
	 * @return mixed
	 */
	public static function rindex_(array &$arr, $callback) {
		$arr2 = array_reverse($arr);
		if(!is_callable($callback)) {
			return array_search($callback, $arr2);
		}
		foreach($arr2 as $key => $value) {
			$value =& $arr[$key];
			if($callback($key, $value) === true) {
				return $key;
			}
		}
		return false;
	}

	/**
	 * Methods: compact, compact_
	 *
	 * Will remove all null values inside of $arr. If $recursive is set to true, it will crawl sub-arrays.
	 *
	 * <code>
	 * $arr = array(1,2,3,null,array(2,3,4,null));
	 * $o = Enumerator::compact($arr);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 2
	 *     [2] => 3
	 *     [4] => Array
	 *         (
	 *             [0] => 2
	 *             [1] => 3
	 *             [2] => 4
	 *             [3] =>
	 *        )
	 *
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array(1,2,3,null,array(2,3,4,null));
	 * $o = Enumerator::compact($arr, true);
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 2
	 *     [2] => 3
	 *     [4] => Array
	 *         (
	 *             [0] => 2
	 *             [1] => 3
	 *             [2] => 4
	 *        )
	 *
	 * )
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-compact
	 * @param array &$arr
	 * @param boolean $recursive If you want this to iterate all child arrays.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function compact_(array &$arr, $recursive = false) {
		if(!$recursive) {
			foreach($arr as $key => $value) {
				if(is_null($value)) {
					unset($arr[$key]);
				}
			}
		} else {
			foreach($arr as $key => $value) {
				if(is_null($value)) {
					unset($arr[$key]);
				} else if(is_array($value)) {
					self::compact_($arr[$key], true);
				}
			}
		}
		return;
	}

	/**
	 * Methods: uniq, uniq_, array_unique, array_unique_
	 *
	 * Will force all itemsm in $arr to be unique.
	 *
	 * <code>
	 * $arr = array(1,1,2,3,3,2,1,1,1);
	 * $a = Enumerator::uniq($arr);
	 * print_r($a);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [2] => 2
	 *     [3] => 3
	 * )
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-uniq
	 * @param array &$arr
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function array_unique_(array &$arr) {
		// Alias destructive method
		return self::uniq_($arr);
	}
	public static function uniq_(array &$arr) {
		$arr = array_unique($arr);
		return;
	}

	/**
	 * Methods: assoc
	 *
	 * Searches through top level items, if the item is an array and the first value matches $search it'll return this element.
	 *
	 * <code>
	 * $s1 = array('color', 'red', 'blue', 'green');
	 * $s2 = array('letters', 'a', 'b', 'c');
	 * $s3 = 'foo';
	 * $arr = array($s1, $s2, $s3);
	 * $o = Enumerator::assoc($arr, 'letters');
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => letters
	 *     [1] => a
	 *     [2] => b
	 *     [3] => c
	 * )
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-assoc
	 * @param array $arr
	 * @param mixed $search
	 * @return mixed The found array, or null.
	 */
	public static function assoc(array $arr, $search) {
		foreach($arr as &$value) {
			if(is_array($value) && isset($value[0]) && $value[0] == $search) {
				return $value;
			}
		}
		return null;
	}

	/**
	 * Methods: rassoc
	 *
	 * Searches through top level items, if the item is an array and the second value matches $search it'll return this element.
	 *
	 * <code>
	 * $arr = array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two"));
	 * $o = Enumerator::rassoc($arr, 'two');
	 * print_r($o);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 2
	 *     [1] => two
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array(array(1, "one"), array(2, "two"), array(3, "three"), array("ii", "two"));
	 * $o = Enumerator::rassoc($arr, 'four');
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * NULL
	 * </pre>
	 *
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-rassoc
	 * @param array $arr
	 * @param mixed $search
	 * @return mixed The found array, or null.
	 */
	public static function rassoc(array $arr, $search) {
		foreach($arr as &$value) {
			if(is_array($value) && isset($value[1]) && $value[1] == $search) {
				return $value;
			}
		}
		return null;
	}

	/**
	 * Methods: at
	 *
	 * Will create an array from all the keys provided. If only one element exists that element is returned, otherwise the array is returned. If none exist, null is returned.
	 *
	 * <code>
	 * $arr = array('a', 'b', 'c', 'd', 'e');
	 * echo Enumerator::at($arr, 0);
	 * </code>
	 * <pre>
	 * a
	 * </pre>
	 *
	 * <code>
	 * $arr = array('a', 'b', 'c', 'd', 'e');
	 * echo Enumerator::at($arr, -1);
	 * </code>
	 * <pre>
	 * e
	 * </pre>
	 *
	 * <code>
	 * $arr = array('a', 'b', 'c', 'd', 'e');
	 * print_r(Enumerator::at($arr, 0, 3, 4));
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => a
	 *     [1] => d
	 *     [2] => e
	 * )
	 * </pre>
	 *
	 * @param array $arr
	 * @param mixed $key You can insert multiple keys. If they key is negative and doe snot belong in the array, it'll return that index from the end.
	 * @return mixed An item or an array
	 */
	public static function at(array $arr, $key) {
		$ret = array();
		$keys = array_slice(func_get_args(), 1);
		foreach($keys as $key) {
			if(isset($arr[$key])) {
				$ret[] = $arr[$key];
			} else if(is_numeric($key) && $key < 0) {
				$ret += array_slice($arr, $key, 1);
			}
		}
		$len = count($ret);
		if($len == 0) {
			return null;
		} else if($len == 1) {
			return $ret[0];
		}
		return $ret;
	}

	/**
	 * Methods: combination_, combination
	 *
	 * Will yield the various unique combinations of an array with a specific $limit.
	 *
	 * <code>
	 * $arr = array(1, 2, 3, 4);
	 * Enumerator::combination_($arr, 1);
	 * print_r($arr);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 1
	 *         )
	 *
	 *     [1] => Array
	 *         (
	 *             [0] => 2
	 *         )
	 *
	 *     [2] => Array
	 *         (
	 *             [0] => 3
	 *         )
	 *
	 *     [3] => Array
	 *         (
	 *             [0] => 4
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array(1, 2, 3, 4);
	 * Enumerator::combination_($arr, 4);
	 * print_r($arr);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *             [0] => 1
	 *             [1] => 2
	 *             [2] => 3
	 *             [3] => 4
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array(1, 2, 3, 4);
	 * Enumerator::combination_($arr, 0);
	 * print_r($arr);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => Array
	 *         (
	 *         )
	 *
	 * )
	 * </pre>
	 *
	 * @param array &$arr
	 * @param int $limit The number of items you wish to have per child element
	 * @param mixed $callback
	 * @return mixed
	 */
	public static function combination_(array &$arr, $limit, $callback = null, $level = 0, $size = null) {
		// Cache Size
		if(is_null($size)) {
			$size = count($arr);
		}

		// Preliminary
		$thisLevel = array();
		if($size == 0 || $limit == 0){
			// No value
			$thisLevel = array(array());
		} else if($limit == 1){
			// Returns so each item is in an array
			foreach($arr as $value){
				$thisLevel[] = array($value);
			}
		} else if($limit == $size) {
			// Same
			foreach($arr as $value) {
				$thisLevel[] = $value;
			}
			$thisLevel = array($thisLevel);
		} else {
			// Recursive building
			$nextLevel = self::combination($arr,$limit-1, null, $level+1, $size);
			foreach($nextLevel as $value) {
				$lastEl = $value[$limit-2];
				$found = false;
				foreach($arr as $key => $val) {
					if($val == $lastEl) {
						// Iterates until it finds it?
						$found = true;
						continue;
					}
					if($found == true) {
						// Found and add
						if($key < $size) {
							$t = $value;
							$t[] = $val;
							$thisLevel[] = $t;
						}
					}
				}
			}
		}
		if($level == 0 && is_callable($callback)) {
			foreach($thisLevel as $key => &$value) {
				try {
					$callback($key, $value);
				} catch(BreakException $e) {
					break;
				} catch(ContinueException $e) {
					continue;
				}
			}
		}
		$arr = $thisLevel;
		return;
	}

	/**
	 * Methods: delete_, delete
	 *
	 * Will delete every instance of $needle inside of $arr.
	 * If $needle is not found null is returned.
	 * If it is found and $callback is callable it's return value is returned.
	 * If it is found and $callback is not defined $needle is returned.
	 *
	 * <code>
	 * $arr = array('a','b', 'b', 'b', 'c');
	 * echo Enumerator::delete_($arr, 'b') . PHP_EOL;
	 * print_r($arr);
	 * </code>
	 * <pre>
	 * b
	 * Array
	 * (
	 * 	[0] => a
	 * 	[4] => c
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array('a','b', 'b', 'b', 'c');
	 * var_dump(Enumerator::delete_($arr, 'z'));
	 * </code>
	 * <pre>
	 * NULL
	 * </pre>
	 *
	 * <code>
	 * $arr = array('a','b', 'b', 'b', 'c');
	 * var_dump(Enumerator::delete($arr, 'z', function() {
	 * 	return false;
	 * }));
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 *
	 * @param array &$arr
	 * @param mixed $needle
	 * @param callable $callback
	 * @return mixed
	 */
	public static function delete_(array &$arr, $needle, $callback = null) {
		$found = false;
		foreach($arr as $key => &$value) {
			if($value === $needle) {
				$found = true;
				unset($arr[$key]);
			}
		}
		if(!$found && is_callable($callback)) {
			return $callback();
		} else if($found) {
			return $needle;
		}
		return;
	}

	/**
	 * Methods: delete_at_, delete_at
	 *
	 * Will delete the element at the specific index. If the element is found that element is returned, otherwise null is returned.
	 *
	 * <code>
	 * $arr = array('ant', 'bat', 'cat', 'dog');
	 * $ret = Enumerator::delete_at_($arr, 2);
	 * echo $ret . PHP_EOL;
	 * print_r($arr);
	 * </code>
	 * <pre>
	 * cat
	 * Array
	 * (
	 *     [0] => ant
	 *     [1] => bat
	 *     [3] => dog
	 * )
	 * </pre>
	 *
	 * <code>
	 * $arr = array('ant', 'bat', 'cat', 'dog');
	 * $ret = Enumerator::delete_at($arr, 99);
	 * var_dump($ret);
	 * </code>
	 * <pre>
	 * NULL
	 * </pre>
	 *
	 * @param array &$arr
	 * @param mixed $index
	 * @return mixed
	 */
	public static function delete_at_(array &$arr, $index) {
		if(isset($arr[$index])) {
			$ret = $arr[$index];
			unset($arr[$index]);
			return $ret;
		}
		return;
	}

	/**
	 * Methods: fetch_, fetch
	 *
	 * Will retrieve the value of the specific index. Will also retrieve negative index counting backwards.
	 * If $index is not found and $value is callable, the index is passed to it and it's return value is returned.
	 * If $index is not found and $value is not callable, $value is returned.
	 *
	 * <code>
	 * $arr = array(11, 22, 33, 44);
	 * echo Enumerator::fetch($arr, 1);
	 * </code>
	 * <pre>
	 * 22
	 * </pre>
	 *
	 * <code>
	 * $arr = array(11, 22, 33, 44);
	 * echo Enumerator::fetch($arr, -1);
	 * </code>
	 * <pre>
	 * 44
	 * </pre>
	 *
	 * <code>
	 * $arr = array(11, 22, 33, 44);
	 * echo Enumerator::fetch($arr, 4, 'cat');
	 * </code>
	 * <pre>
	 * cat
	 * </pre>
	 *
	 * <code>
	 * $arr = array(11, 22, 33, 44);
	 * echo Enumerator::fetch($arr, 4, function($i) {
	 * 	return $i * $i;
	 * });
	 * </code>
	 * <pre>
	 * 16
	 * </pre>
	 *
	 * @param array $arr
	 * @param mixed $index
	 * @param mixed $value
	 * @return mixed
	 */
	public static function fetch(array $arr, $index) {
		$args = func_get_args();
		$hasValue = (count($args) >= 3);
		$value = ($hasValue) ? $args[2] : null;
		$count = count($arr);

		if(isset($arr[$index])) {
			// Return found value
			return $arr[$index];
		} else if(is_numeric($index) && is_numeric($i = $count + $index) && isset($arr[$i])) {
			// Negative index
			return $arr[$i];
		} else if($hasValue && is_callable($value)) {
			// Return callback value
			return $value($index);
		} else if($hasValue) {
			// Return set value
			return $value;
		} else {
			// Throw exception
			throw new \OutOfBoundsException;
		}
		return;
	}

	/**
	 * Methods: flatten, flatten_
	 *
	 * Will flatten the array to a single array or until the $depth is reached.
	 *
	 * <code>
	 * $arr = array(1, 2, array(3, array(4, 5)));
	 * $arr = Enumerator::flatten($arr);
	 * echo print_r($arr, true) . PHP_EOL;
	 * $arr = Enumerator::flatten($arr);
	 * var_dump($arr);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 2
	 *     [2] => 3
	 *     [3] => 4
	 *     [4] => 5
	 * )
	 * NULL
	 * </pre>
	 *
	 * <code>
	 * $arr = array(1, 2, array(3, array(4, 5)));
	 * Enumerator::flatten_($arr, 1);
	 * print_r($arr);
	 * </code>
	 * <pre>
	 * Array
	 * (
	 *     [0] => 1
	 *     [1] => 2
	 *     [2] => 3
	 *     [3] => Array
	 *         (
	 *             [0] => 4
	 *             [1] => 5
	 *         )
	 * )
	 * </pre>
	 *
	 * @param array &$arr
	 * @param int $depth
	 * @return mixed
	 */
	public static function flatten_(array &$arr, $depth = 999999, $topLevel = true) {
		$newArr = array();
		if($depth > 0) {
			foreach($arr as $key => &$value) {
				if(is_array($value) && $depth > 0) {
					foreach($value as $sKey => &$sVal) {
						if(is_array($sVal) && $depth > 1) {
							$newArr = array_merge($newArr, self::flatten($sVal, $depth-1, false));
						} else {
							$newArr[] = $sVal;
						}
					}
				} else {
					$newArr[] = $value;
				}
			}
		}
		if($topLevel) {
			if($arr != $newArr) {
				$arr = $newArr;
				return $arr;
			}
			return;
		}
		return $arr;
	}

	/**
	 * Methods: array_column_, array_column, array_pluck_, array_pluck
	 *
	 * Will return an array of values from a multidimensional array based on the index provided.
	 *
	 * @param array &$arr
	 * @param mixed $index
	 * @return mixed
	 */
	public static function array_pluck_(array &$arr, $index) {
		// Alias destructive method
		return self::uniq_($arr, $index);
	}
	public static function array_column_(array &$arr, $index) {
		$newArr = array();
		foreach ($arr as $item) {
			if(is_array($item) && isset($item[$index])) {
				$newArr[] = $item[$index];
			}
		}
		$arr = $newArr;
		return;
	}

	/**
	 * Will slice an array.
	 *
	 * @param  array   $arr
	 * @param  integer $start  Optional assumes 0. The beginning index.
	 * @param  integer $length Optional assumes end of array. Length of slice.
	 * @return null
	 */
	public static function slice_(array &$arr, $start = 0, $length = false) {
		list($start, $length) = static::_determineRange($arr, $start, $length);
		$arr = array_slice($arr, $start, $length);
		return;
	}

	/**
	 * Fills an array with given values. Optional start and end values can be used.
	 *
	 * <code>
	 * $arr = array("a", "b", "c", "d");
	 * Enumerator::fill($arr, 'x');       // array('x', 'x', 'x', 'x')
	 * Enumerator::fill($arr, 'z', 2, 2); // array('a', 'b', 'z', 'z')
	 * Enumerator::fill($arr, function($index, $value) {
	 * 	return $index * $index;
	 * }); // array(0, 1, 4, 9)
	 *
	 * Enumerator::fill(2, 2, function() {
	 * 	return 'z';
	 * }); // array('a', 'b', 'z', 'z')
	 * </code>
	 *
	 * @param  array  $arr [description]
	 * @return [type]      [description]
	 */
	public static function fill_(array &$arr) {
		$args = array_slice(func_get_args(), 1);
		if (!is_callable($args[count($args) - 1])) {
			$ret = array_shift($args);
			$args[] = function() use (&$ret) {
				return $ret;
			};
		}
		$callback = array_pop($args);
		array_unshift($args, $arr);
		list($start, $length) = call_user_func_array(array(get_called_class(), '_determineRange'), $args);
		$oldSlice = array_slice($arr, $start, $length);
		$newSlice = Enumerator::collect($oldSlice, function($key, &$value) use(&$callback) {
			return $callback($key, $value);
		});
		array_splice($arr, $start, $length, $newSlice);
		return;
	}

	/**
	 * Determines the correct starting position, and length of an array.
	 *
	 * @param  array   $arr
	 * @param  integer $start  Optional assumes 0. The beginning index.
	 * @param  integer $length Optional assumes end of array. Length of slice.
	 * @return null
	 */
	protected static function _determineRange($arr, $start = 0, $length = false) {
		if ($length === false) {
			$length = ($start < 0) ? abs($start) : count($arr) - $start;
		}
		return array($start, $length);
	}
}