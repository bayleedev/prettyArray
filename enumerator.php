<?php

/**
 * A handy static class for handling array functions.
 * @todo chunk, collect_concat, cycle, each_cons, each_entry
 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html
 */
class enumerator {

	protected static $phpFunctions = array(
		'array_slice'
	);

	protected static $funAlias = array(
		'drop' => 'array_slice'
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
			$ret = $callable($key, $value);
			if(!is_null($ret) && $ret !== false) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Will iterate the elements in the array. Has the potential to change the values.
	 * Alias
	 *  - map
	 *  - foreach
	 *  - each_with_index
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
	 * Alias
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
				return ($value ==$i);
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
	 * Alias
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
				return ($temp = $value);
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
	 * Alias
	 *  - reduce
	 * @param array &$arr
	 * @param callback $callback A $key, $value, and $memo are passed to this callback. The $value and $memo can be accepted by reference.
	 * @param mixed optional $memo This value is passed to all callback. Be sure to accept it by reference. Defaults to 0 (zero).
	 * @return mixed The memo variable.
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-inject
	 */
	public function inject(array &$arr, $callback, $memo = 0) {
		foreach($arr as $key => &$value) {
			$callback($key, $value, $memo);
		}
		return $memo;
	}
}