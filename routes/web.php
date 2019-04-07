<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('profesors', 'ProfesorController');

Route::resource('estudiantes', 'EstudianteController');

Route::resource('horarios', 'HorarioController');

Route::resource('cursos', 'CursoController');

Route::resource('noticias','NoticiasController');

Route::get('/admin', 'AdministracionController@index')->name('admin');

Route::post('/credencial/{user}', 'AdministracionController@credencial')->name('credencial');

Route::post('/asigcursohorario/{curso}', 'AdministracionController@asigcursohorario')->name('asigcursohorario');

Route::get('/cursohorario/{curso}', 'AdministracionController@cursohorario')->name('cursohorario');

Route::get('/roles', 'AdministracionController@roles')->name('roles');

Route::get('/roltouser', 'AdministracionController@roltouser')->name('roltouser');

Route::get('/credencial', 'AdministracionController@credencial')->name('credencial');

Route::get(
   '/showcursohorarioprofesor/{profesor}/{curso}/{grado}/{dia}',
   'AdministracionController@showcursohorarioprofesor'
)->name('showcursohorarioprofesor');

Route::post(
   '/asigcursohorarioprofesor/{profesor}/{curso}/{grado}/{dia}',
   'AdministracionController@asigcursohorarioprofesor'
)->name('asigcursohorarioprofesor');

Route::get(
   '/showcursosprofesors/{grado}',
   'AdministracionController@showcursosprofesors'
)->name('showcursosprofesors');

Route::get(
   '/showprofesorscurso/{estudiante}/{curso}/{grado}',
   'AdministracionController@showprofesorscurso'
)->name('showprofesorscurso');

Route::get(
   '/showhorarioscurso/{estudiante}/{profesor}/{curso}/{grado}',
   'AdministracionController@showhorarioscurso'
)->name('showhorarioscurso');

Route::post(
   '/asigcursohorarioestudiante/{estudiante}/{profesor}/{curso}/{grado}/{dia}',
   'AdministracionController@asigcursohorarioestudiante'
)->name('asigcursohorarioestudiante');
