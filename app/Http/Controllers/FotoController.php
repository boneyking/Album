<?php namespace Enfocalia\Http\Controllers;

use Enfocalia\Http\Requests\MostrarFotosRequest;
use Enfocalia\Http\Requests\CrearFotoRequest;
use Enfocalia\Http\Requests\ActualizarFotoRequest;
use Enfocalia\Http\Requests\EliminarFotoRequest;

use Enfocalia\Album;
use Enfocalia\Foto;

use Illuminate\Http\Request;

// Utilidad para las fechas.
use Carbon\Carbon;

class FotoController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	public function getIndex(MostrarFotosRequest $request)
	{
		//return "Mostrando las fotos del usuario.";
		$id = $request->get('id');

		// Obtenemos las fotos de ese album con ese id.
		$fotos = Album::find($id)->fotos;

		// Devolvemos una vista con las fotos de ese álbum.
		return view('fotos.mostrar',['fotos'=>$fotos,'id'=>$id]);
	}

	public function getCrearFoto(Request $request)
	{
		// Para este método se supone que a la hora de crear una foto necesitamos saber
		// a qué album va a asociada, con lo que tenemos que recibir un id.
		// En la vista fotos/mostrar.blade.php tenemos que añadir el ID a la URL <a href="/validado/albumes/crear-foto/{{$id}}"
		$id = $request->get('id');

		return view('fotos.crear-foto')->withId($id);
	}

	public function postCrearFoto(CrearFotoRequest $request)
	{
		//return "Almacenando fotos...";

		$id = $request->get('id');

		// Recibimos un archivo y generamos un nombre aleatorio en base a la fecha (Carbon) encriptada + la extensión.
		$imagen = $request->file('imagen');

		// Ruta por defecto en la carpeta public dónde se suben las imágenes.
		$ruta='/img/';

		// Nombre que le asignamos al fichero.
		// Necesario activa extensión en xampp/php/php.ini: extension=php_fileinfo.dll
		$nombre = sha1(Carbon::now()).'.'.$imagen->guessExtension();

		// Movemos la imagen recibida a la ruta correspondiente.
		$imagen->move(getcwd().$ruta,$nombre);

		// Creamos la foto.
		Foto::create(
			[
			'nombre'=>$request->get('nombre'),
			'descripcion'=>$request->get('descripcion'),
			'ruta'=>$ruta.$nombre,
			'album_id'=>$id
			]);

		return redirect("/validado/fotos?id=$id")->with('creada','La foto ha sido subida correctamente.');
	}

	public function getActualizarFoto($id)
	{
		//return "Formulario de actualización de fotos.";
		$foto = Foto::find($id);

		return view('fotos.actualizar-foto')->with('foto',$foto);
	}

	public function postActualizarFoto(ActualizarFotoRequest $request)
	{
		//return "Actualizando foto...";
		// Buscamos la foto por el id.
		$foto = Foto::find($request->get('id'));

		// Actualizamos sus datos.
		$foto->nombre=$request->get('nombre');
		$foto->descripcion=$request->get('descripcion');

		// Comprobamos si recibimos una imagen.
		if ($request->hasFile('imagen'))
		{
			// Recibimos un archivo y generamos un nombre aleatorio en base a la fecha (Carbon) encriptada + la extensión.
			$imagen = $request->file('imagen');
			
			// Creamos el archivo.
			// Ruta por defecto en la carpeta public dónde se suben las imágenes.
			$ruta='/img/';

			// Nombre que le asignamos al fichero.
			// Necesario activa extensión en xampp/php/php.ini: extension=php_fileinfo.dll
			$nombre = sha1(Carbon::now()).'.'.$imagen->guessExtension();

			// Movemos la imagen recibida a la ruta correspondiente.
			$imagen->move(getcwd().$ruta,$nombre);

			// Borramos la imagen antigua.
			$rutaAnterior = getcwd().$foto->ruta;

			if (file_exists($rutaAnterior))
			{
				unlink (realpath($rutaAnterior));
			}

			// Actualizamos la ruta a la nueva ruta de la nueva foto.
			$foto->ruta = $ruta.$nombre;
		}


		// Grabamos el registro.
		$foto->save();

		return redirect("validado/fotos?id=$foto->album_id")->with('editada','La foto fue editada correctamente.');

	}

	public function postEliminarFoto(EliminarFotoRequest $request)
	{
		//return "Eliminando foto...";

		// Obtenemos la foto.

		$foto=Foto::find($request->get('id'));

		$rutaAnterior = getcwd().$foto->ruta;

		if (file_exists($rutaAnterior))
		{
			unlink (realpath($rutaAnterior));
		}

		$foto->delete();

		return redirect("validado/fotos?id=$foto->album_id")->with('eliminada','La foto se ha eliminado correctamente.');
	}

	public function missingMethod($parameters = array())
	{
		// Disparamos un error 404.
		abort(404); 
	}
}