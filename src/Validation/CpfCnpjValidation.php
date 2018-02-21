<?php

namespace EltonInacio\ValidadorCpfCnpj\Validation;

use Illuminate\Validation\Validator as IlluminateValidator;

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
			return $this->validatecpf($attribute, $value, $parameters);
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
		
	   $cpf = $value;
	   
	   $cpf = preg_replace('/[^0-9]/', '', $cpf);
	   $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
	    
	   
	   $sequencia = array('00000000000', '11111111111', '22222222222', '33333333333', '44444444444', '55555555555', '66666666666', '77777777777', '88888888888', '99999999999');

	   if (strlen($cpf) != 11) {
	       return false;
	   } else if (in_array($cpf, $sequencia)) {
	       return false;
	    } else {   
	       for ($t = 9; $t < 11; $t++) {
	           for ($d = 0, $c = 0; $c < $t; $c++) {
	               $d += $cpf{$c} * (($t + 1) - $c);
	           }
	           $d = ((10 * $d) % 11) % 10;
	           if ($cpf{$c} != $d) {
	               return false;
	           }
	       }
	       return true;
	   }

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


        $cnpj = preg_replace('/\D/', '', $value);
        $num = array();
 
        for($i = 0; $i < (strlen($cnpj)); $i++) {
 
            $num[]=$cnpj[$i];
        }
 
        if(count($num) != 14){
           return false;
        }

        if ($num[0]==0 && $num[1]==0 && $num[2]==0
           && $num[3]==0 && $num[4]==0 && $num[5]==0
           && $num[6]==0 && $num[7]==0 && $num[8]==0
           && $num[9]==0 && $num[10]==0 && $num[11]==0)
        {
            return false;
        }
        else
        {
            $j = 5;
            for($i = 0; $i < 4; $i++){
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $j = 9;
            for($i = 4; $i < 12; $i++){
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);
            $resto = $soma % 11;
            if($resto < 2 ){
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            if($dg != $num[12]) {
                return false;
            }
        }

        $j = 6;
        for($i = 0; $i < 5 ; $i++){
            $multiplica[$i] = $num[$i] * $j;
            $j--;
        }
        $soma = array_sum($multiplica);
        $j = 9;
        for($i = 5; $i < 13; $i++){
            $multiplica[$i] = $num[$i] * $j;
            $j--;
        }
        $soma = array_sum($multiplica);
        $resto = $soma % 11;
        if($resto < 2){
            $dg = 0;
        } else {
            $dg = 11 - $resto;
        }
        if($dg != $num[13]){
            return false;
        } else {
            return true;
        }
    }
}
