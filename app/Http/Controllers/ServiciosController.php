<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicios;
use App\User;
use DataTables;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Servicios')->with(array(
            'mod' => 'Servicios',
            'cantidad' => 0,
            'header' => 'Servicios',
            'mostrarBoton'=>true
        ));
    }
    public function ServiciosTable(){
        $Servicios=Servicios::all();
        return DataTables::of($Servicios)
        ->addColumn('action', function ($Servicio) {
            $output = <<<EOT
            <a href="#" data="$Servicio->id" title="Editar" class="btn btn-xs btn-primary btn-table editar"><i class="fas fa-edit"></i></a>
EOT;
       // $output .=' <a data="'.$ordenes->id.'"class="btn btn-xs btn-primary btn-table completar"><i class="glyphicon glyphicon-edit"></i>completar</a>';
        //$output .=' <a href='."'".url("Equipos/fallas")."/".$Equipo->id."'".'"data="'.$Equipo->id.'"class="btn btn-xs btn-primary "><i class="glyphicon glyphicon-edit"></i>Fallas</a>';
       // $output .=' <a href='."'".url("Actividades/completar")."/".$actividad->id."'".'"data="'.$actividad->id.'"class="btn btn-xs btn-primary btn-table crear"><i class="glyphicon glyphicon-edit"></i>completar</a>';
            return $output;
        })->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'descripcion'      => 'required|unique:servicios',
            ];
 
        try {
            // Ejecutamos el validador y en caso de que falle devolvemos la respuesta
            // con los errores
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ]);
            }
            // Si el validador pasa, almacenamos
            Servicios::create(['descripcion'=>$request->descripcion]);
            return response()->json(['created' => true]);
        } catch (Exception $e) {
            // Si algo sale mal devolvemos un error.
            //\Log::info('Error creating user: '.$e);//esto es para hacer un log
            return response()->json(['created' => false], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $servicio=Servicios::findOrFail($id);
        }
        catch(ModelNotFoundException $e){
            return response()->json(['found' => false], 404);
        } 
        return response()->json([
            'servicio' => $servicio
        ],200);
       

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $servicio=Servicios::findOrFail($id);
            $servicio->update($request->all());
            return response()->json(['update' => true]);
        } 
        catch(ModelNotFoundException $e){
            return response()->json(['update' => false], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $servicio=Servicios::findOrFail($id);
            $servicio->delete();
            return response()->json(['delete' => true]);
        } 
        catch(ModelNotFoundException $e){
            return response()->json(['delete' => false], 500);
        }
    }
}
