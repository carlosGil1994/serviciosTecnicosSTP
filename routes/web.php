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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home')->middleware('auth');

Route::group(['prefix' => 'Bancos'], function () {
    Route::post('add_new','BancoController@create')->name('add_banco');
});

<<<<<<< HEAD
Route::group(['prefix' => 'Servicios'], function () {
    Route::get('show/{id}','ServiciosController@show')->name('show_servicio');
    Route::post('add_new','ServiciosController@store')->name('add_servicio');
    Route::put('edit/{id}','ServiciosController@update')->name('edit_servicio');
    Route::delete('delete','ServiciosController@delete')->name('delete_servicio');
});
=======

// Rutas de test
// Route::group(['prefix' => 'cargos'], function(){
//     Route::get('/', 'CargoController@index')->name('cargos.index');
//     Route::post('/buscar','CargoController@store');
//     Route::post('/add_new', 'CargoController@create');
//     Route::get('/get_item', 'CargoController@show');
//     Route::get('/delete_item', 'CargoController@destroy');
//     Route::post('/edit', 'CargoController@update');
// });
>>>>>>> 432bb0be65e62c56578ef46398431e34a391f53c
