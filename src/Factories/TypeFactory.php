<?php

namespace Helsinque\Factories;

use Validators\Cpf\ValidatorCpf;
use Validators\Cnpj\ValidatorCnpj;
use Exceptions\InvalidValidatorTypeException;

/**
 * Class TypeFactory.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com">
 */
class TypeFactory
{
    /**
     * make method.
     *
     * @param  stringt $type
     * @return \Validators\ValidatorsInterface
     */
    public function make($type)
    {
        $type = ucfirst(strtolower($type));

        if (!class_exists($class = '\\Validators\\'.$type.'\\Validate'.$type)) {
            throw new InvalidValidatorTypeException("Type: ".$type." is not implemented yet", 1);
        }
            
        $reflector = new \ReflectionClass('\\Validators\\'.$type.'\\Validate'.$type);
        return $reflector->newInstanceArgs();
    }
}
