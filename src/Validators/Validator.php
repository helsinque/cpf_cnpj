<?php

namespace Validators;

use Validators\Cpf\ValidateCpf;
use Validators\Cnpj\ValidateCnpj;

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
    *  Válida um documento do tipo Cnpj
    */
    public function validateCnpj($parameter)
    {

        if (!empty($parameter))
        {            
            $this->initialize($parameter);
            $cnpj = new ValidateCnpj();

            return $cnpj->validateCNPJ($this->data);
        }

        return "Informe um número para validação";
        
    }
    /**
    *  Válida um documento do tipo Cpf
    */
    public function validateCpf($parameter)
    {

        if (!empty($parameter))
        {
            $this->initialize($parameter);
            $cpf = new ValidateCpf();
            return$cpf->validateCPF($this->data);

        }

        return "Informe um número para validação";
    }    
}
