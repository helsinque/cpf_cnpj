<?php

namespace Validators\Cnpj;

use Validators\ValidatorsInterface;
use Exceptions\DocumentValidationException;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;
use Validators\AbstractValidate;

/**
 * Class ValidateCnpj.
 *
 * @author Helsinque Cordeiro <helsinquedeveloper@gmail.com">
 */
class ValidateCnpj extends AbstractValidate implements ValidatorsInterface
{

    /**
     * Filter input
     *
     * @param string $value
     */
    private function filterInput($value)
    {
        return preg_replace("/[^\d]/", "", $value);
    }

    /**
     * Check number size
     *
     * @param string $value
     */
    private function validateSize($value)
    {
        if (strlen($value) > 15 || strlen($value) < 14) {
            throw new InvalidArgumentException("$value documento não possue o tamanho adequado", 412);
        }
    }

    /**
     * Check if is a valid number.
     *
     * @param string $value
     */
    private function checkIfIsValid($value)
    {
        $start = strlen($value) == 14 ? 12 : 13;
        if ($this->calculateModule11(substr($value, 0, $start), 2, 9) != substr($value, $start, 2)) {
            throw new InvalidArgumentException("$value documento não é válido", 412);
        }
    }

    /**
     * validate method.
     *
     * @param string $value
     * @return bool true
     */
    public function validate($value)
    {
        $value = $this->filterInput($value);

        $this->validateSize($value);

        $this->checkIfIsValid($value);

        return true;
    }
}
