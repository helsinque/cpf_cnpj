<?php

require __DIR__ . '/vendor/autoload.php';

use Helsinque\Validator as Validate;

$document = "42.183.878/0001-50";

// $return1=  (new validate)->validateCNPJ($document);
$validate = new Validate(['API_BIPBOP_KEY' => 'YOUR_KEY']);

$return2=  $validate->validate("Cnpj", $document);

// $return =  (new validate)->validateWithBIPBOP($document);


echo "\n  $return2 \n";
