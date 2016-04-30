<?php

require __DIR__ . '/vendor/autoload.php';

use Validators\Validator as validate;

$data = new validate;

$numero = "27.732.114/0001-82454";


		$return=  $data->validateCnpj($numero);

	

echo $return;

