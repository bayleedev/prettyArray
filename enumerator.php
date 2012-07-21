<?php

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
 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html
 */
class enumerator {

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
		'array_walk' => 'collect',
		'each' => 'collect',
		'map' => 'collect',
		'foreach' => 'collect',
		'each_with_index' => 'collect',
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
		'array_unique' => 'uniq'
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
		'uniq' => true
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
			// They are clueless
			throw new BadMethodCallException();
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
	 * $o = enumerator::all($animals, function($key, &$value) {
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
	 * $o = enumerator::all($animals, function($key, &$value) {
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
	 * $o = enumerator::all($arr);
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
	 * $o = enumerator::drop($animals, 1);
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
	 * $o = enumerator::any($animals, function($key, &$value) {
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
	 * $o = enumerator::any($animals, function($key, &$value) {
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
	 * $o = enumerator::any($arr);
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
	 * Methods: collect, collect_, each, each_, map, map_, foreach, foreach_, each_with_index, each_with_index_, array_walk
	 * 
	 * Will iterate the elements in the array. Has the potential to change the values.
	 * 
	 * <code>
	 * $arr = range(1,4);
	 * $o = enumerator::collect($arr, function($key, &$value) {
	 * 	$value *= $value;
	 * 	return;
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
	 * $o = enumerator::collect($arr, function($key, &$value) {
	 * 	$value = "cat";
	 * 	return;
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
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-collect
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function array_walk_(array &$arr, $callback) {
		// Alias destructive method
		return self::collect_($arr, $callback);
	}
	public static function each_with_index_(array &$arr, $callback) {
		// Alias destructive method
		return self::collect_($arr, $callback);
	}
	public static function foreach_(array &$arr, $callback) {
		// Alias destructive method
		return self::collect_($arr, $callback);
	}
	public static function map_(array &$arr, $callback) {
		// Alias destructive method
		return self::collect_($arr, $callback);
	}
	public static function each_(array &$arr, $callback) {
		// Alias destructive method
		return self::collect_($arr, $callback);
	}
	public static function collect_(array &$arr, $callback) {
		foreach($arr as $key => &$value) {
			$callback($key, $value);
		}
		return;
	}

	/**
	 * Methods: count, count_, size, size_, length, length_
	 * 
	 * If the callback is null, this function give you the total size of the array.
	 * If the callback is a anonmous function, this function iterate the blocks and count how many times it returns true.
	 * Otherwise this function will count how many times $callback is equal to $value.
	 * 
	 * <code>
	 * $arr = array(1,2,4,2);
	 * echo enumerator::count($arr);
	 * </code>
	 * <pre>
	 * 4
	 * </pre>
	 * 
	 * <code>
	 * $arr = array(1,2,4,2);
	 * echo enumerator::count($arr, 2);
	 * </code>
	 * <pre>
	 * 2
	 * </pre>
	 * 
	 * <code>
	 * $arr = array(1,2,4,2);
	 * echo enumerator::count($arr, function($key, &$value) {
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
	 * $o = enumerator::detect($arr, function($key, &$value) {
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
	 * echo enumerator::detect($arr, function($key, &$value) {
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
	 * $o = enumerator::select($arr, function($key, &$value) {
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
	 * $o = enumerator::each_slice($arr, 3, function(&$collection) {
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
	 * @param callable $callback The callback will be passed each collection. This can be passed by reference.
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
				$callback($item);
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
	 * $o = enumerator::first($animals);
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
	 * $o = enumerator::first($animals, 2);
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
	 * Will flatten the input $arr into a non-multi-dimensional array.It will pass the current key and the value to $callback which has the potential to change the value.
	 * The new array will have discarded all current keys.
	 * 
	 * <code>
	 * $arr = array(array(1,2),array(3,4));
	 * $o = enumerator::collect_concat($arr, function($key, &$value) {
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
		array_walk_recursive($arr, function(&$value, $key) use (&$callback, &$newArr) {
			$callback($key, $value);
			$newArr[] = $value;
		});
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
	 * $o = enumerator::grep($arr, "/^snow/");
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
	 * @param callable $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function grep_(array &$arr, $pattern, $callback = null) {
		$arr = preg_grep($pattern, $arr);
		if(is_callable($callback)) {
			foreach($arr as $key => &$value) {
				$callback($key, $value);
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
	 * $o = enumerator::group_by($arr, function($key, &$value) {
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
	 * $o = enumerator::member($arr, 'snowcone');
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 * 
	 * <code>
	 * $arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
	 * $o = enumerator::member($arr, 'snowman');
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 * 
	 * <code>
	 * $fun = 'include';
	 * $arr = array('snowball', 'snowcone', 'snowangel', 'igloo', 'ice');
	 * $o = enumerator::$fun($arr, 'snowcone');
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
	 * echo enumerator::min($arr);
	 * </code>
	 * <pre>
	 * albatross
	 * </pre>
	 * 
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * echo enumerator::min($arr, function($val1, $val2) {
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * });
	 * </code>
	 * <pre>
	 * dog
	 * </pre>
	 * 
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-min
	 * @param array $arr
	 * @param callback optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
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
	 * echo enumerator::max($arr);
	 * </code>
	 * <pre>
	 * horse
	 * </pre>
	 * 
	 * <code>
	 * $arr = array('albatross','dog','horse');
	 * echo enumerator::max($arr, function($val1, $val2) {
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
	 * echo enumerator::min_by($arr, function($val) { 
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
	 * echo enumerator::max_by($arr, function($val) {
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
	 * $o = enumerator::minmax($arr, function($val1, $val2) { 
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
	 * @param callback optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
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
	 * $o = enumerator::minmax_by($arr, function($val) { 
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
	 * $o = enumerator::none($arr, function($key, $value) {
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
	 * $o = enumerator::none($arr, function($key, $value) {
	 * 	return (strlen($value) >= 4);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 * 
	 * <code>
	 * $o = enumerator::none(array());
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 * 
	 * <code>
	 * $o = enumerator::none(array(null));
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 * 
	 * <code>
	 * $arr = array(null, false);
	 * $o = enumerator::none($arr);
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 * 
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-none-3F
	 * @param array $arr 
	 * @param callable $callback A $key, $value are passed to this callback.
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
	 * $o = enumerator::one($arr, function($key, $value) {
	 * 	return (strlen($value) == 4);
	 * });
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 * 
	 * <code>
	 * $o = enumerator::one(array(null, true, 99));
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 * 
	 * <code>
	 * $o = enumerator::one(array(null, true, false));
	 * var_dump($o);
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 * 
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-one-3F
	 * @param array $arr 
	 * @param callable $callback A $key, $value are passed to this callback.
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
	 * $o = enumerator::partition($arr, function($key, $value) {
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
	 * echo enumerator::inject($arr, function($key, &$value, &$memo){
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
	 * echo enumerator::inject($arr, function($key, &$value, &$memo){
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
			$callback($key, $value, $memo);
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
	 * $o = enumerator::reject($arr, function($key, $value) {
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
	 * enumerator::reverse_collect($arr, function($key, &$value) {
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
			$callback($key, $arr[$key]);
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
	 * $o = enumerator::sort($arr);
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
	 * $o = enumerator::sort($arr, function($val1, $val2) {
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
	 * @param callable $callback A $key, $value are passed to this callback. The $value can be passed by reference.
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
	 * $o = enumerator::sort_by($arr, function($val) {
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
	 * $o = enumerator::take_while($arr, function($key, &$value) {
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
	 * $o = enumerator::zip($arr, array(4,5,6), array(7,8,9));
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
	 * $o = enumerator::zip($arr, array(4,5,6),array(7,8,9));
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
	 * $o = enumerator::zip($arr, array(1,2), array(8));
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
	 * $o = enumerator::drop_while($arr, function($key, &$value) {
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
	 * enumerator::cycle($arr, 3, function($key, $value, $it) {
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
				$callback($key, $value, $i);
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
	 * $o = enumerator::each_cons($arr, 8);
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
	 * @param callable $callback 
	 * @return mixed Nothing if called destructively, otherwise a new array.
	 */
	public static function each_cons_(array &$arr, $size, $callback = false) {
		$newArr = array();
		$count = count($arr);
		$current = 0;
		foreach($arr as $k => $v) {
			if($current + $size > $count) {
				break;
			}
			$newArr[$current] = array_slice($arr, $current, $size);
			if(is_callable($callback)) {
				foreach($newArr[$current] as $key => &$value) {
					$callback($key, $value, $current);
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
	 * $o = enumerator::slice_before($arr, "/[02468]/"); // will "splice before" an even number.
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
	 * $o = enumerator::merge($animals, $trees, array('wool'));
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
		return call_user_func_array('enumerator::merge_', $params);
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
	 * $o = enumerator::rotate($arr, 1);
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
	 * $o = enumerator::rotate($arr, -1);
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
	 * $o = enumerator::reverse($arr);
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
	 * $o = enumerator::random($arr);
	 * echo $o;
	 * </code>
	 * <pre>
	 * dog
	 * </pre>
	 * 
	 * <code>
	 * $arr = array('pig', 'cow', 'dog', 'horse');
	 * $o = enumerator::random($arr, 2);
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
	 * $o = enumerator::shuffle($arr);
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
	 * $o = enumerator::shuffle($arr, true);
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
	 * $o = enumerator::values_at($name, 'title', 'last');
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
			$ret[$key] = $arr[$key];
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
	 * var_dump(enumerator::isEmpty($arr));
	 * </code>
	 * <pre>
	 * bool(true)
	 * </pre>
	 * 
	 * <code>
	 * $arr = array(1,2,3);
	 * var_dump(enumerator::isEmpty($arr));
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 * 
	 * <code>
	 * $empty = 'empty';
	 * $arr = array(1,2,3);
	 * var_dump(enumerator::$empty($arr));
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
	 * var_dump(enumerator::has_value($arr, null));
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 * 
	 * <code>
	 * $arr = array(false,null);
	 * var_dump(enumerator::has_value($arr, 0));
	 * </code>
	 * <pre>
	 * bool(false)
	 * </pre>
	 * 
	 * <code>
	 * $arr = array('apple', 'banana', 'orange');
	 * var_dump(enumerator::has_value($arr, 'orange'));
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
	 * echo enumerator::index($name, 'John');
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
	 * echo enumerator::index_($name, function($key, &$value) {
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
	 * echo enumerator::rindex($name, 'John');
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
	 * echo enumerator::rindex_($name, function($key, &$value) {
	 * 	return (strpos($value, '.') !== false);
	 * });
	 * </code>
	 * <pre>
	 * suffix
	 * </pre>
	 * 
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-rindex
	 * @param array &$arr 
	 * @param mixed $callback 
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
	 * $o = enumerator::compact($arr);
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
	 * $o = enumerator::compact($arr, true);
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
	 * $a = enumerator::uniq($arr);
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
}