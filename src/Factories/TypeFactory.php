<?php

namespace Helsinque\Factories;

use Validators\Cpf\ValidatorCpf;
use Validators\Cnpj\ValidatorCnpj;

class TypeFactory
{
	static function make($type)
	{
		$reflector = new \ReflectionClass('\\Validators\\'.$type.'\\Validate'.$type);
		return $reflector->newInstanceArgs();
	}
}
