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

		$this->assertEquals(true, $validator->validateCPF("355.267.688-05"));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testEqualsCPFNotRegexMatch()
	{
		$validator = new  ValidateCpf();

		$validator->assertCPF("355.444.555-05");
	}
	
}