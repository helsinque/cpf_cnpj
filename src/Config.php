<?php

namespace Helsinque;

abstract class Config
{
	static $config;

	static public function set($index, $value)
	{
		self::$config[$index] = $value;
	}

	static public function get($index)
	{
		return self::$config[$index];
	}

	static public function load(array $array)
	{
		self::$config = $array;
	}
}