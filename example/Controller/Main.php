<?php

namespace App\Controller\Admin;

class Main
{
	public function setRouter(\ReRouter\Router $router)
	{
		$this->router = $router;
	}

	public function dashboard()
	{
		// we're in
		echo 'hello admin panel!';
	}

	public function login()
	{
		// show pretty form
		echo 'log in, please!';
	}

	public function loginSubmit()
	{
		// check and validate $_POST data, log the user in our app
	}

	public function error()
	{
		// very bad page
		echo 'holy smokes, an error';
	}



	// These methods should both be in another controller like \App\Controller\Admin\User
	public function userIndex()
	{
		echo 'User 1: <a href="'.$this->router->build('admin_user_view', array('userId' => 1)).'">'.$this->router->build('admin_user_view', array('userId' => 1)).'</a><br>';
		echo 'User 2: <a href="'.$this->router->build('admin_user_view', array('userId' => 2)).'">'.$this->router->build('admin_user_view', array('userId' => 2)).'</a><br>';
		echo 'User 3: <a href="'.$this->router->build('admin_user_view', array('userId' => 3)).'">'.$this->router->build('admin_user_view', array('userId' => 3)).'</a><br>';
	}

	public function userView($userId)
	{
		// get user from DB, show profile
		echo "This is the profile for user #".$userId;
	}
}
