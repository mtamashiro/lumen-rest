<?php


use Support\Util\ValidateDocuments;

class ValidateDocumentTest extends TestCase
{
    private const VALID_CNPJ = '99967278000108';
    private const VALID_FORMATTED_CNPJ = '99.967.278/0001-08';
    private const VALID_CPF = '34692288841';
    private const VALID_FORMATTED_CPF = '346.922.888-41';

    public function testValidateCPF()
    {
        $this->assertFalse(ValidateDocuments::validateCPF('adsdsadsads'));
        $this->assertFalse(ValidateDocuments::validateCPF('11111111111'));
        $this->assertTrue(ValidateDocuments::validateCPF(self::VALID_CPF));
        $this->assertTrue(ValidateDocuments::validateCPF(self::VALID_FORMATTED_CPF));
    }

    public function testValidateCNPJ()
    {
        $this->assertFalse(ValidateDocuments::validateCNPJ('adsdsadsads'));
        $this->assertFalse(ValidateDocuments::validateCNPJ('11111111111'));
        $this->assertTrue(ValidateDocuments::validateCNPJ(self::VALID_CNPJ));
        $this->assertTrue(ValidateDocuments::validateCNPJ(self::VALID_FORMATTED_CNPJ));
    }
}
