<?php
$middlewares = array(
	'admin_auth' => array(
		'before' => function (\ReRouter\Share $share) {
			// check if the user is logged in using $share->session or something else
			if (1 != 1) {
				header("Location: http://example.com/login");
				die();
			}
		}
	)
);
return $middlewares;
