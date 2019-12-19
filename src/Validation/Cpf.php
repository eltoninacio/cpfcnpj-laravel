<?php

namespace EltonInacio\ValidadorCpfCnpj\Validation;

use EltonInacio\ValidadorCpfCnpj\Validation\InterfaceValidation;

class Cpf implements InterfaceValidation
{
    private $cpf;

    public function __construct($value)
    {
        $this->cpf = $value;
    }

    /**
     * Clear special characters and letters
     *
     * @param string $value
     * @return void
     */
    public function clearData()
    {
        $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);
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

        /**
         * Verify cpf contains 11 characters
         */
        if (strlen($this->cpf) != 11) {
            return false;
        }

        /**
         * Verify cpf are 11111111111 in between 99999999999
         */
        if (preg_match('/(\d)\1{10}/', $this->cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $this->cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($this->cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}