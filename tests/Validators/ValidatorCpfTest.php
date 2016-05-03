<?php

namespace Helsinque\Tests\Validators;

use Validators\Cpf\ValidateCpf;


class ValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function testValidatorCPF()
	{
		$validator = new  ValidateCpf();

		$this->assertInstanceOf(ValidateCpf::class, $validator);

	}

	public function testEqualsCPF()
	{
		$validator = new  ValidateCpf();

		$this->assertEquals(true, $validator->validateCPF("360.875.160-26"));
	}

	public function testValidCpfWithoutSeparate()
    {
        $validator = new ValidateCpf();

        $this->assertTrue($validator->validateCPF("36087516026"));
    }

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testEqualsCPFNotRegexMatch()
	{
		$validator = new  ValidateCpf();

		$validator->assertCPF("355.444.555-0587998");
	}
	
}