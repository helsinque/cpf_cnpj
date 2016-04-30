<?php

require __DIR__ . '/vendor/autoload.php';

use Validators\Validator as validate;

$data = new validate;

$numero = "024.913.300-83";

$return=  $data->validateCpf($numero);

echo $return;

