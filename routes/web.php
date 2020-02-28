<?php

/*Route::get('/', function () {
    return view('welcome');
});*/

// prospectos
Route::get('/', 'HomeController@index')
    ->name('home');
Route::post('home/create','HomeController@store');
Route::get('home/show','HomeController@show');
Route::get('/prospectos/{prospecto}',[
	'uses' => 'HomeController@ver',
	'as' => 'prospectos.ver'
]);
Route::put('/prospectos/{prospecto}',[
	'uses' => 'HomeController@update',
	'as' => 'prospectos.update'
]);
Route::delete('/prospectos/{prospecto}', [
	'uses' => 'HomeController@destroy',
	'as' => 'prospectos.destroy'
]);

// llamadas
Route::post('llamadas/create','llamadasController@store');
Route::get('llamadas/show/{prospecto}','llamadasController@show');
Route::put('/llamadas/{llamada}',[
	'uses' => 'llamadasController@update',
	'as' => 'llamadas.update'
]);
Route::delete('/llamadas/{llamada}', [
	'uses' => 'llamadasController@destroy',
	'as' => 'llamadas.destroy'
]);