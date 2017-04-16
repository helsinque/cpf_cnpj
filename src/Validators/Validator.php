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
        $validator = $this->typeFactory->make($type);

        try {
            $result = $validator->validate($value);
        } catch (\Exception $e) {
            throw new DocumentValidationException($e->getMessage(), 412, $e);
        }

        return $result;
    }
}
