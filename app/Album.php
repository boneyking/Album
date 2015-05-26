<?php namespace Enfocalia;

use Illuminate\Database\Eloquent\Model;

class Album extends Model {

	protected $table="albumes";
	protected $fillable=['id','nombre','descripcion','usuario_id'];

	// Definimos las relaciones utilizando funciones.
	// "Un álbum posee muchas fotos"
	public function fotos()
	{
		return $this->hasMany('Enfocalia\Foto');
	}

	// "Un álbum pertenece a un propietario"
	public function propietario()
	{
		return $this->belongsTo('Enfocalia\Usuario');
	}
}