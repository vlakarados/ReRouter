<?php

namespace ReRouter;

class Route implements \ReRouter\Interfaces\Route
{

	private static $idIndex = 0;


	// Array of allowed methods for this route
	protected $methods = array();

	// Pattern for the route
	protected $pattern = null;

	// Callable that should be executed if the route pattern matches
	protected $callable = null;

	// Middleware that should be run before and after the execution of the callable
	protected $middlewares = array();

	// Route parameters. Populated the moment route is resolved
	protected $params = array();

	// Keep references to routes
	public $uid;

	public $allowedMethods = array(
		'GET',
		'POST',
		'PUT',
		'DELETE',
		'HEAD',
		'PATCH',
		'OPTIONS'
	);

	public function __construct($methods, $pattern, $callable, array $settings = array())
	{
		$this->setMethods($methods);
		$this->setPattern($pattern);
		$this->setCallable($callable);

		if (array_key_exists('middlewares', $settings)) {
			$this->setMiddlewares($settings['middlewares']);
		}

		static::$idIndex++;
		$this->uid = static::$idIndex;
	}


	public function appendSettings(array $settings)
	{
		// Append middlewares
		if (array_key_exists('middlewares', $settings) and count($settings['middlewares'])) {
			foreach ($settings['middlewares'] as $middleware) {
				$this->addMiddleware($middleware);
			}
		}

		// Prepend prefix to pattern
		if (array_key_exists('prefix', $settings)) {
			$this->setPattern($settings['prefix'].$this->getPattern());
		}
	}


	/**
	 * Overrides route unique id
	 * @param  string|int $uid
	 */
	public function overrideUid($uid)
	{
		$this->uid = $uid;
	}

	/**
	 * Returns route's name/unique id
	 * @return string|int
	 */
	public function getUid()
	{
		return $this->uid;
	}

	/**
	 * Returns array of methods this route accepts
	 * @return array
	 */
	public function getMethods()
	{
		return $this->methods;
	}

	/**
	 * Sets acceptable methods of this route
	 * @param array|string
	 */
	public function setMethods($methods = 'GET')
	{
		if (is_array($methods)) {
			$this->methods = $methods;
			foreach ($methods as $method) {
				if (!in_array($method, $this->allowedMethods)) {
					throw new \Exception('Unallowed HTTP method used: '.$method);
				}
			}
			return;
		}
		if (!in_array($methods, $this->allowedMethods)) {
			throw new \Exception('Unallowed HTTP method used: '.$method);
		}
		$this->methods[] = $methods;
	}


	public function getPattern()
	{
		return $this->pattern;
	}

	public function setPattern($pattern)
	{
		$this->pattern = $pattern;
	}

	public function getCallable()
	{
		return $this->callable;
	}

	public function setCallable($callable)
	{
		$this->callable = $callable;
	}


	public function getParams()
	{
		return $this->params;
	}

	public function setParams($params)
	{
		$this->params = $params;
	}


	public function getMiddlewares()
	{
		return $this->middlewares;
	}

	public function setMiddlewares(array $middlewares = array())
	{
		$this->middlewares = $middlewares;
	}

	public function addMiddleware($middleware)
	{
		$this->middlewares[] = $middleware;
	}

	public function buildUri(array $args)
	{
		$res = $this->pattern;
		foreach ($args as $k => $v) {
			$match = '/\{'.$k.':.+\}/';
			$res = preg_replace($match, $v, $res);
		}
		$requiredArgsCount = $this->countPatternArguments();
		if ($requiredArgsCount != count($args)) {
			throw new \Exception('Failed building named route "'.$this->pattern.'". Number of arguments required: '.$requiredArgsCount.', passed: '.count($args).'.');
		}
		return $res;
	}

	protected function countPatternArguments()
	{
		$match = '/\{.+:.+\}/';
		return preg_match_all($match, $this->pattern, $out);
	}
}
