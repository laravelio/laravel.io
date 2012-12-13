<?php

class PresenterCollection implements ArrayAccess, Iterator, Countable, Serializable
{
	protected $_position = 0;
	protected $container = array();

	public static function to_array($presenter, $collection) 
	{
		$instance = new static($presenter, $collection);

		return (array) $instance->container;
	}

	public static function make($presenter, $collection)
	{
		return static::to_array($presenter, $collection);
	}

	public function __construct($presenter, $collection)
	{
		$this->container = array_map(function($item) use ($presenter) {
			return new $presenter($item);
		}, $collection);
	}

	public function rewind()
	{
		$this->_position = 0;
	}

	public function current()
	{
		return $this->container[$this->_position];
	}

	public function key()
	{
		return $this->_position;
	}

	public function next()
	{
		++$this->_position;
	}

	public function valid()
	{
		return isset($this->container[$this->_position]);
	}

	public function count()
	{
		return count($this->container);
	}

	public function offsetSet($offset, $value)
	{
		if (is_null($offset)) {
			$this->container[] = $value;
		} else {
			$this->container[$offset] = $value;
		}
	}

	public function offsetExists($offset)
	{
		return isset($this->container[$offset]);
	}

	public function offsetUnset($offset)
	{
		unset($this->container[$offset]);
	}

	public function offsetGet($offset)
	{
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
	}

	public function serialize()
	{
		return serialize($this->container);
	}

	public function unserialize($collection)
	{
		$this->container = unserialize($collection);
	}

}
