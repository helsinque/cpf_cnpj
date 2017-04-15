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
    public function validateCNPJ($parameter)
    {

        if (!empty($parameter))
        {            
            $this->initialize($parameter);

            try {                
                ( new ValidateCnpj() )->validateCnpj($this->data);
                return true;

            } catch (DocumentValidationException $e) {
                return $e->getMessage();
            }
            
        }

        return "Informe um número para validação";
        
    }

    /**
    *  Válida um documento do tipo CPF
    */
    public function validateCPF($parameter)
    {

        if (!empty($parameter))
        {
            $this->initialize($parameter);
            $response = null;

            try {
                ( new ValidateCpf )->validateCpf($this->data)->getValidation();
                return true;                
                
            } catch (DocumentValidationException $e) {
                return $e->getMessage();
            }

        }

        return "Informe um número para validação";
    }

    /**
    *  Válida um documento direto na API da BIPBOP
    * @return (string) nome referênte ao documento
    */
    
    public function validateWithBIPBOP($parameter)
    {

        if (!empty($parameter))
        {
            $this->initialize($parameter);

            try {

                return ( new ValidateCpf )->validateCpf($this->data)->getName();
                
            } catch (DocumentValidationException $e) {

                if (preg_match('/^CPF/', $e->getMessage())) {

                    try {
                
                        return ( new ValidateCnpj() )->validateCnpj($this->data)->getName();

                    } catch (DocumentValidationException $e) {
                        
                        return $e->getMessage();
                    }
                }

                return $e->getMessage();
            }

        }

        return "Informe um número para validação";
    }    
}
