<?php

namespace ReRouter\Interfaces;

interface Group
{
	public function appendSettings(array $settings);
	public function getRoutes();
}
