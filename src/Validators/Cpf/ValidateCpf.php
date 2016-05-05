<?php

namespace Validators\Cpf;

use Validators\AbstractValidate;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;
use Exceptions\DocumentValidationException;

/**
*  Válida um documento do tipo Cpf
*/
class ValidateCpf extends AbstractValidate
{
    private $number ="";

    /**
    *  responsável por iniciar validação
    */
    public function validateCpf($number)
    {

        $this->number = $number;

        try {
            $this->assertCPF($this->number);
        } catch (InvalidArgumentException $e) {
            throw new DocumentValidationException($e->getMessage());
        }
        return true;
    }
    /**
    *  Válida tamanho do número informado e cálculo verificador
    */
    protected function assertCPF($number)
    {
        $number = preg_replace("/[^\d]/", "", $number);
        self::assertSize($number, 11, "CPF");
        if (self::calculateModule11(substr($number, 0, 9), 2, 12) != substr($number, 9, 2)){
            throw new InvalidArgumentException("O CPF informado não é válido",1);
        }    
            
        return $number;
    }
}