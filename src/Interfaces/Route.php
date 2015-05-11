<?php

namespace ReRouter\Interfaces;

interface Route
{
	public function appendSettings(array $settings);
	public function overrideUid($uid);
	public function getUid();
	public function getMethods();
	public function setMethods($methods);
	public function getPattern();
	public function setPattern($pattern);
	public function getCallable();
	public function setCallable($callable);
	public function getParams();
	public function setParams($params);
	public function getMiddlewares();
	public function setMiddlewares(array $middlewares);
	public function addMiddleware($middleware);
	public function buildUri(array $args);
}
