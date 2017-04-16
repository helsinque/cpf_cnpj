<?php

namespace Validators;

use Exceptions\DocumentValidationException;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;
use BIPBOP\Client\WebService;
use BIPBOP\Client\Exception;
use Helsinque\Config;

/**
 * Class Abstract Validate.
 *
 * @author Helsinque Cordeiro <helsinquedeveloper@gmail.com">
 */
abstract class AbstractValidate
{
    /**
     * Digit document validation
     *
     * @param  string $numDado
     * @param  string $numDig
     * @param  string $limMult
     * @return string
     */
    protected function calculateModule11($numDado, $numDig, $limMult)
    {
        $dado = $numDado;

        for ($n = 1; $n <= $numDig; $n++) {
            $soma = 0;
            $mult = 2;
            for ($i = strlen($dado) - 1; $i >= 0; $i--) {
                $soma += $mult * intval(substr($dado, $i, 1));
                if (++$mult > $limMult) {
                    $mult = 2;
                }
            }
            $dado .= strval(fmod(fmod(($soma * 10), 11), 10));
        }

        return substr($dado, strlen($dado) - $numDig);
    }
}
