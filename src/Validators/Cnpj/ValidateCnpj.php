<?php

namespace Validators\Cnpj;

use Validators\AbstractValidate;
use Validators\ValidatorsInterface;
use Exceptions\DocumentValidationException;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;

/**
*  Válida um documento do tipo CNPJ
*/
class ValidateCnpj extends AbstractValidate implements ValidatorsInterface
{

    public $response;
    public $document;

    public function __construct($document = null)
    {
        $this->document = $document;
    }

    /**
    *  responsável por validar
    */
    public function validate($value)
    {
        try {
            $result = $this->assertCNPJ($value);
        } catch (InvalidArgumentException $e) {
            throw new DocumentValidationException($e->getMessage());
        }
        
        return $result;
    }

    /**
    *  responsável por iniciar validação
    */
    public function validateCnpj($document)
    {
        $this->document = $document;

        try {
            $this->assertCNPJ($this->document);
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
        $xpath = (new \DOMXPath($this->response))->query('//nome');
        return $xpath->item(0)->nodeValue;
    }
    /**
    *  Válida tamanho do número informado e cálculo verificador
    */
    protected function assertCNPJ($response)
    {
        $response = preg_replace("/[^\d]/", "", $response);
        self::assertSize($response, [14, 15], "CNPJ");
        $start = strlen($response) == 14 ? 12 : 13;
        if (self::calculateModule11(substr($response, 0, $start), 2, 9) != substr($response, $start, 2)) {
            throw new InvalidArgumentException("O CNPJ não é válido", 1);
        }
        return $response;
    }
}
