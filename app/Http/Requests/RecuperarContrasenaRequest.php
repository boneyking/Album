<?php namespace Enfocalia\Http\Requests;

use Enfocalia\Http\Requests\Request;

class RecuperarContrasenaRequest extends Request {

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
		'email' => 'required|email|exists:usuarios',
		'password' => 'required|min:6|confirmed', 
		/*
		Confirmed indica que debe existir otro campo que se llame campo_confirmation 
		y que contenga los mismos valores. 
		En este caso se tiene que estar recibiendo también un password_confirmation con el mismo valor que password.
		*/
		'pregunta' => 'required',
		'respuesta' => 'required'
		];
	}

}