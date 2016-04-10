<?php

namespace Validators\Cpf;

use Exceptions\DocumentValidationException;
use Validators\FunctionsValidate;

/**
*  Válida um documento do tipo Cpf
*/
class ValidateCpf extends FunctionsValidate
{
    private $number ="";

    /**
    *  responsável por iniciar validação
    */
    public function validateCPF($number)
    {

        $this->number = $number;

        try {
            $this->assertCPF($this->number);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    /**
    *  Válida tamanho do número informado e cálculo verificador
    */
    public function assertCPF($number)
    {
        $number = preg_replace("/[^\d]/", "", $number);
        self::assertSize($number, 11, "CPF");
        if (self::calculateModule11(substr($number, 0, 9), 2, 12) != substr($number, 9, 2))
            throw new DocumentValidationException("O CPF não é válido");
        return $number;
    }
}