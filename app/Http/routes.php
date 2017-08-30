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
Route::get('/users/tecnico', 'UsersController@createTecnico');
Route::post('/users/tecnico', 'UsersController@storeTecnico');
Route::get('/users/productor', 'UsersController@createProductor');
Route::post('/users/productor', 'UsersController@storeProductor');
Route::resource('/users', 'UsersController');
Route::resource('/terrenos', 'TerrenosController');
Route::resource('/preparacionterrenos', 'PreparacionterrenosController');
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
Route::resource('/fumigacions', 'FumigacionsController');

Route::post('/cosechas/create', 'CosechasController@postCreate');
Route::resource('/cosechas', 'CosechasController');

Route::get('/reportes/siembras', 'CosechasController@getreporteSiembra');
Route::post('/reportes/siembras', 'CosechasController@postreporteSiembra');

