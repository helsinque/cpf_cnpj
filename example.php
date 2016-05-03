<?php

require __DIR__ . '/vendor/autoload.php';

use Validators\Validator as validate;

$data = new validate;

$numero = "03.406.490/0001-19";

$return=  $data->validateCnpj($numero);

echo $return;

