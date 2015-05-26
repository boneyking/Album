<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

// Hacemos uso de los modelos de nuestra aplicación
use Enfocalia\Foto;
use Enfocalia\Album;
use Enfocalia\Usuario;

class UsuariosSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		for ($i=0;$i<50;$i++)
		{
			Usuario::create(
				[
				'nombre'=> "usuario$i",
				'email' => "email$i@test.com",
				'password' => bcrypt("pass$i"), // bcrypt es una function helper de Hash::make
				//'password' => Hash::make("pass$i")
				'pregunta' => "preg$i",
				"respuesta" => "resp$i"
				]);
		}
	}
}