<?php
/**
 * PrettyArray
 * 
 * An object oriented approach to array development.
 * 
 * @author Blaine Schmeisser <BlaineSch@gmail.com>
 */

/**
 * A handy class for handling array methods similar to the methods available to ruby.
 * 
 * Destructive Methods:
 * There are "destructive" methods which are identified by the "_" at the end of the method name.
 * These methods will overwrite the $array passed to them.
 * 
 * To get around this, I have added many "alias" magic methods which all destructive methods have.
 * Just remove the ending '_' and instaed of overwriting the array it'll return it.
 * 
 * Method Alias':
 * Some methods contain "alias" methods that have different names then it like "find_all" points to "select".
 * If you attempt to use a destructive call on an alias like "find_all_" it will not be destructive and it will throw a warning.
 * 
 * @todo change examples to be 5.3 compatiable
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
		'concat' => 'concat',
		'sample' => 'random',
		'usort' => 'sort',
		'delete_if' => 'reject',
		'empty' => 'isEmpty',
		'find_index' => 'index'
	);

	/**
	 * The method exists if the key exists and will be checked in __callStatic.
	 * If the value is true, the edited array will be returned.
	 * If the value is false, the return value of the method call is returned.
	 */
	protected static $destructiveMap = array(
		'merge' => true,
		'drop' => true,
		'reverse_collect' => false,
		'inject' => false,
		'all' => false,
		'any' => false,
		'collect' => true,
		'count' => false,
		'detect' => false,
		'find_index' => false,
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
		'cycle' => true
	);

	/**
	 * This magic method helps with method alias' and calling destrucitve methods in a non-destructive way.
	 * For example the real method "partition_" will take over your $array, but calling the magic method "partition" will not.
	 * All methods implemented in this class that have an underscore at the end are destructive and have a non-destructive alias.
	 * 
	 * @param string $method The method name
	 * @param array $params  An array of parrams you wish to pass
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
	 * enumerator::all($animals, function($key, &$value) {
	 * 	return (strlen($value) >= 3);
	 * }); // true
	 * enumerator::all($animals, function($key, &$value) {
	 * 	return (strlen($value) >= 4);
	 * }); // false
	 * enumerator::all(array(null, true, 99)); // false
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return boolean
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-all-3F
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
	 * enumerator::drop($animals, 1); // bear, cat
	 * </code>
	 * 
	 * @param array &$arr
	 * @param int $count
	 * @link http://www.ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop
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
	 * enumerator::any($animals, function($key, &$value) {
	 * 	return (strlen($value) >= 3);
	 * }); // true
	 * enumerator::any($animals, function($key, &$value) {
	 * 	return (strlen($value) >= 4);
	 * }); // true
	 * enumerator::any(array(null, true, 99)); // true
	 * </code>
	 * 
	 * @param array $arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return boolean
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-any-3F
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
	 * Methods: collect, collect_, each, map, foreach, each_with_index, array_walk
	 * 
	 * Will iterate the elements in the array. Has the potential to change the values.
	 * 
	 * <code>
	 * $arr = range(1,4);
	 * enumerator::collect($arr, function($key, &$value) {
	 * 	$value *= $value;
	 * 	return;
	 * }); // [1, 4, 9, 16]
	 * enumerator::collect($arr, function($key, &$value) {
	 * 	$value = "cat";
	 * 	return;
	 * }); // ["cat", "cat", "cat", "cat"]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-collect
	 */
	public static function collect_(array &$arr, $callback) {
		foreach($arr as $key => &$value) {
			$callback($key, $value);
		}
		return;
	}

	/**
	 * Methods: count, count_, size, length
	 * 
	 * If the callback is null, this function give you the total size of the array.
	 * If the callback is a anonmous function, this function iterate the blocks and count how many times it returns true.
	 * Otherwise this function will count how many times $callback is equal to $value.
	 * 
	 * <code>
	 * $arr = [1,2,4,2];
	 * echo enumerator::count($arr); // 4
	 * echo enumerator::count($arr, 2); // 2
	 * echo enumerator::count($arr, function($key, &$value) {
	 * 	return ($value % 2 == 0);
	 * }); // 3
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return int
	 * @link http://www.ruby-doc.org/core-1.9.3/Enumerable.html#method-i-count
	 */
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
	 * Methods, detect, detect_, find
	 * 
	 * Will pass the key and value to $callback the first result that does not return false is returned.
	 * If no results are found this function will return the result of $ifnone (mixed) if none is provided false will be returned.
	 * 
	 * <code>
	 * enumerator::detect(range(1,10), function($key, &$value) {
	 * 	return ($value % 5 == 0 and $value % 7 == 0);
	 * }); // null
	 * enumerator::detect(range(1,100), function($key, &$value) {
	 * 	return ($value % 5 == 0 and $value % 7 == 0);
	 * }); // 35
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @param mixed $ifnone 
	 * @return mixed
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-detect
	 */
	public static function detect_(array &$arr, $callback, $ifnone = null) {
		foreach($arr as $key => &$value) {
			if($callback($key, $value) !== false) {
				return $value;
			}
		}
		if(is_null($ifnone)) {
			return false;
		} else if(is_callable($ifnone)) {
			return $ifnone();
		}
		return $ifnone;
	}

	/**
	 * Methods: select, select_, find_all, keep_if
	 * 
	 * Will pass the elements to the callback and unset them if the callback returns false.
	 * 
	 * <code>
	 * $arr = range(1,10);
	 * enumerator::select($arr,function($key, &$value) {
	 * 	return ($value % 3 == 0);
	 * }); // [3, 6, 9]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return array The array that has already been edited by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-select
	 */
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
	 * enumerator::each_slice(range(1,10), 3, function(&$collection) {
	 * 	foreach($collection as $key => &$value) ++$value;
	 * 	return;
	 * }); // [[2,3,4], [5,6,7], [8,9,10], [11]]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param int $size The size of each slice.
	 * @param callable $callback The callback will be passed each collection. This can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-each_slice
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
	 * Methods: find_index, find_index_
	 * 
	 * If $callback is callable, this function will pass each item into $callback and return the first index that $callback returns true on.
	 * If $callback is not callable and is an index inside of $arr, this function will return it's value.
	 * If not found nothing is returned.
	 * 
	 * <code>
	 * $less = range(1,10);
	 * $more = range(1,100);
	 * enumerator::find_index($less, function($key, &$value) {
	 * 	return ($value % 5 == 0 && $value % 7 == 0);
	 * }); // null
	 * enumerator::find_index($more, function($key, &$value) {
	 * 	return ($value % 5 == 0 && $value % 7 == 0);
	 * }); // 34
	 * enumerator::find_index($more, 50); // 49
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @return mixed
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-find_index
	 */
	public static function find_index_(array &$arr, $callback) {
		if(is_callable($callback)) {
			foreach($arr as $key => &$value) {
				if($callback($key, $value) === true) {
					return $key;
				}
			}
		} else if(isset($arr[$callback])) {
			return array_search($callback, $arr);
		}
		return;
	}

	/**
	 * Methods: first, first_
	 * 
	 * Will overwrite $arr with the first $count items in array.
	 * 
	 * <code>
	 * $animals = ['cat', 'dog', 'cow', 'pig'];
	 * enumerator::first($animals); // cat
	 * enumerator::first($animals, 2); // cat, dog
	 * </code>
	 * 
	 * @param array &$arr
	 * @param int $count The number of items you wish to return. Defaults to 1
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-first
	 */
	public static function first_(array &$arr, $count = 1) {
		$arr = array_slice($arr, 0, $count, true);
		return;
	}

	/**
	 * Methods: collect_concat, collect_concat_, flat_map
	 * 
	 * Will flatten the input $arr into a non-multi-dimensional array.It will pass the current key and the value to $callback which has the potential to change the value.
	 * The new array will have discarded all current keys.
	 * 
	 * <code>
	 * $arr = [[1,2],[3,4]];
	 * enumerator::collect_concat($arr, function($key, &$value) {
	 * 	return ++$value;
	 * }); // [2,3,4,5]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-flat_map
	 */
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
	 * $arr = ['snowball', 'snowcone', 'snowangel', 'igloo', 'ice'];
	 * enumerator::grep($arr, "/^snow/"); // [snowball, snowcone, snowangel]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param string $pattern The regex pattern.
	 * @param callable $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-grep
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
	 * enumerator::group_by($arr, function($key, &$value) {
	 * 	return ($value % 3);
	 * }); // [[3,6],[1,4],[2,5]]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @param boolean $preserve_keys If you want to preserve the keys or not.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-group_by
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
	 * $arr = ['snowball', 'snowcone', 'snowangel', 'igloo', 'ice'];
	 * enumerator::member($arr, 'snowcone'); // true
	 * enumerator::member($arr, 'snowman'); // false
	 * </code>
	 * 
	 * <code>
	 * $fun = 'include';
	 * $arr = ['snowball', 'snowcone', 'snowangel', 'igloo', 'ice'];
	 * enumerator::$fun($arr, 'snowcone'); // true
	 * enumerator::$fun($arr, 'snowman'); // false
	 * </code>
	 * 
	 * @param array $arr
	 * @param mixed $needle 
	 * @return boolean
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-member-3F
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
	 * $array = array('albatross','dog','horse');
	 * enumerator::min($array); // albatross
	 * $array = array('albatross','dog','horse');
	 * enumerator::min($array, function($val1, $val2) {
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * }); // dog
	 * </code>
	 * 
	 * @param array $arr
	 * @param callback optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
	 * @return mixed
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-min
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
	 * $array = array('albatross','dog','horse');
	 * enumerator::max($array); // horse
	 * $array = array('albatross','dog','horse');
	 * enumerator::max($array, function($val1, $val2) {
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * }); // albatross
	 * </code>
	 * 
	 * @param array $arr
	 * @param callback optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
	 * @return mixed
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-max
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
	 * $array = array('albatross','dog','horse'); 
	 * enumerator::min_by($array, function($val) { 
	 * 	return strlen($val); 
	 * }); // dog 
	 * </code>
	 * 
	 * @param array $arr
	 * @param callable $callback
	 * @return mixed
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-min_by
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
	 * $array = array('albatross','dog','horse');
	 * enumerator::max_by($array, function($val) {
	 * 	return strlen($val);
	 * }); // albatross
	 * </code>
	 * 
	 * @param array $arr
	 * @param callable $callback
	 * @return mixed
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-max_by
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
	 * $array = array('albatross','dog','horse'); 
	 * enumerator::minmax($array, function($val1, $val2) { 
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * }); // array(dog, albatross)
	 * </code>
	 * 
	 * @param array $arr
	 * @param callback optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
	 * @return array
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-minmax
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
	 * $array = array('albatross','dog','horse'); 
	 * enumerator::minmax_by($array, function($val) { 
	 * 	return strlen($val);
	 * }); // array(dog, albatross)
	 * </code>
	 * 
	 * @param array $arr
	 * @param callable $callback
	 * @return array
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-minmax_by
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
	 * $array = array('ant', 'bear', 'cat');
	 * enumerator::none($array, function($key, $value) {
	 * 	return (strlen($value) == 5);
	 * }); // true
	 * enumerator::none($array, function($key, $value) {
	 * 	return (strlen($value) >= 4);
	 * }); // false
	 * enumerator::none(array()); // true
	 * enumerator::none(array(null)); // true
	 * enumerator::none(array(null, false)); // true
	 * </code>
	 * 
	 * @param array $arr 
	 * @param callable $callback A $key, $value are passed to this callback.
	 * @return boolean
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-none-3F
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
	 * $array = array('ant','bear','cat');
	 * enumerator::one($array, function($key, $value) {
	 * 	return (strlen($value) == 4);
	 * }); // true
	 * enumerator::one(array(null, true, 99)); // false
	 * enumerator::one(array(null, true, false)); // true
	 * </code>
	 * 
	 * @param array $arr 
	 * @param callable $callback A $key, $value are passed to this callback.
	 * @return boolean
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-one-3F
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
	 * enumerator::partition($arr, function($key, $value) {
	 * 	return ($value % 2 == 0);
	 * }); // [[2, 4, 6], [1, 3, 5]]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback.
	 * @param boolean $preserve_keys
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-partition
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
	 * Methods: inject, inject_, reduce
	 * 
	 * Will iterate the items in $arr passing each one to $callback with $memo as the third argument.
	 * 
	 * <code>
	 * $arr = range(5, 10);
	 * enumerator::inject($arr, function($key, &$value, &$memo){
	 * 	$memo += $value;
	 * 	return;
	 * }); // 45
	 * enumerator::inject($arr, function($key, &$value, &$memo){
	 * 	$memo *= $value;
	 * 	return;
	 * }, 1); // 151200
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback.
	 * @param mixed optional $memo This value is passed to all callback. Be sure to accept it by reference. Defaults to 0 (zero).
	 * @return mixed The memo variable.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-inject
	 */
	public static function inject_(array &$arr, $callback, $memo = 0) {
		foreach($arr as $key => &$value) {
			$callback($key, $value, $memo);
		}
		return $memo;
	}

	/**
	 * Methods: reject: reject_, delete_if
	 * 
	 * Will unset an item in $arr if $callback returns true for it.
	 * 
	 * <code>
	 * $arr = range(1,10);
	 * enumerator::reject($arr, function($key, $value) {
	 * 	return ($value % 3 == 0);
	 * }); // [1, 2, 4, 5, 7, 8, 10]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback. The $value can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-reject
	 */
	public static function reject_(array &$arr, $callback) {
		foreach($arr as $key => &$value) {
			if($callback($key, $value)) {
				unset($arr[$key]);
			}
		}
		return;
	}

	/**
	 * Methods: reverse_collect, reverse_collect_, reverse_each, reverse_map, reverse_foreach, reverse_each_with_index
	 * 
	 * Will iterate the array in reverse, but will NOT save the order.
	 * 
	 * <code>
	 * $array = array(1, 2, 3);
	 * enumerator::reverse_collect($array, function($key, &$value) {
	 * 	echo $value . ', ';
	 * 	return;
	 * }); // 3, 2, 1, 
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback. The $value can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-reverse_each
	 */
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
	 * enumerator::sort($arr); // [flea, kea, rhea]
	 * enumerator::sort($arr, function($val1, $val2) {
	 * 	return strcmp($val2, $val1);
	 * }); // [rhea, kea, flea]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param callable $callback A $key, $value are passed to this callback. The $value can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-sort
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
	 * enumerator::sort_by($arr, function($val) {
	 * 	return strlen($val);
	 * }); // [kea, flea, rhea]
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param callable $callback
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-sort_by
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
	 * $arr = [1,2,3,4,5,0];
	 * enumerator::take_while($arr, function($key, &$value) {
	 * 	return ($value < 3);
	 * }); // 1, 2
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param callable $callback A $key, $value are passed to this callback.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-take_while
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
	 * $arr = [1,2,3];
	 * enumerator::zip($arr, [4,5,6], [7,8,9]); // [[1,4,7],[2,5,8],[3,6,9]]
	 * </code>
	 * 
	 * <code>
	 * $arr = [1,2];
	 * enumerator::zip($arr, [4,5,6],[7,8,9]); // [[1, 4, 7], [2, 5, 8]]
	 * </code>
	 * 
	 * <code>
	 * $arr = [4,5,6];
	 * enumerator::zip($arr, [1,2], [8]); // [[4, 1, 8], [5, 2, null], [6, null, null]]
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param array $one Unlimited of this.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-zip
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
	 * $arr = [1,2,3,4,5,0];
	 * enumerator::drop_while($arr, function($key, &$value) {
	 * 	return ($value < 3);
	 * }); // [3,4,5,0]
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param callable $callback 
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop_while
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
	 * Methods: cycle
	 * 
	 * Will pass every element of $arr into $callback exactly $it times.
	 * 
	 * <code>
	 * enumerator::cycle([1,2,3], 3, function($key, $value, $it) {
	 * 	echo $value . ',';
	 * }); // 1,2,3,1,2,3,1,2,3,
	 * </code>
	 * 
	 * @param array $arr 
	 * @param int $it 
	 * @param callable $callback This can accept 3 arguments: $key - The key in the array, $value - The value of this key, $it - The current iteration.
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-cycle
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
	 * $follower = 0;
	 * enumerator::each_cons($arr, 3, function($key, $value, $leader) use (&$follower) {
	 * 	if($follower < $leader) {
	 * 		echo '||';
	 * 		$follower = $leader;
	 * 	}
	 * 	echo $value . ',';
	 * }); // 1,2,3,||2,3,4,||3,4,5,||4,5,6,||5,6,7,||6,7,8,||7,8,9,||8,9,10,
	 * /*
	 * $arr =
	 * [[1, 2, 3],
	 *  [2, 3, 4],
	 *  [3, 4, 5],
	 *  [4, 5, 6],
	 *  [5, 6, 7],
	 *  [6, 7, 8],
	 *  [7, 8, 9],
	 *  [8, 9, 10]]
	 * *\/
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param int $size 
	 * @param callable $callback 
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-each_cons
	 */
	public static function each_cons_(array &$arr, $size, $callback) {
		$newArr = array();
		$count = count($arr);
		$current = 0;
		foreach($arr as $k => $v) {
			if($current + $size > $count) {
				break;
			}
			$newArr[$current] = array_slice($arr, $current, $size);
			foreach($newArr[$current] as $key => &$value) {
				$callback($key, $value, $current);
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
	 * enumerator::slice_before($arr, "/[02468]/"); // will "splice before" an even number.
	 * // [1], [2,3], [4,5], [6,7], [8,9], [0]
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param string $pattern
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-slice_before
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
	 * Methods: merge, merge_, concat
	 * 
	 * Will merge two or more arrays together.
	 * 
	 * <code>
	 * $animals = ['dog', 'cat', 'pig'];
	 * $trees = ['pine'];
	 * enumerator::merge($animals, $trees, ['wool']); // dog, cat, pig, pine, wool
	 * </code>
	 * 
	 * @param array &$arr
	 * @param array $arr2
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-2B
	 */
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
	 * $arr = ['Foo', 'bar', 'foobar'];
	 * enumerator::rotate($arr, 1); // bar, foobar, Foo
	 * enumerator::rotate($arr, -1); // foobar, Foo, bar
	 * </code>
	 * 
	 * @param array &$arr
	 * @param int $index The starting index
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-rotate
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
	 * $arr = [1,2,3];
	 * enumerator::reverse($arr); // 3, 2, 1
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param boolean optional $preserve_keys Defaults to false. If you want to preserve the keys or not.
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-reverse
	 */
	public static function reverse_(array &$arr, $preserve_keys = false) {
		$arr = array_reverse($arr, $preserve_keys);
		return;
	}

	/**
	 * Methods: random, sample
	 * 
	 * Will get $count random values from $arr. If $count is 1 then it'll return the value, otherwise it'll return an array of values.
	 * 
	 * <code>
	 * $arr = ['pig', 'cow', 'dog', 'horse'];
	 * enumerator::random($arr); // dog
	 * enumerator::random($arr, 2); // [dog, cow]
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param int optional $count Defaults to 1
	 * @return mixed
	 * @link http://ruby-doc.org/core-1.9.3/Array.html#method-i-sample
	 */
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
	 * $arr = [1,2,3];
	 * enumerator::shuffle($arr); // [2,1,3]
	 * </code>
	 * 
	 * <code>
	 * $arr = ['a' => 'apple', 'b' => 'banana', 'c' => 'carrot'];
	 * enumerator::shuffle($arr, true); // [a => apple, c => carrot, b => banana]
	 * </code>
	 * 
	 * @param array &$arr
	 * @param boolean $preserve_keys If you want to preserve keys or not. Defaults to false.
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-shuffle
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
	 * Method: values_at, values_at_
	 * 
	 * Will replace the current array with only the inserted indexs. Use the non-destructive form to get the array returned instead.
	 * 
	 * <code>
	 * $name = [
	 * 	'name' => 'John Doe',
	 * 	'first' => 'John',
	 * 	'middle' => 'M',
	 * 	'last' => 'Doe',
	 * 	'title' => 'Dr.'
	 * ];
	 * enumerator::values_at($name, 'title', 'last'); // ['title' => 'Dr.', 'last' => 'Doe'];
	 * </code>
	 * 
	 * @param type array &$arr 
	 * @param mixed $index Put in as many indexes as you please.
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-values_at
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
	 * $arr = [];
	 * enumerator::isEmpty($arr); // true
	 * </code>
	 * 
	 * <code>
	 * $arr = [1,2,3];
	 * enumerator::isEmpty($arr); // false
	 * </code>
	 * 
	 * <code>
	 * $empty = 'empty';
	 * $arr = [1,2,3];
	 * enumerator::$empty($arr); // false
	 * </code>
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
	 * $arr = [0,false];
	 * enumerator::has_value($arr, null); // false
	 * </code>
	 * 
	 * <code>
	 * $arr = [false,null];
	 * enumerator::has_value($arr, 0); // false
	 * </code>
	 * 
	 * <code>
	 * $arr = ['apple', 'banana', 'orange'];
	 * enumerator::has_value($arr, 'orange'); // true
	 * </code>
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
	 * Methods: index, index_, find_index
	 * 
	 * Will return the first index if found or false otherwise. Use '===' for comparing.
	 * If $callback is a callback function, the $key is returned the first time $callback returns true.
	 * If $callback is not a callback, we are looking for the first $value in $arr to be === $callback.
	 * 
	 * <code>
	 * $name = [
	 * 	'name' => 'John Doe',
	 * 	'first' => 'John',
	 * 	'middle' => 'M',
	 * 	'last' => 'Doe',
	 * 	'title' => 'Dr.',
	 * 	'suffix' => 'Jr.'
	 * ];
	 * enumerator::index($name, 'John'); // 'first'
	 * enumerator::index_($name, function($key, &$value) {
	 * 	// I could edit $value since I'm using the destructive form 'index_'
	 * 	return (strpos($value, '.') !== false); // Has a decimal
	 * }); // title
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param mixed $callback 
	 * @return mixed
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-index
	 */
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
	 * $name = [
	 * 	'name' => 'John Doe',
	 * 	'first' => 'John',
	 * 	'middle' => 'M',
	 * 	'last' => 'Doe',
	 * 	'title' => 'Dr.',
	 * 	'suffix' => 'Jr.'
	 * ];
	 * enumerator::rindex($name, 'John'); // 'first'
	 * enumerator::rindex_($name, function($key, &$value) {
	 * 	// I could edit $value since I'm using the destructive form 'rindex_'
	 * 	return (strpos($value, '.') !== false);
	 * }); // 'suffix'
	 * </code>
	 * 
	 * @param array &$arr 
	 * @param mixed $callback 
	 * @return mixed
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-rindex
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
	 * $arr = [1,2,3,null,[2,3,4,null]];
	 * enumerator::compact($arr); // [1,2,3,[2,3,4,null]]
	 * enumerator::compact($arr, true); // [1,2,3,[2,3,4]]
	 * </code>
	 * 
	 * @param array &$arr
	 * @link http://www.ruby-doc.org/core-1.9.3/Array.html#method-i-compact
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
}