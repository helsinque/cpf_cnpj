<?php

namespace Validators\Bipbop;

use Validators\AbstractValidate;
use Validators\ValidatorsInterface;
use Validators\Cpf\ValidateCpf;
use Validators\Cnpj\ValidateCnpj;
use Exceptions\DocumentValidationException;
use SebastianBergmann\ObjectEnumerator\InvalidArgumentException;

/**
 * Class Abstract Validate.
 *
 * @author Helsinque Cordeiro <helsinquedeveloper@gmail.com">
 */
class ValidateBipbop extends AbstractValidate implements ValidatorsInterface
{
    public $response;
    public $document;

    /**
     * Constructor method.
     *
     * @param string $document
     */
    public function __construct($document = null)
    {
        $this->document = $document;
        $this->validateCpf = new ValidateCpf();
        $this->validateCnpj = new ValidateCnpj();
    }

    /**
    *  responsável por validar
    *
    * @param  string $document
    * @return string nome referênte ao documento
    */
    public function validate($value)
    {
        try {
            $result = $this->validateWithBIPBOP($value);
        } catch (InvalidArgumentException $e) {
            throw new DocumentValidationException($e->getMessage());
        }
        
        return $result;
    }

    /**
     *  Valida um documento direto na API da BIPBOP
     *
     * @param  string $document
     * @return string nome referênte ao documento
     */
    public function validateWithBIPBOP($parameter)
    {
        if (empty($parameter)) {
            return "Informe um número para validação";
        }

        try {
            return $this->validateCpf->validateCpf($parameter)->getName();
        } catch (DocumentValidationException $e) {
            if (preg_match('/^CPF/', $e->getMessage())) {
                try {
                    return $this->validateCnpj->validateCnpj($parameter)->getName();
                } catch (DocumentValidationException $e) {
                    return $e->getMessage();
                }
            }
            return $e->getMessage();
        }
    }

    /**
     * BipBop API Call
     *
     * @param  string $document
     * @return XML
     */
    protected function bipbopValidators($document = null)
    {
        $webService = new WebService(Config::get('API_BIPBOP_KEY'));
        
        try {
            $query = sprintf("SELECT FROM 'BIPBOPJS'.'CPFCNPJ' WHERE 'DOCUMENTO' ='%s'", $document);
            $dom = $webService->post($query);
        } catch (Exception $e) {
            throw new DocumentValidationException($e->getBIPBOPMessage());
        }
        return $dom;
    }
}
