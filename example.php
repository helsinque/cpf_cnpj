<?php

require __DIR__ . '/vendor/autoload.php';

use Helsinque\Validator as Validate;

$document = "42.183.878/0001-50";

$validate = new Validate();

$return=  $validate->validate("Cnpj", $document);

echo "\n  $return \n";
