<?php

require __DIR__ . '/vendor/autoload.php';

use Validators\Validator as validate;

$document = "355.267.688-05";

// $return1=  (new validate)->validateCNPJ($document);
 $return2=  (new validate)->validateCPF($document);

// $return =  (new validate)->validateWithBIPBOP($document);

echo "\n  $return2 \n";
