<?php namespace Enfocalia\Http\Controllers;

use Auth;
use Enfocalia\Http\Requests\CrearAlbumRequest;
use Enfocalia\Http\Requests\ActualizarAlbumRequest;
use Enfocalia\Http\Requests\EliminarAlbumRequest;
use Enfocalia\Album;


class AlbumController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getIndex()
	{
		//return "Mostrando álbumes del usuario.";

		// Obtenemos cual es el usuario que está validado en el sistema.
		$usuario =Auth::user();

		// Álbumes de ese usuario.
		$albumes=$usuario->albumes;

		// Devolvemos la vista pasándole todos los álbumes que hemos obtenido.
		return view('albumes.mostrar',['albumes'=>$albumes]);
	}

	public function getCrearAlbum()
	{
		//return "Formulario de creación Albumes.";
		return view('albumes.crear-album');
	}

	public function postCrearAlbum(CrearAlbumRequest $request)
	{
		//return "Almacenando Albumes...";

		// Obtenemos el usuario conectado.
		$usuario = Auth::user();

		// Creamos el álbum.
		Album::create(
			[
			'nombre' => $request->get('nombre'),
			'descripcion' => $request->get('descripcion'),
			'usuario_id' => $usuario->id
			]);

		// Al hacer el redirect pasando variables esas variables se accederá a ellas a partir de 
		// las variables de sesión: @if(Session::has('creado'))  y  {{Session::get('creado')}}
		return redirect('/validado/albumes')->with('creado','El álbum ha sido creado correctamente.');
	}

	public function getActualizarAlbum($id)
	{
		//return "Formulario de actualización de Albumes.";

		$album = Album::find($id);

		// Llamamos a la vista para actualizar el álbum pasándole el álbum a actualizar
		return view('albumes.actualizar-album',['album'=>$album]);
	}

	public function postActualizarAlbum(ActualizarAlbumRequest $request)
	{
		//return "Actualizando Album...";

		$album = Album::find($request->get('id'));
		$album->nombre= $request->get('nombre');
		$album->descripcion=$request->get('descripcion');

		$album->save();

		return redirect('/validado/albumes')->with('actualizado','El álbum se ha actualizado correctamente.');

	}

	public function postEliminarAlbum(EliminarAlbumRequest $request)
	{
		//return "Eliminando album...";

		$album = Album::find($request->get('id'));

		// Obtenemos todas las fotos de ese album.
		$fotos = $album->fotos;

		// Recorremos todas las fotos y las borramos físicamente.
		foreach ($fotos as $foto)
		{
			$ruta=getcwd().$foto->ruta;

			if (file_exists($ruta))
			{
				unlink (realpath($ruta));
			}

			$foto->delete();
		}

		// Borramos el álbum ya que no tiene fotos.
		$album->delete();

		return redirect('/validado/albumes')->with('eliminado','El álbum fue eliminado correctamente.');
	}

	public function missingMethod($parameters = array())
	{
		// Disparamos un error 404.
		abort(404); 
	}

}