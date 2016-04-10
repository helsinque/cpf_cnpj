<?php

namespace Validators\Cnpj;

use Exceptions\DocumentValidationException;
use Validators\FunctionsValidate;
/**
*  Válida um documento do tipo Cnpj
*/
class ValidateCnpj extends FunctionsValidate
{

	private $number ="";

    /**
    *  responsável por iniciar validação
    */
	public function validateCNPJ($number)
	{
		$this->number = $number;

        try {

            $this->assertCNPJ($this->number);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    /**
    *  Válida tamanho do número informado e cálculo verificador
    */
    private function assertCNPJ($number)
    {
        $number = preg_replace("/[^\d]/", "", $number);
        self::assertSize($number, [14, 15], "CNPJ");
        $start = strlen($number) == 14 ? 12 : 13;
        if (self::calculateModule11(substr($number, 0, $start), 2, 9) != substr($number, $start, 2))
            throw new DocumentValidationException("O CNPJ não é válido", 1);
        return $number;
    }
    
}
