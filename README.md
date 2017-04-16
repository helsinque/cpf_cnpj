# cpf_cnpj
==========================================

Validador PHP para CPF e CNPJ agnóstico de framework. É uma lib criada para uma validação simples de CPF e CNPJ.

- Valida CPF com ou sem máscara.
- Valida CNPJ com ou sem máscara.

- * Valida documento na Receita Federal através da API "bipbop.com.br"

## TL;DR 

Um simples exemplo de validação de CNPJ e uma com a Bipbop apresetando o retorno da Receita:

## Validações

```php

require __DIR__ . '/vendor/autoload.php';

use Helsinque\Validator as Validate;

$config = [
	'API_BIPBOP_KEY' => null
];

$document = "42.183.878/0001-50";

$validate = new Validate();
$return=  $validate->validate("Cnpj", $document);

OR

$validate = new Validate($config);
$return = $validate->validate("Bipbop", $document);



echo "\n  $return \n";

```
