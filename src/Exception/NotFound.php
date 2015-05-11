<?php

namespace ReRouter\Exception;

class NotFound extends \Exception
{
	public $httpCode = 404;
	public function __construct($method, $uri)
	{
		$this->message = 'Not found "'.$method.'" / "'.$uri.'"';
	}
}
