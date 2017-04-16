<?php
namespace Validators;

use Validators\Cpf\ValidateCpf;
use Validators\Cnpj\ValidateCnpj;
use Exceptions\DocumentValidationException;
use Helsinque\Factories\TypeFactory;
/**
*  Classe para implementação de validadores
*/

class Validator 
{
    private $typeFactory;

    public function __construct(TypeFactory $typeFactory) {
        $this->typeFactory = $typeFactory;
    }

    /**
    * Generic validator
    */
    public function validate($type, $value)
    {
        if (empty($value)) {
            return "Informe o parametro";
        }

        try {                
            $result = $this->typeFactory::make($type)->validate($value);
        } catch (DocumentValidationException $e) {
            return $e->getMessage();
        }

        return $result;
    }    
}
