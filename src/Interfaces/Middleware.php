<?php

namespace ReRouter\Interfaces;

interface Middleware
{
	public function register($key, array $callbacks);
	public function execute($type, array $middlewares = null, $result = null);
}
