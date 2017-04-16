<?php

namespace Exceptions;

use Exception;

/**
 * Exceção de quando um documento não é válido
 */
class DocumentValidationException extends Exception
{
    // Redefine a exceção de forma que a mensagem não seja opcional
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        
        // garante que tudo está corretamente inicializado
        parent::__construct($message, $code, $previous);
    }
}
