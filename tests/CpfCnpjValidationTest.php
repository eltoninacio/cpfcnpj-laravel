<?php

namespace EltonInacio\ValidadorCpfCnpj\Tests;

use EltonInacio\ValidadorCpfCnpj\Validation\CpfCnpjValidation;
use Symfony\Component\Translation\Translator;

class CpfCnpjValidationTest extends \PHPUnit_Framework_TestCase 
{
    
    protected function validate($value, $rule){
        $factory = new CpfCnpjValidation(new Translator('en'), ['test' => $value], ['test' => $rule]);
        return !($factory->fails());
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

}