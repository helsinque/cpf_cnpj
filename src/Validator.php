<?php

namespace Helsinque;

use Helsinque\Factories\TypeFactory;
use Helsinque\Config;

class Validator
{
	private $instance;

	public function __construct(array $options = [])
	{
		Config::load($options);

		$reflector = new \ReflectionClass('\\Validators\\Validator');
		$this->instance = $reflector->newInstanceArgs([new TypeFactory]);
	}

	public function validate($type, $value)
	{
		return $this->instance->validate($type, $value);
	}

	public function getInstance()
	{
		return $this->instance;
	}

}
