<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

// Hacemos uso de los modelos de nuestra aplicación
use Enfocalia\Foto;
use Enfocalia\Album;
use Enfocalia\Usuario;



class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Para que no verifique el control de claves foráneas al hacer el truncate haremos:
		DB::statement('SET FOREIGN_KEY_CHECKS=0');

		// Primero hacemos un truncate de las tablas para que no se estén agregando datos
		// cada vez que ejecutamos el seeder.
		Foto::truncate();
		Album::truncate();
		Usuario::truncate();

		// Es importante el orden de llamada.
		$this->call('UsuariosSeeder');
		$this->call('AlbumesSeeder');
		$this->call('FotosSeeder');
	}

}