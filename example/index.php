<?php

// You won't have to require anything if you're using the composer autoloader
// ---
require_once('../nikic/FastRoute/src/bootstrap.php');

require_once('../src/Router.php');
require_once('../src/Group.php');
require_once('../src/Route.php');
require_once('../src/Middleware.php');
require_once('../src/RouteCollector.php');
require_once('../src/Share.php');

require_once(__DIR__.'/Controller/Main.php');
// ---


// The following three variables should be retrieved, use any http\request class to get this, e.g. https://github.com/PatrickLouys/http or user $_SERVER

// Base url
$baseUrl = 'http://kewlwibsite.me';

// Commment out all but the one needed
$httpMethod = 'GET';
//$httpMethod = 'POST';

$currentUrl = '/admin/route_does_not_exist12rf3qfw';
$currentUrl = '/admin/login';
$currentUrl = '/admin/user/123';
$currentUrl = '/admin/user/index';
//$currentUrl = '/admin/dashboard';

$routeCollection		= include(__DIR__.'/routes.php');
$middlewareCollection	= include(__DIR__.'/middlewares.php');

$share = new \ReRouter\Share;
$share->load(array(
	'request'	=> $request,
));

$middleware = new \ReRouter\Middleware($share);

foreach ($middlewareCollection as $middlewareKey => $middlewareCallback) {
	$middleware->register($middlewareKey, $middlewareCallback);
}

$router = new \ReRouter\Router;
$router->setBaseUrl($baseUrl);
$router->register($routeCollection);

try {
	$router->route($httpMethod, $currentUrl);
} catch (\ReRouter\NotFound $exception) {
	// probably you want two separate pages for these errors
	$router->route('GET', '/admin/error');
} catch (\ReRouter\MethodNotAllowed $exception) {
	$router->route('GET', '/admin/error');
}

// Execute the 'before' middleware
$middleware->execute('before', $router->currentRoute->getMiddlewares());

// Get the callable (the 3rd argument to \ReRouter\Route)
$callable = $router->currentRoute->getCallable();
$params = $router->currentRoute->getParams();


// Execute the $callable with $params, something like
$controllerClass = $callable[0];
$controller = new $controllerClass;
$controller->setRouter($router); // to build URLs we have to share the $router

$result = call_user_func_array(array($controller, $callable[1]), $params);

echo $result;


