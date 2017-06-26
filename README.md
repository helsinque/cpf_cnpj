# cpf_cnpj
===========================================

Validador PHP para CPF e CNPJ agnóstico de framework. É uma lib criada para uma validação simples de CPF e CNPJ.

- Valida CPF com ou sem máscara.
- Valida CNPJ com ou sem máscara.

- * Valida documento na Receita Federal através da API "bipbop.com.br"

## TL;DR 

Um simples exemplo de validação de CNPJ e uma com a Bipbop apresetando o retorno da Receita:

## Validações

```php

require __DIR__ . '/vendor/autoload.php';

$validate = new Helsinque\Validator();

try {
    $result = $validate->validate("Cnpj", "42.183.878/0001-50");
} catch (\Exception $e) {
    echo $e->getMessage();
}

echo $result; //true

```

## For BipBop info

```php

require __DIR__ . '/vendor/autoload.php';

$config = [
    'API_BIPBOP_KEY' => YOUR_KEY_HERE
];

$validate = new Helsinque\Validator($config);

try {
    $result = $validate->validate("BipBop", "42.183.878/0001-50");
} catch (\Exception $e) {
    echo $e->getMessage();
}

echo $result; //informações sobre o cnpj

```
