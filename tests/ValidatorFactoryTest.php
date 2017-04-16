<?php

namespace Helsinque\Tests\Factories;

use Validators\Validator;
use Helsinque\Validator as HValidator;

class ValidatorFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function assertPreConditions()
    {
        $this->assertTrue(
                class_exists($class = '\Helsinque\Validator'),
                'Class not found: '.$class
        );
    }

    public function testInvokeMethod()
    {
    	$class = new HValidator([]);
    	$this->assertInstanceOf('\Validators\Validator', $class->getInstance());
    }
}