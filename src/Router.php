<?php

namespace ReRouter;

class Router
{
	public $currentRoute	= null;
	public $currentMethod	= null;
	public $currentUri		= null;

	public $baseUrl			= null;

	protected $routes = array();

	protected $patternAliases = array(
		'/{(.+?):numeric}/'			=> '{$1:[0-9]+}',
		'/{(.+?):alpha}/'			=> '{$1:[a-zA-Z]+}',
		'/{(.+?):alphanumeric}/'	=> '{$1:[a-zA-Z0-9]+}',
		'/{(.+?):any}/'				=> '{$1:[a-zA-Z0-9$-_.+!*\'(),]+}',
	);

	protected function expandPatternAlias($pattern)
	{
		return preg_replace(array_keys($this->patternAliases), array_values($this->patternAliases), $pattern);
	}

	public function addPatternAlias($contracted, $expanded)
	{
		$this->patternAliases[$contracted] = $expanded;
	}

	/**
	 * Recursively registers a group of routes
	 * @param  \ReRouter\Group $group
	 * @return [type]
	 */
	public function register(\ReRouter\Interfaces\Group $group)
	{
		foreach ($group->getRoutes() as $key => $route) {
			if ($route instanceof \ReRouter\Group) {
				$this->register($route);
				continue;
			}
			$this->addRoute($route, $key);
		}
		return $this;
	}

	/**
	 * Adds a route to the route array
	 * @param \ReRouter\Route $route
	 * @param string $key
	 */
	protected function addRoute(\ReRouter\Interfaces\Route $route, $key = null)
	{
		$route->setPattern($this->expandPatternAlias($route->getPattern()));

		if (!is_int($key)) {
			$route->overrideUid($key);
			$this->routes[$key] = $route;
			return $this;
		}
		$this->routes[$route->uid] = $route;
		return $this;
	}

	/**
	 * Returns a route by it's name/unique id
	 * @param  mixed	$routeUid
	 * @return array
	 */
	public function getRoute($routeUid)
	{
		return $this->routes[$routeUid];
	}

	/**
	 * Checks if the route exists by name or unique id
	 * @param  mixed	$routeUid
	 * @return boolean
	 */
	public function hasRoute($routeUid)
	{
		return array_key_exists($routeUid, $this->routes);
	}

	public function simpleDispatcher($routeCallback, array $options = array())
	{
		$options += array(
			'routeParser' => 'FastRoute\\RouteParser\\Std',
			'dataGenerator' => 'FastRoute\\DataGenerator\\GroupCountBased',
			'dispatcher' => 'FastRoute\\Dispatcher\\GroupCountBased',
		);

		$routeCollector = new \FastRoute\RouteCollector(new $options['routeParser'], new $options['dataGenerator']);
		$routeCallback($routeCollector);

		return new $options['dispatcher']($routeCollector->getData());
	}

	public function route($method, $uri)
	{
		$routes = $this->routes;
		$dispatcher = $this->simpleDispatcher(function (\FastRoute\RouteCollector $r) use ($routes) {
			foreach ($routes as $route) {
				$r->addRoute($route->getMethods(), $route->getPattern(), $route->getUid());
			}
		});

		$routeInfo = $dispatcher->dispatch($method, $uri);

		if ($routeInfo[0] == \FastRoute\Dispatcher::NOT_FOUND) {
			throw new \ReRouter\NotFound($method, $uri);
		} elseif ($routeInfo[0] == \FastRoute\Dispatcher::METHOD_NOT_ALLOWED) {
			throw new \ReRouter\MethodNotAllowed($method, $uri);
		} elseif ($routeInfo[0] != \FastRoute\Dispatcher::FOUND) {
			throw new \Exception;
		}

		$route = $this->routes[$routeInfo[1]];
		$route->setParams($routeInfo[2]);
		$this->currentRoute = $route;
		return $route;
	}

	/**
	 * Builds an URL for the named route, inserts it's arguments
	 * @param  string	$name
	 * @param  array	$args
	 * @return [type]
	 */
	public function build($name, array $args = array())
	{
		if (is_int($name)) {
			throw new \Exception('Bulding routes by their index is not safe.');
		}
		if (!$this->hasRoute($name)) {
			throw new \Exception('Named route "'.$name.'" not found.');
		}
		$route = $this->getRoute($name);
		return $this->baseUrl.$route->buildUri($args);
	}

	/**
	 * Set base url to build routes against
	 * @param string $baseUrl
	 */
	public function setBaseUrl($baseUrl)
	{
		$this->baseUrl = $baseUrl;
	}
}
