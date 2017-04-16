<?php

require __DIR__ . '/vendor/autoload.php';

use Helsinque\Validator as Validate;

$document = "42.183.878/0001-50";

// $return1=  (new validate)->validateCNPJ($document);
$validate = new Validate;
$return2=  $validate->validate("Cpf", $document);

// $return =  (new validate)->validateWithBIPBOP($document);


echo "\n  $return2 \n";
