# cpf_cnpj
==========================================

Validador PHP para CPF e CNPJ agnóstico de framework. É uma lib criada para uma validação simples de CPF e CNPJ.

- Valida CPF com ou sem máscara.
- Valida CNPJ com ou sem máscara. 

## TL;DR 

Vamos começar com um simples e fácil exemplo em primeiro lugar:

## Validações

```php
require __DIR__ . '/vendor/autoload.php';

use Validators\Validator as validate;

$data = new validate;

$numero = "27.732.114/0001-82454";

$return=  $data->validateCNPJ($numero);

echo $return;

```
