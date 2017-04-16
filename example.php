<?php

require __DIR__ . '/vendor/autoload.php';

use Helsinque\Validator as Validate;

$document = "42.183.878/0001-50";

$validate = new Validate();

try {
    $return = $validate->validate("Cnpj", $document);
} catch (\Exception $e) {
    echo $e->getMessage();die;
}

echo 'Documento Ok';
