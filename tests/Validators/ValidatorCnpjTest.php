<?php

namespace Helsinque\Tests\Validators;

use Validators\Cnpj\ValidateCnpj;
use Exceptions\DocumentValidationException;


class ValidatorCpfTest extends \PHPUnit_Framework_TestCase
{
	public function testValidatorCNPJ()
	{
		$validator = new  ValidateCnpj();

		$this->assertInstanceOf(ValidateCnpj::class, $validator);

	}

	public function testEqualsCNPJ()
	{
		$validator = new  ValidateCnpj();

		$this->assertEquals(true, $validator->validateCnpj("03.406.490/0001-19"));
	}

	public function testValidateCnpjWithoutSeparate()
    {
        $validator = new ValidateCnpj();

        $this->assertTrue($validator->validateCnpj("03406490000119"));
    }

    /**
	 * @expectedException Exceptions\DocumentValidationException
	 */
    public function testValidateCnpjInvalid()
    {
        $validator = new ValidateCnpj();

        $validator->validateCnpj("45.364.280/1001-55");
    }	

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValidateCnpjNonStandardSize()
	{

		$instance = new ValidateCnpj();
        
		$this->invokeMethod($instance, 'assertCNPJ', array('45.364.280/0001-55456456'));

	}

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
	
}