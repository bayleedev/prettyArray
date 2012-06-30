<?php

/**
 * A handy static class for handling array functions.
 * Current destructive functions:
 *  - collect
 *  - drop_while
 *  - each_slice
 *  - flatten
 *  - grep
 *  - group_by
 * The new idea is that none of the functions will be "destructive" and use "__callStatic" and say if the last character of the method is a underscore and the method exists without it, it'll be destructive.
 * Or possibly the other way around where the destructive functions by default have the underscore at the end and callStatic makes the functions safe.
 * @todo Blah: chunk, collect_concat, cycle, each_cons, each_entry
 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html
 */
class enumerator {

	protected static $functionMap = array(
		'array_slice' => 'array_slice',
		'drop' => 'array_slice'
	);

	protected static $methodMap = array(
	);

	/**
	 * Passes each element of the collection to the $callback, if it ever turns false or null I'll return false, else I'll return true.
	 * @param array $arr 
	 * @param callback $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return boolean
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-all-3F
	 */
	public static function all(array &$arr, $callback = null) {
		if(!is_callable($callback)) {
			$callback = function($key, $value) {
				return $value;
			};
		}
		foreach($arr as $key => &$value) {
			$ret = $callable($key, $value);
			if(is_null($ret) OR $ret === false) {
				return false;
			}
		}
		return true;
	}

