<?php

namespace Validators;

use Exceptions\DocumentValidationException;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;

/**
*  classe com algoritimos de validações diversas
*/

class AbstractValidate
{

    /**
    *  Válida tamanho do número informado
    */
    protected function assertSize($value, $size, $documento)
    {
        if (!in_array(strlen($value), (array) $size))
            throw new InvalidArgumentException("$documento não possue o tamanho adequado", 2);
    }

    /**
    *  realiza cálculos de validação dos documentos
    */
    protected function calculateModule11($numDado, $numDig, $limMult)
    {
        $dado = $numDado;

        for ($n = 1; $n <= $numDig; $n++) {
            $soma = 0;
            $mult = 2;
            for ($i = strlen($dado) - 1; $i >= 0; $i--) {
                $soma += $mult * intval(substr($dado, $i, 1));
                if (++$mult > $limMult)
                    $mult = 2;
            }
            $dado .= strval(fmod(fmod(($soma * 10), 11), 10));
        }

        return substr($dado, strlen($dado) - $numDig);
    }   
}
