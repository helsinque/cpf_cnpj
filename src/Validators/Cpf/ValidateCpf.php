<?php

namespace Validators\Cpf;

use Validators\AbstractValidate;
use Exceptions\DocumentValidationException;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;
use Validators\ValidatorsInterface;

/**
 * Class ValidateCpf.
 *
 * @author Helsinque Cordeiro <helsinquedeveloper@gmail.com">
 */
class ValidateCpf extends AbstractValidate implements ValidatorsInterface
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
        if (strlen($value) != 11) {
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
        if ($this->calculateModule11(substr($value, 0, 9), 2, 12) != substr($value, 9, 2)) {
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
