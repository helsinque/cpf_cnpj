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
    private $validateCpf;
    private $validateCnpj;

    /**
    * 
    */
    public function __construct()
    {
        $this->validateCpf =  new \Validators\Cpf\ValidateCpf;
        $this->validateCnpj = new \Validators\Cnpj\ValidateCnpj;
    }

    /**
    *  Válida um documento do tipo CNPJ
    */
    public function validateCNPJ($value)
    {

        if (empty($value)) {
            return "Informe o parametro";
        }
                   
        try {                
            $this->validateCnpj->validateCnpj($value);
            return true;
        } catch (DocumentValidationException $e) {
            return $e->getMessage();
        }
            
        return $result;
    }

    /**
    *  Válida um documento do tipo CPF
    */
    public function validateCPF($value)
    {

        if (empty($value)) {
            return "Informe o parametro";
        }
        
        try {
            $this->validateCpf->validateCpf($value);
            return true;
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
