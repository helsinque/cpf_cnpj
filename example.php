<?php

require __DIR__ . '/vendor/autoload.php';

use Helsinque\Validator as Validate;

$document = "42.183.878/0001-50";

$return1 = (new validate)->validate("Cnpj", $document);

// $return1 = (new validate)->validate("Bipbop", $document);


echo "\n  $return1 \n";
