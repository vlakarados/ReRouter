<?php

namespace ReRouter;

class Middleware implements \ReRouter\Interfaces\Middleware
{
	protected $keys = array();
	protected $items = array();

	public function __construct(\ReRouter\Interfaces\Share $share)
	{
		$this->share = $share;
	}

	public function register($key, array $callbacks)
	{
		foreach ($callbacks as $type => $value) {
			if (!array_key_exists($type, $this->items)) {
				$this->items[$type] = array();
			}
			$this->items[$type][$key] = $value;
		}
		$this->keys[$key] = true;
	}

	// Execute passed middleware keys by type
	public function execute($type, array $middlewares = null, $result = null)
	{
		if (!$middlewares) {
			return $result;
		}

		foreach ($middlewares as $middlewareName) {
			if (!array_key_exists($middlewareName, $this->keys)) {
				throw new \Exception('Requested middleware "'.$middlewareName.'" is not registered');
			}
			if (!array_key_exists($middlewareName, $this->items[$type])) {
				continue;
			}
			$callback = $this->items[$type][$middlewareName];
			$result = $callback($this->share, $result);
		}

		return $result;
	}
}
