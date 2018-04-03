<?php

namespace EltonInacio\ValidadorCpfCnpj\Validation;

use EltonInacio\ValidadorCpfCnpj\Validation\InterfaceValidation;

class Cnpj implements InterfaceValidation
{
    private $cnpj;

    public function __construct($value)
    {
        $this->cnpj = $value;
    }

    /**
     * Clear special characters and letters
     *
     * @param string $value
     * @return void
     */
    public function clearData()
    {
        $this->cnpj = preg_replace('/[^0-9]/', '', $this->cnpj);
    }

    /**
     * Execute data validation
     *
     * @param string $value
     * @return mixed
     */
    public function validation()
    {
        $this->clearData();

        // Validation size
        if (strlen($this->cnpj) != 14) {
            return false;
        }
        // First digit validation
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $this->cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $rest = $sum % 11;

        if ($this->cnpj{12} != ($rest < 2 ? 0 : 11 - $rest)) {
            return false;
        }

        // Second digit validation
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++)
        {
            $sum += $this->cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $rest = $sum % 11;
        return $this->cnpj{13} == ($rest < 2 ? 0 : 11 - $rest);
    }
}