<?php

namespace Helsinque\Tests\Validators;

use Validators\Cpf\ValidateCpf;
use Exceptions\DocumentValidationException;

class ValidatorCpfTest extends \PHPUnit_Framework_TestCase
{
	protected $cpfValidator;

    public function assertPreConditions()
    {
        $this->assertTrue(
                class_exists($class = '\Validators\Cpf\ValidateCpf'),
                'Class not found: '.$class
        );

        $this->cpfValidator = new \Validators\Cpf\ValidateCpf();
    }

	 public function testValidateCpfWithOkCpfShouldReturnTrue()
    {
       $this->assertTrue($this->cpfValidator->validate("605.456.271-17"));
       $this->assertTrue($this->cpfValidator->validate("60545627117"));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage 1234567890 documento não possue o tamanho adequado
     */
    public function testValidateCpfWith10SizeShouldThrowException()
    {
        $this->cpfValidator->validate("1234567890");
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage 123456789012 documento não possue o tamanho adequado
     */
    public function testValidateCpfWith12SizeShouldThrowException()
    {
        $this->cpfValidator->validate("123456789012");
    }

     /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage 60545627110 documento não é válido
     */
    public function testValidateCpfWithInvalidNumberShouldThrowException()
    {
        $this->cpfValidator->validate("605.456.271-10");
    } 
}