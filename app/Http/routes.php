<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Definimos las llamadas a todos los controladores que hemos creado anteriormente.
// Es importante el orden de más restrictivo a más genérico.

Route::get('validacion', 'Validacion\ValidacionController@getInicio');
Route::get('validacion/fotos/{id}', function(FotoController\getIndex $id){

});
Route::get('/', 'BienvenidaController@getIndex');

/*
Route::controllers([
	'validacion' => 'Validacion\ValidacionController',
	'validado/fotos' => 'FotoController',
	'validado/albumes' => 'AlbumController',
	'validado/usuario' => 'UsuarioController',
	'validado' => 'InicioController',
	'/'=> 'BienvenidaController'
]);
*/