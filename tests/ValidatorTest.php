<?php

namespace Helsinque\Tests;

use Validators\Validator;
use Exceptions\DocumentValidationException;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    protected $validator;

    function setUp()
    {
        parent::setUp();
        $this->validator = new Validator(
            new \Validators\Cpf\ValidateCpf,
            new \Validators\Cnpj\ValidateCnpj 
        );
    }

    public function assertPreConditions()
    {
        $this->assertTrue(
                class_exists($class = 'Validators\Validator'),
                'Class not found: '.$class
        );
        $this->assertInstanceOf('\Validators\Validator', $this->validator);
    }

    public function testValidateCpfShouldReturnTrue()
    {
        $validateCpfMock = $this->getMockBuilder('\Validators\Cpf\ValidatorCpf')
                     ->getMock();

        $validateCpfMock->method('validateCPF')
             ->willReturn(true);

        $validator = new Validator(
            $validateCpfMock,
            new \Validators\Cnpj\ValidateCnpj 
        );

        $this->assertTrue($validator->validateCPF("111"));
    }

    public function testValidateCpfShouldReturnErrorString()
    {
        $validateCpfMock = $this->getMockBuilder('\Validators\Cpf\ValidatorCpf')
                     ->getMock();

        $validateCpfMock->method('validateCPF')
             ->willReturn("Qualquer mensagem de erro");

        $validator = new Validator(
            $validateCpfMock,
            new \Validators\Cnpj\ValidateCnpj 
        );

        $this->assertEquals("Qualquer mensagem de erro", $validator->validateCPF("111"));
    }

    public function testValidateCnpjShouldReturnTrue()
    {
        $validateCnpjMock = $this->getMockBuilder('\Validators\Cnpj\ValidateCnpj')
                     ->getMock();

        $validateCnpjMock->method('validateCnpj')
             ->willReturn(true);

        $validator = new Validator(
            new \Validators\Cpf\ValidateCpf,
            $validateCnpjMock
        );

        $this->assertTrue($validator->validateCnpj("111"));
    }


    public function testValidateCnpjShouldReturnErrorString()
    {
        $validateCnpjMock = $this->getMockBuilder('\Validators\Cnpj\ValidateCnpj')
                     ->getMock();

        $validateCnpjMock->method('validateCnpj')
             ->willReturn('Qualquer error que possa retornar');

        $validator = new Validator(
            new \Validators\Cpf\ValidateCpf,
            $validateCnpjMock
        );

        $this->assertEquals("Qualquer error que possa retornar", $validator->validateCnpj("111"));
    }
    
}