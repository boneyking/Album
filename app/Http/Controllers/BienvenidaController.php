<?php namespace Enfocalia\Http\Controllers;

class BienvenidaController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		//return "Página de bienvenida a la aplicación.";
		return view('bienvenida');
	}

	public function missingMethod($parameters = array())
	{
		// Disparamos un error 404.
		abort(404); 
	}
}