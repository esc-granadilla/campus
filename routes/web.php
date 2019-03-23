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

Route::get('/admin', 'AdministracionController@index')->name('admin');

Route::post('/credencial', 'AdministracionController@credencial')->name('credencial');

Route::get('/roles', 'AdministracionController@roles')->name('roles');

Route::get('/roltouser', 'AdministracionController@roltouser')->name('roltouser');

Route::get('/credencial', 'AdministracionController@credencial')->name('credencial');
