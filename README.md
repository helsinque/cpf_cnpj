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

use Validators\Validator as validate;

$document = "42.183.878/0001-50";

// $return01=  (new validate)->validateCNPJ($document);

$return =  (new validate)->validateWithBIPBOP($document);

echo "\n  $return \n";

```
