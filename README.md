# cpfcnpj-laravel

Validação de cpf, cnpj, cpfcnpj para laravel 5.*

#### Instalação Composer
```
$ composer require eltoninacio/cpfcnpj-laravel
```
ou
```
"require": {
    "eltoninacio/cpfcnpj-laravel": "2.0.*"
}
```
```
$ composer update
```

#### Configuração Laravel
Registre o ServiceProvider no array ```providers``` dentro do arquivo ```config/app.php```:
```php
'providers' => [
	// ...
    EltonInacio\ValidadorCpfCnpj\CpfCnpjServiceProvider::class
]
```
#### Exemplo de uso
```php
$this->validade($request, [
    'cpf'       => 'cpf',
    'cnpj'      => 'cnpj',
    'cpfcnpj'   => 'cpfcnpj'
])
```
ou
```php
namespace App\Http\Requests;

use App\Http\Requests\Request;

class CpfCnpjRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'cpf' 		=> 'cpf',
			'cnpj'		=> 'cnpj',
			'cpfcnpj'	=> 'cpfcnpj'
		];
	}

}
```
