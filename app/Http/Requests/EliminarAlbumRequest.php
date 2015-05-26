<?php namespace Enfocalia\Http\Requests;

use Enfocalia\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class EliminarAlbumRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		// Copiado de ActualizarAlbumRequest.
		$user = Auth::user();

		// Id del album recibido
		$id = $this->get('id');

		// Buscamos si ese usuario tiene un album con ese $id.
		$album = $user->albumes()->find($id);

		// Si ese album existe devolvemos true, en otro caso false (forbidden).
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
			'id'=>'required|exists:albumes,id'
		];
	}

}
