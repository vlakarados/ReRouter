<?php

namespace ReRouter;

class RouteCollector extends \FastRoute\RouteCollector
{
	public function addRoute($httpMethod, $route, $handler) {
		if ($httpMethod == 'REST') {
			// Make REST methods available
			// TODO: find a better way to do this witout duplicates with an appended slash character
			parent::addRoute('GET',		$route[0], 						array($handler, 'index'));
			parent::addRoute('GET',		$route[0].'/', 					array($handler, 'index'));
			parent::addRoute('POST',	$route[0].'', 					array($handler, 'create'));
			parent::addRoute('POST',	$route[0].'/', 					array($handler, 'create'));
			parent::addRoute('GET',		$route[0].'/'.$route[1], 		array($handler, 'show'));
			parent::addRoute('GET',		$route[0].'/'.$route[1].'/', 	array($handler, 'show'));
			parent::addRoute('PUT',		$route[0].'/'.$route[1], 		array($handler, 'edit'));
			parent::addRoute('PUT',		$route[0].'/'.$route[1].'/', 	array($handler, 'edit'));
			parent::addRoute('PATCH',	$route[0].'/'.$route[1], 		array($handler, 'edit'));
			parent::addRoute('PATCH',	$route[0].'/'.$route[1].'/', 	array($handler, 'edit'));
			parent::addRoute('DELETE',	$route[0].'/'.$route[1], 		array($handler, 'delete'));
			parent::addRoute('DELETE',	$route[0].'/'.$route[1].'/', 	array($handler, 'delete'));
			return;
		}
		parent::addRoute($httpMethod, $route, $handler);
	}
}
