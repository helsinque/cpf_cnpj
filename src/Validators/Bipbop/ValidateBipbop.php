<?php

namespace Validators\Bipbop;

use Validators\AbstractValidate;
use Validators\ValidatorsInterface;
use Validators\Cpf\ValidateCpf;
use Validators\Cnpj\ValidateCnpj;
use Exceptions\DocumentValidationException;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;


/**
*  Válida um documento do tipo CPF
*/
class ValidateBipbop extends AbstractValidate implements ValidatorsInterface
{

    public $response;
    public $document;

    function __construct($document = null)
    {
        $this->document = $document;
        $this->validateCpf = new ValidateCpf();
        $this->validateCnpj = new ValidateCnpj();
    }

    /**
    *  responsável por validar
    */
    public function validate($value)
    {
        try {
            $result = $this->validateWithBIPBOP($value);
        } catch (InvalidArgumentException $e) {
            throw new DocumentValidationException($e->getMessage());
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