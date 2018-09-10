<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fallas;
use App\Equipos;
use App\Actividades;
use DataTables;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FallasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    const MODEL = 'Fallas';
    public function index()
    {
        try{
            $Fallas=Fallas::with('equipos')->get(); //trae toda la info de las fallas join los equipos asociados a esas fallas
            return response()->json([
                'Fallas' => $Fallas
            ],200);
        }
        catch(Exception $e){
            return response()->json(['found' => false,"mensaje"=>$e->getMessage()], 404);
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    public function equiposFallas($id){
        Actividades::find($id)->equipos;
        return response()->json([
            'Equipos' => $equipos
        ],200);
    }

    public function fallaTable($id){
        $Fallas=Actividades::find($id)->fallas;
      //  dd($mostrar['relations']['fallas']);
        //$fallas=$mostrar->fallas;
        //dd($mostrar);
        return DataTables::of($Fallas)
        ->addColumn('action', function ($Falla) {
            return '<a href="#edit-'.$Falla->id.'" data="'.$Falla->id.'"class="btn btn-xs btn-primary btn-table editar"><i class="glyphicon glyphicon-edit"></i> Editar</a>';
        })->make();
    }

    public function showFallas($id){
        $equipos=Actividades::find($id)->equipos;
        //dd($equipos);
        return view('actividadesFallas')->with(array(
            'mod' => self::MODEL,
            'cantidad' => 0,
            'id'=>$id,
            'header' => 'Fallas',
            'equipos'=>$equipos
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        //falta terminar
        $rules = [
            'descripcion'=> 'required'
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
           /* $datos=[];
            $datos['descripcion']=$request->descrpcion;
            $datos['causa']=$request->causa;
            $datos['solucion']=$request->solucion;
            $datos['equipo']=$request->equipos;*/
            // Si el validador pasa, almacenamos
            //Fallas::create($request->all());
            //$falla = new Fallas([$request->descripcion,$request->causa,$request->solucion]);
           $Equipo=Equipos::findOrFail($request->equipo);
           /*$falla=$Equipo->fallas()->create([
                'descripcion' =>$request->descripcion,
                'causa' =>$request->causa,
                'solucion' =>$request->solucion,
           ]);*/
           $fallas = new Fallas;
           ////// forma de guradar anidadamente cunado es many to many teniendo columnas adicionales en la tablla de union////////
           $fallas->create(["descripcion"=>$request->descripcion,"causa"=>$request->causa,"solucion"=>$request->solucion])
           ->equipos()->where("falla_id",$fallas->id)
           ->save($Equipo,["actividad_id"=>$request->actividad]);
           ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
          // dd( $Equipo);
           //dd( $falla=Fallas::findOrFail(5)->pivot->actividad_id);
           // $Equipo->fallas()->attach($request->actividad);
            /*if($request->has('actividad')){
                $actividad=Actividades::findOrFail($request->actividad);
                $actividad->fallas()->attach($falla->id);
            };*/
            return response()->json(['created' => true]);
        } catch (Exception $e) {
            // Si algo sale mal devolvemos un error.
            //\Log::info('Error creating user: '.$e);//esto es para hacer un log
            return response()->json(['created' => false,'mensaje'=>$e->getMessage()], 500);
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
            $Falla=Fallas::findOrFail($id);
            return response()->json([
                'Falla' => $Falla
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
        $rules = [
            'descripcion'=> 'required'
        ];
        
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'created' => false,
                'errors'  => $validator->errors()->all()
            ]);
        }

        try{
            $Falla=Fallas::findOrFail($id);
            $Falla->update($request->all());
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
            $Falla=Fallas::findOrFail($id);
            $Falla->delete();
            return response()->json(['delete' => true]);
        } 
        catch(ModelNotFoundException $e){
            return response()->json(['delete' => false], 500);
        }
    }

}
