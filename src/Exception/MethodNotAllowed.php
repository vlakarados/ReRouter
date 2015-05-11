<?php

namespace ReRouter\Exception;

class MethodNotAllowed extends \Exception
{
	public $httpCode = 405;
	public function __construct($method, $uri)
	{
		$this->message = 'Method "'.$method.'" not allowed for URI "'.$uri.'"';
	}
}
