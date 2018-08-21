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
    Route::get('/', 'BancoController@index')->name('bancos.index');
    Route::get('/buscar','BancoController@store');
    Route::post('/add_new', 'BancoController@create');
    Route::get('/get', 'BancoController@show')->name('bancos.show');
    Route::get('/delete_item', 'BancoController@destroy')->name('bancos.delete');
    Route::post('/edit', 'BancoController@update');
});

Route::group(['prefix' => 'Servicios'], function () {
    Route::get('index','ServiciosController@index')->name('Servicios.index');
    Route::get('show/{id}','ServiciosController@show')->name('show_servicio');
    Route::post('add_new','ServiciosController@store')->name('add_servicio');
    Route::put('edit/{id}','ServiciosController@update')->name('edit_servicio');
    Route::delete('delete/{id}','ServiciosController@destroy')->name('delete_servicio');
});

// Rutas de test
// Route::group(['prefix' => 'cargos'], function(){
//     Route::get('/', 'CargoController@index')->name('cargos.index');
//     Route::post('/buscar','CargoController@store');
//     Route::post('/add_new', 'CargoController@create');
//     Route::get('/get_item', 'CargoController@show');
//     Route::get('/delete_item', 'CargoController@destroy');
//     Route::post('/edit', 'CargoController@update');
// });
