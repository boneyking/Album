<?php namespace Enfocalia\Http\Controllers\Validacion;

use Enfocalia\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

// Añadimos la clase Request;
use Illuminate\Http\Request;

// Añadimos el Request que hicimos para postInicio:
use Enfocalia\Http\Requests\IniciarSesionRequest;

// Añadimos el Request que hicimos para postRecuperar:
use Enfocalia\Http\Requests\RecuperarContrasenaRequest;

// Necesitamos el modelo Usuario.
use Enfocalia\Usuario;


class ValidacionController extends Controller {
	protected $auth;
	protected $registrar;

	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		// Sustituir getLogout por getSalida
		$this->middleware('guest', ['except' => 'getSalida']);
	}

	public function getRegistro()
	{
		//return "formulario de creación de cuentas.";
		return view('validacion.registro');
	}

	public function postRegistro(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
				);
		}

		$this->auth->login($this->registrar->create($request->all()));

		return redirect($this->redirectPath());
	}

	public function getInicio()
	{
		//return 'Mostrando formulario Inicio Sesión';
		return view('validacion.inicio');
	}


	public function postInicio(IniciarSesionRequest $request)
	{
		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
		->withInput($request->only('email', 'remember'))
		->withErrors([
			'email' => $this->getFailedLoginMessage(),
			]);
	}

	protected function getFailedLoginMessage()
	{
		return 'E-mail o contraseña incorrectos.';
	}

	public function getSalida()
	{
		$this->auth->logout();

		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
	}

	/**
	 * Get the post register / login redirect path.
	 *
	 * @return string
	 */
	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/inicio';
	}

	public function loginPath()
	{
		return property_exists($this, 'loginPath') ? $this->loginPath : '/validacion/inicio';
	}

	public function getRecuperar()
	{
		//return "recuperar contraseña";
		return view('validacion.recuperar');
	}

	public function postRecuperar(RecuperarContrasenaRequest $request)
	{
		//return "recuperando contraseña";
		$pregunta=$request->get('pregunta');
		$respuesta=$request->get('respuesta');

		$email=$request->get('email');
		$usuario=Usuario::where('email','=',$email)->first();

		if($pregunta=== $usuario->pregunta && $respuesta===$usuario->respuesta)
		{
			// Modificamos por lo tanto su contraseña con la nueva recibida.
			$usuario->password=bcrypt($request->get('password'));

			// Grabamos los cambios.
			$usuario->save();

			// Redireccionamos a Validacion/inicio pero sin valores y con un mensaje de actualizado.
			return redirect('/validacion/inicio')
			->with(['recuperada'=>'La contraseña se modificó correctamente. Inicie Sesión.']);
		}

		// En el caso de que no coincidan las preguntas y respuestas lo mandamos de nuevo a /validacion/recuperar.
		return redirect('/validacion/recuperar')
			->withInput($request->only('email','pregunta'))
			->withErrors(['pregunta'=>'La pregunta y/o respuesta facilitadas no coinciden.']);
	}

	public function missingMethod($parameters = array())
	{
		// Disparamos un error 404.
		abort(404); 
	}
}