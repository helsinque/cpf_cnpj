<?php

namespace Validators\Cpf;

use Validators\AbstractValidate;
use Exceptions\DocumentValidationException;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;

/**
*  Válida um documento do tipo CPF
*/
class ValidateCpf extends AbstractValidate
{

    public $response;
    public $document;

    function __construct($document = null)
    {
        $this->document = $document;
    }

    /**
    *  responsável por validar
    */
    public function validate($value)
    {
        try {
            $result = $this->assertCpf($value);
        } catch (InvalidArgumentException $e) {
            throw new DocumentValidationException($e->getMessage());
        }
        
       return $result;
    }

    /**
    *  responsável por iniciar validação
    */
    public function validateCpf($document)
    {

        $this->document = $document;

        try {
            $this->assertCPF($this->document);
        } catch (InvalidArgumentException $e) {
            throw new DocumentValidationException($e->getMessage());
        }

        $this->response = $document;
        return $this;
    }

    public function getValidation()
    {
        return $this->response;
    }

    public function getName()
    {
        $this->response = self::bipbopValidators($this->response);                
        $xpath = (new \DOMXPath($this->response));

        if (!$xpath->query('//nome')->length) {
            return $xpath = (new \DOMXPath($this->response))->query('//exception');
        }

        return $xpath->query('//nome')->item(0)->nodeValue;
    }
    /**
    *  Válida tamanho do número informado e cálculo verificador
    */
    protected function assertCPF($document)
    {
        $document = preg_replace("/[^\d]/", "", $document);
        self::assertSize($document, 11, "CPF");
        if (self::calculateModule11(substr($document, 0, 9), 2, 12) != substr($document, 9, 2)){
            throw new InvalidArgumentException("O CPF informado não é válido",1);
        }    
            
        return $document;
    }
}