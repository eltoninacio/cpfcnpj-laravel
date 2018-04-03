<?php

namespace EltonInacio\ValidadorCpfCnpj\Tests;

use EltonInacio\ValidadorCpfCnpj\Validation\CpfCnpjValidation;

class CpfCnpjValidationTest extends \PHPUnit_Framework_TestCase 
{
    
    protected function validate($value, $rule){
        $factory = new CpfCnpjValidation($this->getTranslator(), ['test' => $value], ['test' => $rule]);
        return !($factory->fails());
    }

    protected function getTranslator()
    {
        $loader = new \Illuminate\Translation\ArrayLoader;
        return new \Illuminate\Translation\Translator($loader, 'en');
    }

    public function testCpfValidation(){
        $this->assertEquals(true,  $this->validate('366.021.203-28', 'cpf'));
    }

    public function testCnpjValidation()
    {
        $this->assertEquals(true,  $this->validate('18.340.166/0001-12', 'cnpj'));
    }

    public function testCpfCnpjValidation()
    {
        $this->assertEquals(true,  $this->validate('366.021.203-28', 'cpfcnpj'));
        $this->assertEquals(true,  $this->validate('18.340.166/0001-12', 'cpfcnpj'));
    }

    public function testCnpjSequenceFailsValidation()
    {
        $this->assertEquals(false,  $this->validate('11.111.111/1111-11', 'cnpj'));
        $this->assertEquals(false,  $this->validate('22.222.222/2222-22', 'cnpj'));
        $this->assertEquals(false,  $this->validate('33.333.333/3333-33', 'cnpj'));
        $this->assertEquals(false,  $this->validate('44.444.444/4444-44', 'cnpj'));
        $this->assertEquals(false,  $this->validate('55.555.555/5555-55', 'cnpj'));
        $this->assertEquals(false,  $this->validate('66.666.666/6666-66', 'cnpj'));
        $this->assertEquals(false,  $this->validate('77.777.777/7777-77', 'cnpj'));
        $this->assertEquals(false,  $this->validate('88.888.888/8888-88', 'cnpj'));
        $this->assertEquals(false,  $this->validate('99.999.999/9999-99', 'cnpj'));
    }

}