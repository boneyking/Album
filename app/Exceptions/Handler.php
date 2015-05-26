<?php namespace Enfocalia\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

// Añadimos esta clase:
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
	'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		// Si la excepción es una instancia de TokenMismatchException
		if ($e instanceof TokenMismatchException)
		{
			// Redireccionamos a la URL de dónde proviene la petición, mandando un mensaje en una variable de sesión "csrf".
			// La URL de dónde proviene la petición suelen ser los formularios.
			// Tendremos que modificar las vistas correspondientes: validacion/inicio.blade.php, bienvenida.blade.php e inicio.blade.php
			return redirect($request->url())->with('csrf','Pasó mucho tiempo, inténtalo de nuevo.');
		}

		// Renderizará el error cuando estemos en entorno local (APP_DEBUG=true)
		if (config('app.debug'))
		{
			return parent::render($request,$e);
		}

		// En otro caso lo mandamos a la dirección de inicio.
		return redirect('/')->with('error','Algo salió mal.');
	}

}