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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/users/tecnico', 'UsersController@indexTecnico');
Route::get('/users/tecnico/create', 'UsersController@createTecnico');
Route::get('/users/tecnico/{users}', 'UsersController@showTecnico');
Route::post('/users/tecnico', 'UsersController@storeTecnico');
Route::put('/users/tecnico/{users}', 'UsersController@updateTecnico');
Route::get('/users/tecnico/{users}/edit', 'UsersController@editTecnico');

Route::get('/users/productor', 'UsersController@indexProductor');
Route::get('/users/productor/create', 'UsersController@createProductor');
Route::get('/users/productor/{users}', 'UsersController@showProductor');
Route::post('/users/productor', 'UsersController@storeProductor');
Route::put('/users/productor/{users}', 'UsersController@updateProductor');
Route::get('/users/productor/{users}/edit', 'UsersController@editProductor');

Route::resource('/users', 'UsersController');
Route::resource('/terrenos', 'TerrenosController');

Route::post('/preparacionterrenos/create', 'PreparacionterrenosController@postCreate');
Route::resource('/preparacionterrenos', 'PreparacionterrenosController', ['except' => ['create']]);
Route::get('/preparacionterrenos/{terrenos}/create', 'PreparacionterrenosController@create');

Route::resource('/siembras', 'SiembrasController');
Route::get('/planificacionriegos/siembras', 'PlanificacionriegosController@getSiembras');
Route::post('/planificacionriegos/siembras', 'PlanificacionriegosController@postSiembras');
Route::post('/planificacionriegos/addriego', 'PlanificacionriegosController@addRiego');
Route::resource('/planificacionriegos', 'PlanificacionriegosController');

Route::post('/riegos/create', 'RiegosController@postCreate');
Route::resource('/riegos', 'RiegosController');

Route::get('/planificacionfumigacions/siembras', 'PlanificacionfumigacionsController@getSiembras');
Route::post('/planificacionfumigacions/siembras', 'PlanificacionfumigacionsController@postSiembras');
Route::post('/planificacionfumigacions/addriego', 'PlanificacionfumigacionsController@addRiego');
Route::resource('/planificacionfumigacions', 'PlanificacionfumigacionsController');

Route::post('/fumigacions/create', 'FumigacionsController@postCreate');
Route::resource('/fumigacions', 'FumigacionsController', ['except' => ['create']]);

Route::post('/cosechas/create', 'CosechasController@postCreate');
Route::resource('/cosechas', 'CosechasController', ['except' => ['create']]);

Route::get('/reportes/siembras', 'CosechasController@getreporteSiembra');
Route::post('/reportes/siembras', 'CosechasController@postreporteSiembra');

Route::get('/simuladors', function () {
    return view('simulador.index');
});

Route::get('/simuladors2', 'CosechasController@indexSimulador');
Route::post('/simuladors2', 'CosechasController@postSimulador');