<?php

namespace Helsinque;

use Helsinque\Factories\TypeFactory;
use Helsinque\Config;

/**
 * Validator Facade.
 *
 * @author Eduardo Galbiati <eduardo.galbiati7@gmail.com">
 */
class Validator
{
    /**
     * @var \Helsinque\Validators\Validators/Interface
     */
    private $instance;

    /**
     * Constructor method.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        Config::load($options);

        $reflector = new \ReflectionClass('\\Validators\\Validator');
        $this->instance = $reflector->newInstanceArgs([new TypeFactory]);
    }

    /**
     * Validate delegation.
     *
     * @param string $type
     * @param string $value
     */
    public function validate($type, $value)
    {
        return $this->instance->validate($type, $value);
    }

    /**
     * Returns type instance created.
     *
     * @return \Helsinque\Validators\Validators/Interface
     */
    public function getInstance()
    {
        return $this->instance;
    }
}
