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

Route::group(['prefix' => 'Servicios'], function () {
    Route::get('show/{id}','ServiciosController@show')->name('show_servicio');
    Route::post('add_new','ServiciosController@store')->name('add_servicio');
    Route::put('edit/{id}','ServiciosController@update')->name('edit_servicio');
    Route::delete('delete','ServiciosController@delete')->name('delete_servicio');
});
