<?php
use \ReRouter\Group;
use \ReRouter\Route;

$routes = new Group(array(), array(
	'admin_login'			=> new Route('GET',		'/admin/login',		array('\App\Controller\Admin\Main', 'login')),
	'admin_login_submit'	=> new Route('POST',	'/admin/login',		array('\App\Controller\Admin\Main', 'loginSubmit')),

	new Group(array('prefix' => '/admin', 'middlewares' => array('admin_auth')), array(

		'admin_dashboard'	=> new Route('GET',		'/dashboard',				array('\App\Controller\Admin\Main',	'dashboard')),

		'admin_user_list'	=> new Route('GET',		'/user/index',				array('\App\Controller\Admin\Main',	'userIndex')),
        'admin_user_view'	=> new Route('GET',		'/user/{userId:numeric}',	array('\App\Controller\Admin\Main',	'userView')),

		// other /admin/* routes here
	)),
	'admin_error'	=> new Route('GET',		'/admin/error',		array('\App\Controller\Admin\Main', 'error')),
));
return $routes;
