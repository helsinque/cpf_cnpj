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

    /**
    * 
    */

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

    /**
    *  Válida um documento direto na API da BIPBOP
    * @return (string) nome referênte ao documento
    */
    
    public function validateWithBIPBOP($parameter)
    {

        if (empty($parameter)) {
            return "Informe um número para validação";
        }

        try {
            return $this->validateCpf->validateCpf($parameter)->getName();
            
        } catch (DocumentValidationException $e) {

            if (preg_match('/^CPF/', $e->getMessage())) {

                try {
            
                    return $this->validateCnpj->validateCnpj($parameter)->getName();

                } catch (DocumentValidationException $e) {
                    
                    return $e->getMessage();
                }
            }

            return $e->getMessage();
        }

    }    
}
