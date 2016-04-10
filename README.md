# cpf_cnpj
==========================================

Validador PHP para CPF e CNPJ agnóstico de framework. É uma lib criada para uma validação simples de CPF e CNPJ.

- Valida CPF com ou sem mácara.
- Valida CNPJ com ou sem mácara. 

## TL;DR 

Vamos começar com um fácil exemplo simples em primeiro lugar:

## Validações

```php
require __DIR__ . '/vendor/autoload.php';

use Validators\Validator as validate;

$data = new validate;

$numero = "xxx.xxx.xxx-xx";

try
{
	$return=  $data->validateCpf($numero);

} catch (Exception $e) {


	$return= $e->getMessage();
}

echo $return;

```
