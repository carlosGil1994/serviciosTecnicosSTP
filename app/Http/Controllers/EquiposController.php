<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Equipos;
use Exception;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mostrarBoton=true;
        if(Auth::user()->tipo==2){
            $mostrarBoton=false;
        }
        return view('equipos')->with(array(
            'mod' => 'Equipos',
            'cantidad' => 0,
            'header' => 'Equipos',
            'mostrarBoton'=>$mostrarBoton
        ));
        /*try{
            $Equipos=Equipos::all();
            return response()->json([
                'Equipos' => $Equipos
            ],200);
        }
        catch(Exception $e){
            return response()->json(['found' => false], 404);
        } */
    }
    public function fallas($id){

        return view('equiposFallas')->with(array(
            'mod' => 'Equipos',
            'cantidad' => 0,
            'header' => 'Fallas en Equipos',
            'id'=> $id,
            'mostrarBoton'=>false
        ));
    }

    public function fallasTable($id){
        $equipo=Equipos::find($id);
        $fallas=$equipo->fallas;
        foreach ($fallas as $falla) {
            $falla['cliente']=$falla->actividad->ordenservicio->clientes->nombre;
            $falla['equipo']=$equipo->descripcion.' '.$equipo->modelo;
        }
       
        return DataTables::of($fallas)
       /* ->addColumn('action', function ($falla) {
            $output = <<<EOT
            <a data="$Equipo->id"class="btn btn-xs btn-primary btn-table editar"><i class="glyphicon glyphicon-edit"></i>Panel</a>
EOT;
       // $output .=' <a data="'.$ordenes->id.'"class="btn btn-xs btn-primary btn-table completar"><i class="glyphicon glyphicon-edit"></i>completar</a>';
        $output .=' <a href='."'".url("Equipos/fallas")."/".$Equipo->id."'".'"data="'.$Equipo->id.'"class="btn btn-xs btn-primary "><i class="glyphicon glyphicon-edit"></i>Fallas</a>';
       // $output .=' <a href='."'".url("Actividades/completar")."/".$actividad->id."'".'"data="'.$actividad->id.'"class="btn btn-xs btn-primary btn-table crear"><i class="glyphicon glyphicon-edit"></i>completar</a>';
            return $output;
        })*/
        ->make();
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
    public function equiposTable(){
        if(Auth::user()->tipo==2){
            $Equipos=Equipos::all();
            foreach ($Equipos as $equipo) {
                $equipo['precio']='';
            }
        }
        else{
            $Equipos=Equipos::all();
        }
        return DataTables::of($Equipos)
        ->addColumn('action', function ($Equipo) {
            $output='';
            if(Auth::user()->tipo!=2 && Auth::user()->tipo!=3 ){
            $output = <<<EOT
            <a href="#" data="$Equipo->id" title="Editar" class="btn btn-xs btn-primary btn-table editar"><i class="fas fa-edit"></i></a>
EOT;
            }
       // $output .=' <a data="'.$ordenes->id.'"class="btn btn-xs btn-primary btn-table completar"><i class="glyphicon glyphicon-edit"></i>completar</a>';
        $output .=' <a href='."'".url("Equipos/fallas")."/".$Equipo->id."'".'"data="'.$Equipo->id.'" title="Fallas" class="btn btn-xs btn-primary "><i class="fas fa-exclamation-triangle"></i></a>';
        if(Auth::user()->tipo==1){
            $output.= ' <a href="#edit-'.$Equipo->id.'" data="'.$Equipo->id.'"title="borrar" class="btn btn-xs btn-primary btn-table borrar"><i class="fas fa-trash-alt"></i></a>';
        }
        // $output .=' <a href='."'".url("Actividades/completar")."/".$actividad->id."'".'"data="'.$actividad->id.'"class="btn btn-xs btn-primary btn-table crear"><i class="glyphicon glyphicon-edit"></i>completar</a>';
            return $output;
        })->make();
    }
    public function busqueda($busqueda)
    {
        $Equipos= Equipos::where('descripcion','LIKE','%'.$busqueda.'%')
        ->orWhere('modelo','LIKE','%'.$busqueda.'%')->get();
        return response()->json([
            'Equipos' => $Equipos
        ],200);
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
            'descripcion'=> 'required',
            'modelo'=> 'required|unique:equipos',
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
            Equipos::create($request->all());
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
            $Equipo=Equipos::findOrFail($id);
            return response()->json([
                'equipo' => $Equipo
            ],200);
        }
        catch(ModelNotFoundException $e){
            return response()->json(['found' => false], 404);
        } 
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
            $Equipo=Equipos::findOrFail($id);
            $Equipo->update($request->all());
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
            $Equipo=Equipos::findOrFail($id);
            $actividades= $Equipo->actividades;
            if($actividades){
                foreach ($actividades as $actividad) {
                    foreach ($actividad->fallas as $falla) {
                        $falla->delete();
                    }
                    $actividad->delete();
                }
            }
            $Equipo->delete();
            return response()->json(['delete' => true]);
        } 
        catch(ModelNotFoundException $e){
            return response()->json(['delete' => false], 500);
        }
    }
}
