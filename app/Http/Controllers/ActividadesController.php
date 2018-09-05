<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividades;
use App\Acciones;
use App\Equipos;
use App\Orden_servicios;
use App\Materiales;
use App\PagoServicios;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Monolog\Handler\NullHandler;

class ActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
      //prueba sin postman porque es un rollo pasar arreglos por ahi
       /* $request->equipo_id=[
            [
                'equipo' => 1 ,
                'cantidad' => 2

            ],
            [
                'equipo' => 2 ,
                'cantidad' => 1
            ]
        ];
        $request->material_id=[
            [
                'material'=> 1,
                'metros'=>3
            ],
            [
                'material'=>2,
                'cantidad'=>2
            ]
        ];*/
        try {
            $rules = [
                'accion_id'=>'required|exists:acciones,id',
                'orden_servicio_id'=> 'required|exists:orden_servicios,id',
                'horas'=> 'numeric|nullable',
                'equipo_id'=>'required',
                /*'cantidad_equipos'=>'numeric|nullable',
                'material_id'=>'numeric|nullable',
                'material_metros'=>'numeric|nullable',*/
                'cantidad_materiales'=>'numeric|nullable'

            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                 ]);
            }
            $actividad= Actividades::create(['orden_servicio_id'=>$request->orden_servicio_id,'accion_id'=>$request->accion_id,'horas'=>$request->horas,'estado'=>'no completado']);
            //si se esta agregando un equipo a la actividad
            if($request->equipo_id!=null){
                foreach ($request->equipo_id as $equipo) {
                   // dd($equipo);
                    $Equipo=Equipos::findOrFail($equipo['equipo']);
                    $actividad->equipos()->where("actividad_id",$actividad->id)
                    ->save($Equipo,['cantidad'=>$equipo['cantidad']]);
                }
            }
            //si se esta agregando un meterial a la actividad
            if($request->material_id!=null){
                foreach ($request->material_id as  $Material) {
                   // dd($Material);
                    $material=Materiales::findOrFail($Material['material']);
                    if(isset($Material['metros'])/*$request->has('material_metros')&&$request->material_metros>0*/){
                        $actividad->materiales()->where("actividad_id",$actividad->id)
                    ->save($material,['metros'=>$Material['metros']]);
                    }
                    if(isset($Material['cantidad'])/*$request->has('cantidad_materiales')&&$request->cantidad_materiales>0*/){
                        $actividad->materiales()->where("actividad_id",$actividad->id)
                    ->save($material,['cantidad'=>$Material['cantidad']]);
                    }
                }
            }
            return response()->json(['create' => true], 200);
        }
        catch(Exeption $e){
            return response()->json(['create' => false,"mensaje"=>$e->getMessage()], 404);
        }
        catch(ModelNotFoundException $e){
            return response()->json(['create' => false,"mensaje"=>$e->getMessage()], 500);
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
        $actividad= Actividades::with('accion','equipos','materiales')->where('id',$id)->first();
       // dd($actividad);
        return response()->json(['actividad'=>$actividad], 200);
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
        //prueba sin postman porque es un rollo pasar arreglos por ahi
       /* $request->equipo_id=[
            [
                'equipo' => 1 ,
                'cantidad' => 2

            ],
            [
                'equipo' => 2 ,
                'cantidad' => 3
            ]
        ];
        $request->material_id=[
            [
                'material'=> 1,
                'metros'=>4
            ],
            [
                'material'=>2,
                'cantidad'=>1
            ]
        ];*/
        
        try {
            $rules = [
                'orden_servicio_id'=> 'required|exists:orden_servicios,id',
                'horas'=> 'numeric|nullable',
                'equipo_id'=>'numeric|nullable',
                'cantidad_equipos'=>'numeric|nullable',
                'material_id'=>'numeric|nullable',
                'material_metros'=>'numeric|nullable',
                'cantidad_materiales'=>'numeric|nullable'
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                 ]);
            }
            $actividad= Actividades::findOrFail($id);
            $actividad->update(['horas'=>$request->horas]);
            //si se esta agregando un equipo a la actividad
            if(isset($request->equipo_id)){
                $actividad->equipos()->where("actividad_id",$actividad->id)->detach();
                foreach ($request->equipo_id as $equipo) {
                    $Equipo=Equipos::findOrFail($equipo['equipo']);
                     $actividad->equipos()->where("actividad_id",$actividad->id)
                     ->save($Equipo,['cantidad'=>$equipo['cantidad']]);
                 }
            }
            //si se esta agregando un meterial a la actividad
            if(isset($request->material_id)){
                $actividad->materiales()->where("actividad_id",$actividad->id)->detach();
                foreach ($request->material_id as  $Material) {
                    $material=Materiales::findOrFail($Material['material']);
                   if(isset($Material['metros'])){
                        $actividad->materiales()->where("actividad_id",$actividad->id)
                        ->save($material,['metros'=>$request->material_metros]);
                    }
                    if(isset($Material['cantidad'])){
                        $actividad->materiales()->where("actividad_id",$actividad->id)
                        ->save($material,['cantidad'=>$Material['cantidad']]);
                    }
                }
            }

            return response()->json(['update' => true], 200);
        }
        catch(Exeption $e){
            return response()->json(['update' => false,"mensaje"=>$e->getMessage()], 404);
        }
        catch(ModelNotFoundException $e){
            return response()->json(['update' => false,"mensaje"=>$e->getMessage()], 500);
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
        $actividad= Actividades::findOrFail($id);
        $actividad->materiales()->where("actividad_id",$actividad->id)->detach();
        $actividad->equipos()->where("actividad_id",$actividad->id)->detach();
        $actividad->delete();
        return response()->json(['delete' => true], 200);
    }

   
}
