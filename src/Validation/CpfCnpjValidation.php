<?php

namespace EltonInacio\ValidadorCpfCnpj\Validation;

use Illuminate\Validation\Validator as IlluminateValidator;
use EltonInacio\ValidadorCpfCnpj\Validation\Cpf;
use EltonInacio\ValidadorCpfCnpj\Validation\Cnpj;

class CpfCnpjValidation extends IlluminateValidator
{
	private $_custom_messages = array(
		"cpfcnpj" 	=> "O :attribute inválido.",
		"cpf" 		=> "O :attribute inválido.",
		"cnpj"		=> "O :attribute inválido.",
	);

	public function __construct( $translator, $data, $rules, $messages = array(), $customAttributes = array() ) {
		parent::__construct( $translator, $data, $rules, $messages, $customAttributes );

		$this->_set_custom_stuff();
	}

	/**
	 * Setup any customizations etc
	 *
	 * @return void
	 */
	protected function _set_custom_stuff() {
		//setup our custom error messages
		$this->setCustomMessages( $this->_custom_messages );
	}

	/**
	 * Validate that an attribute is a valid cpf or cnpj.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateCpfCnpj($attribute, $value, $parameters)
	{
		if (strlen(preg_replace('/\D/', '', $value))==11) { // cpf
			return $this->validateCpf($attribute, $value, $parameters);
		} elseif (strlen(preg_replace('/\D/', '', $value))==14) { // cnpj
			return $this->validatecnpj($attribute, $value, $parameters);
		}
	}

	/**
	 * Validate that an attribute is a valid CPF.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateCpf($attribute, $value, $parameters)
	{
	    return (new Cpf($value))->validation();
	}

	/**
	 * Validate that an attribute is a valid CNPJ.
	 *
	 * @param  string  $attribute
	 * @param  mixed   $value
	 * @return bool
	 */
	protected function validateCnpj($attribute, $value, $parameters)
	{
	    return (new Cnpj($value))->validation();
    }
}
