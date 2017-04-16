<?php

namespace Validators;

use Validators\Cpf\ValidateCpf;
use Validators\Cnpj\ValidateCnpj;
use Exceptions\DocumentValidationException;
use Helsinque\Factories\TypeFactory;

/**
 * Class Validator.
 *
 * @author Helsinque Cordeiro <helsinquedeveloper@gmail.com">
 */
class Validator
{
    /**
     * @var \Helsinque\Factories\TypeFactory
     */
    private $typeFactory;

    /**
     * Constructor method.
     *
     * @param \Helsinque\Factories\TypeFactory $typeFactory
     */
    public function __construct(TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
    }

    /**
     * Generic validator
     *
     * @param  string $type
     * @param  string $value
     * @return string
     */
    public function validate($type, $value)
    {
        if (empty($value)) {
            return "Informe o parametro";
        }

        try {
            $result = $this->typeFactory->make($type)->validate($value);
        } catch (DocumentValidationException $e) {
            return $e->getMessage();
        }

        return $result;
    }
}