	/**
	 * Passes each element of the collection to the $callback, if it ever returns anything besides null or false I'll return true, else I'll return false.
	 * @param array $arr 
	 * @param callback $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return boolean
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-any-3F
	 */
	public static function any(array &$arr, $callback = null) {
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
	 * Will iterate the elements in the array. Has the potential to change the values.
	 * Alias:
	 *  - map
	 *  - foreach
	 *  - each_with_index
	 *  - array_walk ** php function that could replace this one
	 * @param array &$arr
	 * @param callback $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-collect
	 */
	public static function collect(array &$arr, $callback) {
		foreach($arr as $key => &$value) {
			$callback($key, $value);
		}
		return;
	}

	/**
	 * If the callback is null, this function give you the total size of the array.
	 * If the callback is a anonmous function, this function iterate the blocks and count how many times it returns true.
	 * Otherwise this function will count how many times $callback is equal to $value.
	 * Alias:
	 *  - Size
	 *  - Length
	 * @param array &$arr 
	 * @param callback $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return int
	 */
	public static function count(array &$arr, $callback = null) {
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
	 * Will pass the key and value to $callback the first result that does not return false is returned.
	 * If no results are found this function will return the result of $ifnone (mixed) if none is provided false will be returned.
	 * Alias:
	 *  - find
	 * @param array &$arr
	 * @param callback $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @param mixed $ifnone 
	 * @return mixed
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-detect
	 */
	public static function detect(array &$arr, $callback, $ifnone = null) {
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
	 * Will pass the elements to the callback and unset them if the callback returns false.
	 * Alias:
	 *  - find_all
	 *  - select
	 * @param array &$arr
	 * @param callback $callback A $key and a $value are passed to this callback. The $value can be accepted by reference.
	 * @return array The array that has already been edited by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop_while
	 */
	public static function drop_while(array &$arr, $callback) {
		foreach($arr as $key => &$value) {
			if($callback($key, $value) === false) {
				unset($arr[$key]);
			}
		}
		return;
	}

	/**
	 * Will slice the elements into $size and pass to $callback if defined. If not defined, the slized array is returned.
	 * @param array &$arr
	 * @param int $size The size of each slice.
	 * @param callback $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-each_slice
	 */
	public static function each_slice(array &$arr, $size, $callback = null) {
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
	 * Will iterate the items in $arr passing each one to $callback.
	 * Alias:
	 *  - reduce
	 * @param array &$arr
	 * @param callback $callback A $key, $value, and $memo are passed to this callback. The $value and $memo can be accepted by reference.
	 * @param mixed optional $memo This value is passed to all callback. Be sure to accept it by reference. Defaults to 0 (zero).
	 * @return mixed The memo variable.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-inject
	 */
	public static function inject(array &$arr, $callback, $memo = 0) {
		foreach($arr as $key => &$value) {
			$callback($key, $value, $memo);
		}
		return $memo;
	}

	/**
	 * If $callback is callable, this function will pass each item into $callback and return the first value that $callback returns true on.
	 * If $callback is not callable and is an index inside of $arr, this function will return it's value.
	 * If not found nothing is returned.
	 * @param array &$arr
	 * @param callback $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @return mixed
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-find_index
	 */
	public static function find_index(array &$arr, $callback) {
		if(is_callable($callback)) {
			foreach($arr as $key => &$value) {
				if($callback($key, $value) === true) {
					return $value;
				}
			}
		} else if(isset($arr[$callback])) {
			return $arr[$callback];
		}
		return;
	}

	/**
	 * Will overwrite $arr with the first $count items in array.
	 * @param array &$arr
	 * @param type $count The number of items you wish to return. Defaults to 1
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-first
	 */
	public static function first(array &$arr, $count = 1) {
		$arr = array_slice($arr, 0, $count, true);
		return;
	}

	/**
	 * Will flatten the input $arr into a non-multi-dimensional array.It will pass the current key and the value to $callback which has the potential to change the value.
	 * The new array will have discarded all current keys.
	 * Alias:
	 *  - flat_map
	 *  - collect_concat
	 * @param array &$arr
	 * @param callback $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-flat_map
	 */
	public static function flatten(array &$arr, $callback) {
		$newArr = array();
		array_walk_recursive($arr, function(&$value, $key) use (&$callback, &$newArr) {
			$callback($key, $value);
			$newArr[] = $value;
		});
		$arr = $newArr;
		return;
	}

	/**
	 * Will only keep an item if the value of the item matches $pattern.
	 * If a callback is provided, it will pass the $key and $value into the array.
	 * @param array &$arr
	 * @param string $pattern The regex pattern.
	 * @param callback $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-grep
	 */
	public static function grep(array &$arr, $pattern, $callback = null) {
		$arr = preg_grep($pattern, $arr);
		if(is_callable($callback)) {
			foreach($arr as $key => &$value) {
				$callback($key, $value);
			}
		}
		return;
	}

	/**
	 * Each item will be passed into $callback and the return value will be the new "category" of this item.
	 * The param $arr will be replaced with an array of these categories with all of their items.
	 * @param array &$arr
	 * @param callback $callback The callback will be passed each sliced item as an array. This can be passed by reference.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-group_by
	 */
	public static function group_by(array &$arr, $callback) {
		$newArr = array();
		foreach($arr as $key => &$value) {
			$category = $callback($key, $value);
			if(!isset($newArr[$category])) {
				$newArr[$category] = array();
			}
			$newArr[$category][$key] = $value;
		}
		$arr = $newArr;
		return;
	}

	/**
	 * This function will iterate over $arr, if any value is equal (===) to $needle this function will return true. If nothing is found this function will return false.
	 * Alias:
	 *  - include
	 * @param array &$arr
	 * @param mixed $needle 
	 * @return boolean
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-member-3F
	 */
	public static function member(array &$arr, $needle) {
		foreach($arr as $key => &$value) {
			if($needle === $value) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Will find the lowest value. If callback is defined it will compare them.
	 * <code>
	 * $array = array('albatross','dog','horse');
	 * enumerator::min($array); // albatross
	 * $array = array('albatross','dog','horse');
	 * enumerator::min($array, function($val1, $val2) {
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * }); // dog
	 * </code>
	 * @param array &$arr
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
	 * Will find the highest value. If callback is defined it will compare them.
	 * <code>
	 * $array = array('albatross','dog','horse');
	 * enumerator::max($array); // horse
	 * $array = array('albatross','dog','horse');
	 * enumerator::max($array, function($val1, $val2) {
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * }); // albatross
	 * </code>
	 * @param array &$arr
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
	 * Will find the lowest item in the array but comparing the output os $callback against every item.
	 * <code>
	 * $array = array('albatross','dog','horse'); 
	 * enumerator::min_by($array, function($val) { 
	 * 	return strlen($val); 
	 * }); // dog 
	 * </code>
	 * @param array &$arr
	 * @param callback optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
	 * @return mixed
	 */
	public static function min_by(array $arr, $callback) {
		usort($arr, function($key1, $key2) use (&$callback) {
			return strcmp($callback($key1), $callback($key2));
		});
		return array_shift($arr);
	}

	/**
	 * Will find the highest item in the array but comparing the output os $callback against every item.
	 * <code>
	 * $array = array('albatross','dog','horse');
	 * enumerator::max_by($array, function($val) {
	 * 	return strlen($val);
	 * }); // albatross
	 * </code>
	 * @param array &$arr
	 * @param callback optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
	 * @return mixed
	 */
	public static function max_by(array $arr, $callback) {
		usort($arr, function($key1, $key2) use (&$callback) {
			return strcmp($callback($key1), $callback($key2));
		});
		return array_pop($arr);
	}

	/**
	 * Will return an array of min and max. Optionally you can provide a callback to sort them.
	 * <code>
	 * $array = array('albatross','dog','horse'); 
	 * enumerator::minmax($array, function($val1, $val2) { 
	 * 	return strcmp(strlen($val1), strlen($val2));
	 * }); // array(dog, albatross)
	 * </code>
	 * @param array &$arr
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
	 * Will find the lowest and highest item in the array but comparing the output os $callback against every item.
	 * <code>
	 * $array = array('albatross','dog','horse'); 
	 * enumerator::minmax_by($array, function($val) { 
	 * 	return strlen($val);
	 * }); // array(dog, albatross)
	 * </code>
	 * @param array &$arr
	 * @param callback optional $callback Will accept two values. Return 0 if they are equal, return -1 if the second parameter is bigger, and 1 is the first parameter is bigger.
	 * @return array
	 */
	public static function minmax_by(array $arr, $callback) {
		usort($arr, function($key1, $key2) use (&$callback) {
			return strcmp($callback($key1), $callback($key2));
		});
		return array(array_shift($arr), array_pop($arr));
	}
}