<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

// Hacemos uso de los modelos de nuestra aplicación
use Enfocalia\Foto;
use Enfocalia\Album;
use Enfocalia\Usuario;

class AlbumesSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$usuarios = Usuario::all();
		$contador=0;

		foreach ($usuarios as $usuario)
		{
			$cantidad = mt_rand(0,15);
			for ($i=0;$i< $cantidad;$i++)	
			{
				$contador++;
				Album::create(
					[
					'nombre' => "Nombre Album_$contador",
					'descripcion' => "Descripcion Album_$contador",
					'usuario_id' => $usuario->id
					]);
			}
		}
	}
}