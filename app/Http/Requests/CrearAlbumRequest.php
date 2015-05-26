<?php namespace Enfocalia\Http\Requests;

use Enfocalia\Http\Requests\Request;

class CrearAlbumRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		// La autorización siempre será true por que cualquier usuario podrá
		// crear álbumes y nosotros se los asociaremos al usuario
		// que tiene la sesión creada.
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
			'nombre' => 'required',
			'descripcion' => 'required'
		];
	}

}
