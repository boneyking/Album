<?php namespace Enfocalia;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model {

	protected $table="fotos";
	protected $fillable=['id','nombre','descripcion','ruta','album_id'];

	// Definimos las relaciones utilizando funciones.
	// "Una foto pertenece a un album"
	public function album()
	{
		return $this->belongsTo('Enfocalia\Album');
	}
}