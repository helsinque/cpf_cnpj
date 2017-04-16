<?php

namespace Helsinque\Tests;

use Validators\Validator;
use Helsinque\Factories\TypeFactory;

use Exceptions\DocumentValidationException;
use Exceptions\InvalidValidatorTypeException;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    protected $validator;

    public function assertPreConditions()
    {
        $this->assertTrue(
                class_exists($class = 'Validators\Validator'),
                'Class not found: '.$class
        );
    }

    public function testValidateCpfShouldReturnTrue()
    {
        $validateCpfMock = $this->getMockBuilder('\Validators\Cpf\ValidateCpf')
            ->getMock();

        $validateCpfMock->method('validate')
            ->willReturn(true);

        $typeFactoryMock = $this->getMockBuilder('\Helsinque\Factories\TypeFactory')
            ->getMock();

        $typeFactoryMock->method('make')
            ->willReturn($validateCpfMock);

        $validator = new Validator($typeFactoryMock);

        $this->assertTrue($validator->validate("Cpf", "111"));
    }

    /**
     * @expectedException Exceptions\DocumentValidationException
     * @expectedExceptionMessage Erro ao validar campos
     */
    public function testValidateCpfShouldThrowException()
    {
        $validateCpfMock = $this->getMockBuilder('\Validators\Cpf\ValidateCpf')
                     ->getMock();

        $validateCpfMock->method('validate')
            ->willThrowException(new \Exception("Erro ao validar campos"));

        $typeFactoryMock = $this->getMockBuilder('\Helsinque\Factories\TypeFactory')
            ->getMock();

        $typeFactoryMock->method('make')
            ->willReturn($validateCpfMock);

        $validator = new Validator($typeFactoryMock);

        $validator->validate("Cpf", "");
    } 

    /**
     * @expectedException Exceptions\InvalidValidatorTypeException
     * @expectedExceptionMessage Erro ao construir o objeto
     */
    public function testValidateCpfWithUnknowTypeShouldThrowException()
    {
        $typeFactoryMock = $this->getMockBuilder('\Helsinque\Factories\TypeFactory')
            ->getMock();

        $typeFactoryMock->method('make')
            ->willThrowException(new InvalidValidatorTypeException("Erro ao construir o objeto"));

        $validator = new Validator($typeFactoryMock);

        $validator->validate("Cpf", "");
    } 
}