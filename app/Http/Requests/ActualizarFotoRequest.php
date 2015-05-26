<?php namespace Enfocalia\Http\Requests;

use Enfocalia\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

use Enfocalia\Album;
use Enfocalia\Foto;

class ActualizarFotoRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		// Copiado de CrearFotoRequest.
		$user = Auth::user();

		// Id de la foto
		$id = $this->get('id');

		// Buscamos si ese usuario tiene una foto con ese id.
		$foto = Foto::find($id);

		// Verificamos si existe un album del usuario que coincida con el album_id de la foto.
		$album = $user->albumes()->find($foto->album_id);

		// Si esa foto existe devolvemos true, en otro caso false (forbidden).
		if ($album)
			return true;
		else
			return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'id'=>'required|exists:fotos,id',
			'nombre'=>'required',
			'descripcion'=>'required',
			'imagen'=> 'image|max:20000'  // No es requerido pero si lo recibimos tendrá q cumplir esas condiciones.
		];
	}

}
