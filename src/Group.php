<?php

namespace ReRouter;

class Group implements \ReRouter\Interfaces\Group
{

	protected $routes = array();

	/**
	 * Appends $settings to each route passed
	 * @param array $settings
	 * @param array $routes
	 */
	public function __construct(array $settings, array $routes)
	{
		foreach ($routes as $key => $route) {
			if (!($route instanceof \ReRouter\Interfaces\Route) and !($route instanceof \ReRouter\Interfaces\Group)) {
				throw new \Exception('All routes should be instances of \\ReRouter\\Interfaces\\Route or \\ReRouter\\Interfaces\\Group');
			}
			// Append settings
			$route->appendSettings($settings);
			$this->routes[$key] = $route;
		}
		return $this;
	}

	public function appendSettings(array $settings)
	{
		foreach ($this->routes as $route) {
			$route->appendSettings($settings);
		}
	}

	/**
	 * Returns all routes the group has
	 * @return array
	 */
	public function getRoutes()
	{
		return $this->routes;
	}
}
