<?php

namespace Helsinque\Tests\Validators;

use Validators\Cnpj\ValidateCnpj;
use Exceptions\DocumentValidationException;

class ValidatorCnpjTest extends \PHPUnit_Framework_TestCase
{
    protected $cnpjValidator;

    public function assertPreConditions()
    {
        $this->assertTrue(
                class_exists($class = '\Validators\Cnpj\ValidateCnpj'),
                'Class not found: '.$class
        );

        $this->cnpjValidator = new \Validators\Cnpj\ValidateCnpj();
    }

    public function testValidateCnpjWithOkCnpjShouldReturnTrue()
    {
       $this->assertTrue($this->cnpjValidator->validate("42.183.878/0001-50"));
       $this->assertTrue($this->cnpjValidator->validate("42183878000150"));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage 1234567890123 documento não possue o tamanho adequado
     */
    public function testValidateCnpjWith13SizeShouldThrowException()
    {
        $this->cnpjValidator->validate("1234567890123");
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage 1234567890123456 documento não possue o tamanho adequado
     */
    public function testValidateCnpjWith16SizeShouldThrowException()
    {
        $this->cnpjValidator->validate("1234567890123456");
    }

     /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage 123456789012345 documento não é válido
     */
    public function testValidateCnpjWithInvalidNumberShouldThrowException()
    {
        $this->cnpjValidator->validate("123456789012345");
    }  
}