<?php

namespace Helsinque\Factories;

use Validators\Cpf\ValidatorCpf;
use Validators\Cnpj\ValidatorCnpj;
use Exceptions\InvalidValidatorTypeException;

class TypeFactory
{
	static function make($type)
	{
		$type = ucfirst(strtolower($type));

		if (!class_exists($class = '\\Validators\\'.$type.'\\Validate'.$type)) {
			throw new InvalidValidatorTypeException("Type: ".$type." is not implemented yet", 1);
		}
			
		$reflector = new \ReflectionClass('\\Validators\\'.$type.'\\Validate'.$type);
		return $reflector->newInstanceArgs();
	}
}
