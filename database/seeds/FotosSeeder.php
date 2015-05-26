<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

// Hacemos uso de los modelos de nuestra aplicación
use Enfocalia\Foto;
use Enfocalia\Album;
use Enfocalia\Usuario;

class FotosSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$albumes = Album::all();
		$contador=0;

		foreach ($albumes as $album)
		{
			$cantidad = mt_rand(0,5);
			for ($i=0;$i< $cantidad;$i++)	
			{
				$contador++;
				Foto::create(
					[
					'nombre' => "Nombre Foto_$contador",
					'descripcion' => "Descripcion Foto_$contador",
					'ruta' => '/img/test.png',
					'album_id' => $album->id
					]);
			}
		}
	}
}