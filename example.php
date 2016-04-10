<?php

require __DIR__ . '/vendor/autoload.php';

use Validators\Validator as validate;

$data = new validate;

$numero = "355.267.688-05";

try
{
	$return=  $data->validateCnpj($numero);

} catch (Exception $e)
{
	try
	{
		$return=  $data->validateCpf($numero);

	} catch (Exception $e) {


		$return= $e->getMessage();
	}

}

echo $return;

