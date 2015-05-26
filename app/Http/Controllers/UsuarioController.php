<?php namespace Enfocalia\Http\Controllers;

use Enfocalia\Http\Requests\EditarPerfilRequest;
use Auth;

class UsuarioController extends Controller {

	// Para el tema de contraseñas se encargará el controlador de Validación

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getEditarPerfil()
	{
		//return "Mostrando formulario de perfil.";
		return view('usuario.actualizar');
	}

	public function postEditarPerfil(EditarPerfilRequest $request)
	{
		//return "Generando actualización de perfil...";
		// Modificamos los datos del usuario autenticado.
		$usuario = Auth::user();

		$usuario->nombre=$request->get('nombre');

		if($request->has('password'))
		{
			$usuario->password=bcrypt($request->get('password'));
		}

		if($request->has('pregunta'))
		{
			$usuario->pregunta=$request->get('pregunta');
			$usuario->respuesta=$request->get('respuesta');
		}

		$usuario->save();

		// Tendremos que modificar la vista de inicio.blade.php para incluir este mensaje.
		return redirect('/validado')->with('actualizado','Su perfil ha sido actualizado correctamente.');
	}

	public function missingMethod($parameters = array())
	{
		// Disparamos un error 404.
		abort(404); 
	}
}