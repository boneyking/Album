<?php namespace Enfocalia\Http\Requests;

use Enfocalia\Http\Requests\Request;

class IniciarSesionRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		// Devuelve verdadero o falso.
		// Si devuelve falso es que el usuario no tiene permiso para realizar este tipo de operación.
		// Pero en este caso para hacer el inicio de sesión todos podrán intentar dicho inicio.
		// Si devolviéramos false al intentar ejecutar esta validación devuelve un error con código "403" con la respuesta "Forbidden"
		// Devolvemos true en este caso.
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
		'email' => 'required|email',
		'password' => 'required'
		];
	}
}