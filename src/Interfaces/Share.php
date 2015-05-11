<?php

namespace ReRouter\Interfaces;

interface Share
{
	public function __set($key, $value);
	public function __get($key);
	public function load(array $shares);
}
