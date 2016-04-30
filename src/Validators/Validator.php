<?php

namespace Validators;

use Validators\Cpf\ValidateCpf;
use Validators\Cnpj\ValidateCnpj;
use Exceptions\DocumentValidationException;
/**
*  Classe para implementação de validadores
*/

class Validator 
{

	private $data;

    /**
    *  Inicializa valor da propriedade
    */
    public function initialize($number)
    {
        $this->data = $number;
    } 
    /**
    *  Válida um documento do tipo CNPJ
    */
    public function validateCnpj($parameter)
    {

        if (!empty($parameter))
        {            
            $this->initialize($parameter);

            try {
                
                $cnpj = new ValidateCnpj();
                return $cnpj->validateCNPJ($this->data);

            } catch (DocumentValidationException $e) {
                return $e->getMessage();
            }
            
        }

        return "Informe um número para validação";
        
    }
    /**
    *  Válida um documento do tipo CPF
    */
    public function validateCpf($parameter)
    {

        if (!empty($parameter))
        {
            $this->initialize($parameter);

            try {

                $cpf = new ValidateCpf();
                return$cpf->validateCPF($this->data);
                
            } catch (DocumentValidationException $e) {
                return $e->getMessage();
            }

        }

        return "Informe um número para validação";
    }    
}
