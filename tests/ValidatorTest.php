<?php

namespace Helsinque\Tests;

use Validators\Validator;
use Exceptions\DocumentValidationException;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $validator = new  Validator();

        $this->assertInstanceOf(Validator::class, $validator);
    }

    public function testFunctionValidateCPF()
    {
        $validator = new  Validator();

        $this->assertTrue($validator->validateCPF("633.879.090-55"));
    }

    public function testFunctionValidateCPFWithoutSeparate()
    {
        $validator = new  Validator();

        $this->assertTrue($validator->validateCPF("63387909055"));
    }

    public function testEqualsFunctionValidatePossibleErrorsCPF()
    {
        $validator = new  Validator();

        $this->assertEquals("Informe um número para validação", $validator->validateCPF(""));

        $this->assertEquals("O CPF informado não é válido", $validator->validateCPF("699.879.090-33"));

        $this->assertEquals("CPF não possue o tamanho adequado", $validator->validateCPF("34555.56566732.4453"));

    }

    public function testFunctionValidateCNPJ()
    {
        $validator = new  Validator();

        $this->assertTrue($validator->validateCNPJ("11.720.117/0001-66"));
    }

    public function testFunctionValidateCNPJithoutSeparate()
    {
        $validator = new  Validator();

        $this->assertTrue($validator->validateCNPJ("11720117000166"));
    }

    public function testEqualsFunctionValidatePossibleErrorsCNPJ()
    {
        $validator = new  Validator();

        $this->assertEquals("Informe um número para validação", $validator->validateCNPJ(""));

        $this->assertEquals("O CNPJ não é válido", $validator->validateCNPJ("22.720.117/1001-66"));

        $this->assertEquals("CNPJ não possue o tamanho adequado", $validator->validateCNPJ("11.720.117/0001-66564999"));

    }
    
}