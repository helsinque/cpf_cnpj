<?php

namespace Helsinque\Tests\Factories;

use Validators\Cnpj\ValidateCnpj;
use Helsinque\Factories\TypeFactory;

class TypeFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function assertPreConditions()
    {
        $this->assertTrue(
                class_exists($class = '\Helsinque\Factories\TypeFactory'),
                'Class not found: '.$class
        );
    }

    public function testMakeMethod()
    {
        $typeFactory = new TypeFactory;
    	$class = $typeFactory->make("Cnpj");
    	$this->assertInstanceOf('\Validators\Cnpj\ValidateCnpj', $class);
    }
}