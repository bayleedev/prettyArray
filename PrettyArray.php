<?php
include('./enumerator.php');
/**
 * PrettyArray
 * 
 * @author Blaine Schmeisser <Blaine.Sch@gmail.com>
 */

/**
 * PrettyArray
 * 
 * An object oriented approach to array development.
 * 
 * @todo getRange and getSet are destructive. Make static function like in enumerator.
 */
class PrettyArray implements ArrayAccess {

	protected $data = array();
	protected $mixins;

	public function __construct(array $defaults = array()) {
		$this->mixins = 'enumerator';
		$this->data = $defaults;
	}

	// ArrayAccess
	public function offsetSet($key, $value) {
		if(empty($key)) {
			$this->data[] = $value;
		} else {
			$this->data[$key] = $value;
		}
		return $value;
	}
	public function offsetExists($keys) {
		return (isset($this->data[$key]));
	}
	public function offsetUnset($key) {
		if(isset($this->data[$key])) {
			unset($this->data[$key]);
		}
		return;
	}
	public function offsetGet($key) {
		return (isset($this->data[$key])) ? $this->data[$key] : null;
	}

	// PHP Magic - 5.3 mixin support
	public function __call($method, $params) {
		array_unshift($params, 0);
		$params[0] =& $this->data;

		try {
			$ret = call_user_func_array(array($this->mixins, $method), $params);
		} catch(BadMethodCallException $e) {
			$ret = null;
		}
		return $ret;
	}

	// PrettyArray
	/*
	public function getRange($start, $end) {
		$that = clone $this;
		return $that->getRange_($start, $end);
	}
	*/
	public function getRange_($start, $end) {
		$ret = new PrettyArray();
		$collecting = false;
		foreach($this->data as $key => &$value) {
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

	/*
	public function getSet($start, $length) {
		$that = clone $this;
		return $that->getSet_($start, $length);
	}
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

	public function setByReference($key, &$value) {
		$this->data[$key] =& $value;
	}

	public function get() {
		return $this->data;
	}
}