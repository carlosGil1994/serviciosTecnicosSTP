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
    Route::get('index','ServiciosController@index')->name('Servicios_index');
    Route::get('show/{id}','ServiciosController@show')->name('show_servicio');
    Route::post('add_new','ServiciosController@store')->name('add_servicio');
    Route::put('edit/{id}','ServiciosController@update')->name('edit_servicio');
    Route::delete('delete/{id}','ServiciosController@destroy')->name('delete_servicio');
});

Route::group(['prefix' => 'Equipos'], function () {
    Route::get('busqueda/{busqueda}','EquiposController@busqueda')->name('Equipos_busqueda');
    Route::get('index','EquiposController@index')->name('Equipos_index');
    Route::get('show/{id}','EquiposController@show')->name('show_Equipo');
    Route::post('add_new','EquiposController@store')->name('add_Equipo');
    Route::put('edit/{id}','EquiposController@update')->name('update_Equipo');
    Route::delete('delete/{id}','EquiposController@destroy')->name('delete_Equipo');
});

Route::group(['prefix' => 'Fallas'], function () {
    Route::get('index','FallasController@index')->name('Fallas_index');
    Route::get('show/{id}','FallasController@show')->name('show_Falla');
    Route::post('add_new','FallasController@store')->name('add_Falla');
    Route::put('edit/{id}','FallasController@update')->name('update_Falla');
    Route::delete('delete/{id}','FallasController@destroy')->name('delete_Falla');
});
Route::group(['prefix' => 'Materiales'], function () {
    Route::get('busqueda/{busqueda}','MaterialesController@busqueda')->name('Materiales_busqueda');
    Route::get('index','MaterialesController@index')->name('Materiales_index');
    Route::get('show/{id}','MaterialesController@show')->name('show_Material');
    Route::post('add_new','MaterialesController@store')->name('add_Material');
    Route::put('edit/{id}','MaterialesController@update')->name('update_Material');
    Route::delete('delete/{id}','MaterialesController@destroy')->name('delete_Material');
});
Route::group(['prefix' => 'Usuarios'], function () {
    Route::get('index','UsuariosController@index')->name('Usuarios.index');
    Route::get('usertable','UsuariosController@usertable')->name('Usuarios.usertable');
    Route::get('show/{id}','UsuariosController@show')->name('show_Usuario');
    Route::post('add_new','UsuariosController@store')->name('add_Usuario');
    Route::put('edit/{id}','UsuariosController@update')->name('update_Usuario');
    Route::delete('delete/{id}','UsuariosController@destroy')->name('delete_Usuario');
});
Route::group(['prefix' => 'Propiedades'], function () {
    Route::get('index','PropiedadesController@index')->name('Propiedades_index');
    Route::get('show/{id}','PropiedadesController@show')->name('show_Propiedad');
    Route::post('add_new','PropiedadesController@store')->name('add_Propiedad');
    Route::put('edit/{id}','PropiedadesController@update')->name('update_Propiedad');
    Route::delete('delete/{id}','PropiedadesController@destroy')->name('delete_Propiedad');
});
Route::group(['prefix' => 'Ordenes'], function () {
    Route::get('index','OrdenesController@index')->name('Ordenes_index');
    Route::get('show/{id}','OrdenesController@show')->name('show_Orden');
    Route::post('add_new','OrdenesController@store')->name('add_Orden');
    Route::put('edit/{id}','OrdenesController@update')->name('update_Orden');
    Route::delete('delete/{id}','OrdenesController@destroy')->name('delete_Orden');
    Route::put('cerrarOrden/{id}','OrdenesController@cerrarOrden')->name('cerrar_Orden');
    Route::put('cancelarOrden/{id}','OrdenesController@cancelar')->name('cancelar_orden');
    Route::get('calcular/{id}','OrdenesController@calculoMonto')->name('calcularMonto_Orden');
});
Route::group(['prefix' => 'Actividades'], function () {
    Route::get('Ordenestable','ActividadesController@Ordenestable')->name('Actividades.Ordenestable');
    Route::get('index','ActividadesController@index')->name('Actividades.index');
    Route::get('show/{id}','ActividadesController@show')->name('show_Actividad');
    Route::get('showActividades/{id}','ActividadesController@showActividades')->name('show_Actividades');
    Route::get('ActividadesTable/{id}','ActividadesController@ActividadesTable')->name('ActividadesTable');
    Route::post('add_new','ActividadesController@store')->name('add_Actividad');
    Route::put('edit/{id}','ActividadesController@update')->name('update_Actividad');
    Route::delete('delete/{id}','ActividadesController@destroy')->name('delete_Actividad');
});
Route::group(['prefix' => 'Especialidades'], function () {
    Route::get('index','EspecialidadesController@index')->name('Especialidades_index');
    Route::get('show/{id}','EspecialidadesController@show')->name('show_Especialidad');
    Route::post('add_new','EspecialidadesController@store')->name('add_Especialidad');
    Route::put('edit/{id}','EspecialidadesController@update')->name('update_Especialidad');
    Route::delete('delete/{id}','EspecialidadesController@destroy')->name('delete_Especialidad');
    Route::put('quitarEspecialidad/{id}','EspecialidadesController@quitarEspecialidad')->name('quitar_Especialidad');
    
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
