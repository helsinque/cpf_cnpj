<?php

namespace Validators\Cnpj;

use Validators\Validator;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;
use Exceptions\DocumentValidationException;

/**
*  Válida um documento do tipo Cnpj
*/
class ValidateCnpj extends Validator
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
        } catch (InvalidArgumentException $e) {
            throw new DocumentValidationException($e->getMessage());
        }
        return true;
    }
    /**
    *  Válida tamanho do número informado e cálculo verificador
    */
    protected function assertCNPJ($number)
    {
        $number = preg_replace("/[^\d]/", "", $number);
        self::assertSize($number, [14, 15], "CNPJ");
        $start = strlen($number) == 14 ? 12 : 13;
        if (self::calculateModule11(substr($number, 0, $start), 2, 9) != substr($number, $start, 2))
            throw new InvalidArgumentException("O CNPJ não é válido", 1);            
        return $number;
    }
    
}
