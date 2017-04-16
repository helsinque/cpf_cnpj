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
    * Método construtor serve pra se injetar as depenencias necessárias para esta classe, ou os recursos que ela irá consumir
    */
    public function __construct
    (
        \Validators\Cpf\ValidateCpf $validateCpf,
        \Validators\Cnpj\ValidateCnpj $validateCnpj   
    ) {
        $this->validateCpf = $validateCpf;
        $this->validateCnpj = $validateCnpj;
    }

    /**
    *  Válida um documento do tipo CNPJ
    */
    public function validateCNPJ(string $value)
    {

        if (empty($value)) {
            return "Informe o parametro";
        }
                   
        try {                
            $result = $this->validateCnpj->validateCnpj($value);
        } catch (DocumentValidationException $e) {
            return $e->getMessage();
        }
            
        return $result;
    }

    /**
    *  Válida um documento do tipo CPF
    */
    public function validateCPF(string $value)
    {

        if (empty($value)) {
            return "Informe o parametro";
        }
        
        try {
            $result = $this->validateCpf->validateCpf($value);                
        } catch (DocumentValidationException $e) {
            return $e->getMessage();
        }

        return $result;
    }

    /**
    *  Válida um documento direto na API da BIPBOP
    * @return (string) nome referênte ao documento
    */
    
   /* public function validateWithBIPBOP($parameter)
    {

        if (empty($parameter)) {
            return "Informe um número para validação";
        }

        $this->initialize($parameter);

        try {
            return $this->validateCpf->validateCpf($this->data)->getName();
            
        } catch (DocumentValidationException $e) {

            if (preg_match('/^CPF/', $e->getMessage())) {

                try {
            
                    return $this->validateCnpj->validateCnpj($this->data)->getName();

                } catch (DocumentValidationException $e) {
                    
                    return $e->getMessage();
                }
            }

            return $e->getMessage();
        }

        }

    }    */
}
