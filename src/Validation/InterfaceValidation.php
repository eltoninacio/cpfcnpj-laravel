<?php

namespace EltonInacio\ValidadorCpfCnpj\Validation;


interface InterfaceValidation
{
    /**
     * Clear special characters and letters
     *
     * @return mixed
     */
    public function clearData();

    /**
     * Execute data validation
     *
     * @return mixed
     */
    public function validation();
}