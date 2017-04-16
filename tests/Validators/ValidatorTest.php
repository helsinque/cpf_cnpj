<?php

namespace Helsinque\Tests;

use Validators\Validator;
use Exceptions\DocumentValidationException;
use Helsinque\Factories\TypeFactory;

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

    public function testValidateCpfShouldReturnErrorString()
    {
        $validateCpfMock = $this->getMockBuilder('\Validators\Cpf\ValidateCpf')
                     ->getMock();

        $validateCpfMock->method('validate')
             ->willReturn("Qualquer mensagem de erro");

        $typeFactoryMock = $this->getMockBuilder('\Helsinque\Factories\TypeFactory')
            ->getMock();

        $typeFactoryMock->method('make')
             ->willReturn($validateCpfMock);

        $validator = new Validator($typeFactoryMock);

        $this->assertEquals("Qualquer mensagem de erro", $validator->validate("Cpf","111"));
    }

    public function testValidateCnpjShouldReturnTrue()
    {
        $validateCnpjMock = $this->getMockBuilder('\Validators\Cnpj\ValidateCnpj')
                     ->getMock();

        $validateCnpjMock->method('validate')
             ->willReturn(true);

        $typeFactoryMock = $this->getMockBuilder('\Helsinque\Factories\TypeFactory')
            ->getMock();

        $typeFactoryMock->method('make')
             ->willReturn($validateCnpjMock);

        $validator = new Validator($typeFactoryMock);

        $this->assertTrue($validator->validate("Cnpj", "111"));
    }


    public function testValidateCnpjShouldReturnErrorString()
    {
        $validateCnpjMock = $this->getMockBuilder('\Validators\Cnpj\ValidateCnpj')
                     ->getMock();

        $validateCnpjMock->method('validate')
             ->willReturn('Qualquer error que possa retornar');

        $typeFactoryMock = $this->getMockBuilder('\Helsinque\Factories\TypeFactory')
            ->getMock();

        $typeFactoryMock->method('make')
             ->willReturn($validateCnpjMock);

        $validator = new Validator($typeFactoryMock);

        $this->assertEquals("Qualquer error que possa retornar", $validator->validate("Cnpj", "111"));
    }
    
}