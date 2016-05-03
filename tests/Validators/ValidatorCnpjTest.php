<?php

namespace Helsinque\Tests\Validators;

use Validators\Cnpj\ValidateCnpj;
use Validators\Validator;


class ValidatorCnpjTest extends \PHPUnit_Framework_TestCase
{
	public function testValidatorCNPJ()
	{
		$validator = new  ValidateCnpj();

		$this->assertInstanceOf(ValidateCnpj::class, $validator);

	}

	public function testEqualsCNPJ()
	{
		$validator = new  ValidateCnpj();

		$this->assertEquals(true, $validator->validateCNPJ("03.406.490/0001-19"));
	}

	public function testValidCnpjWithoutSeparate()
    {
        $validator = new ValidateCnpj();

        $this->assertTrue($validator->validateCNPJ("03406490000119"));
    }

	/**
	 * @expectedException InvalidArgumentException
	 */
	// public function testEqualsCNPJNotRegexMatch()
	// {
	// 	$validator = new  ValidateCnpj();

	// 	$validator->assertCNPJ("355.444.555-0587998354645645364645");
	// }


	/**
	 * Call protected/private method of a class.
	 *
	 * @param object &$object    Instantiated object that we will run method on.
	 * @param string $methodName Method name to call
	 * @param array  $parameters Array of parameters to pass into method.
	 *
	 * @return mixed Method return.
	 */
	public function invokeMethod(&$object, $methodName, array $parameters = array())

	{

	    $reflection = new \ReflectionClass(get_class($object));
	    $method = $reflection->getMethod($methodName);
	    $method->setAccessible(true);

	    return $method->invokeArgs($object, $parameters);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFunctionName()
	{
		$instance = new ValidateCnpj();		

		  try {
        
		        $this->invokeMethod($instance, 'ValidateCnpj', array('355.444.555-0587998354645645364645'));

		    } catch (DocumentValidationException $e) {

		        $this->assertType('DocumentValidationException', $e);
		        $this->assertType('MainException', $e);
		    }

		//$instance->assertCNPJ('assertCNPJ');
	}

	

	
}