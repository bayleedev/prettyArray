<?php

/**
 * A handy static class for handling array functions.
 * @todo chunk, collect_concat, cycle
 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html
 */
class enumerator {

	/**
	 * Passes each element of the collection to the $callback, if it ever turns false or null I'll return false, else I'll return true.
	 * @param array $arr 
	 * @param callback $callback 
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
	 * @param callback $callback 
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
	 * @param array &$arr
	 * @param callback $callback
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
	 * @param mixed $callback 
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
	 * @param callback $callback 
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
	 * Drops the first $offset elements in the array
	 * @param array &$arr
	 * @param type $offset
	 * @return array
	 * @link http://ruby-doc.org/core-1.9.3/Enumerable.html#method-i-drop
	 */
	public static function drop(array &$arr, $offset) {
		return array_slice($arr, $offset);
	}

}