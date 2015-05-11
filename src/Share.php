<?php

namespace ReRouter;

class Share implements \ReRouter\Interfaces\Share
{
	public $items = array();

	public function __set($key, $value)
	{
		$this->items[$key] = $value;
	}

	public function __get($key)
	{
		return $this->items[$key];
	}

	public function load(array $shares)
	{
		$this->items = $shares;
	}
}
