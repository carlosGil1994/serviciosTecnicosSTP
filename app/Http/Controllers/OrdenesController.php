<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Orden_servicios;
use App\Propiedades;
use App\User;
use App\PagoServicios;
use App\Actividades;
use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class OrdenesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        $request->creador_id=Auth::id();
        if($request->has('tecnico_id')){
            $request->estado='asignado';
        }else{
            $request->estado='sin asignar';
        }
        try{ 
            $rules = [
                'propiedad_id'=>'required|exists:propiedades,id',
                'fecha_ini'=> 'required',
                'descripcion'=>'required',
                'fecha_ini'=> 'required',
                'creador_id'=>'required|exists:users,id',
                'servicio_id'=>'required|exists:servicios,id',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                 ]);
            }
            $orden= Orden_servicios::create(['propiedad_id'=>$request->propiedad_id,'descripcion'=>$request->descripcion,'fecha_ini'=>$request->fecha_ini,'creador_id'=>$request->creador_id,'servicio_id'=>$request->servicio_id,'estado'=>$request->estado]);
           // $orden= Orden_servicios::create([$request->all()]);
           $orden->pagoServicio()->create(['estado'=>'no pagada']);
            return response()->json(['create' => true], 200);
        }
        catch(Exeption $e){
            return response()->json(['create' => false,"mensaje"=>$e->getMessage()], 404);
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
        //dd($date = Carbon::now());
        try{ 
            $orden= Orden_servicios::with('propiedades','servicio','creador','tecnico','cancelador','actividades')->where('id',$id)->first();
            return response()->json([
                'orden' => $orden
            ],200);
        }
        catch(Exeption $e){
            return response()->json(['create' => false,"mensaje"=>$e->getMessage()], 404);
        }
        catch(ModelNotFoundException $e){
            return response()->json(['update' => false], 500);
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
            $rules = [
                'propiedad_id'=>'required|exists:propiedades,id',
                'fecha_ini'=> 'required',
                'descripcion'=>'required',
                'fecha_ini'=> 'required',
                'servicio_id'=>'required|exists:servicios,id',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ]);
            }
            $orden= Orden_servicios::findOrFail($id)->update(['propiedad_id'=>$request->propiedad_id,'descripcion'=>$request->descripcion,'fecha_ini'=>$request->fecha_ini,'servicio_id'=>$request->servicio_id,'estado'=>$request->estado]);
            return response()->json(['update' => true]);
        } 
        catch(ModelNotFoundException $e){
            return response()->json(['update' => false], 500);
        }
        catch(exeption $e){
            return response()->json(['delete' => false], 500);
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
        try {
            $orden= Orden_servicios::findOrFail($id)->delete();
        }
        catch(ModelNotFoundException $e){
            return response()->json(['update' => false], 500);
        }
        catch(exeption $e){
            return response()->json(['delete' => false], 500);
        }

    }

    public function cerrarOrden($id){
        try {
            //debe ser con Auth::user() ala hora de estar en produccion
           // $user=Auth::user(); 
           $user=User::findOrfail(1);
            if($user->tipo==2){
                $suma=0;
                /// es tecnico
                //tambien se actualizara el pago del tecnico
                $orden= Orden_servicios::findOrFail($id);
                $orden->update(['cierre_tecnico'=> $user/*$user->id*/,'fecha_fin'=>Carbon::now()]);
                $actividades= $orden->actividades;
                //aqui se actualizara el precio del pago servicio si este es 0
                if($orden->pagoServicio->pago_total <= 0){
                    foreach ($actividades as $actividad) {
                        // monto de equipos
                        $accion= Actividades::findOrFail($actividad->id)->accion->costo;
                        if($equipoActividades=Actividades::findOrFail($actividad->id)->equipos){
                             //aqui se debe iterar
                            foreach ($equipoActividades as $equipo) {
                                $suma = $suma +( $equipo->precio*$equipo->pivot->cantidad)+($accion*$equipo->pivot->cantidad);
                            } 
                         }
                         //monto de materiales
                         if($materialActividades=Actividades::findOrFail($actividad->id)->materiales){
                             //aqui se debe iterar
                             foreach ($materialActividades as $material) {
                                if($material->pivot->cantidad){
                                    $suma = $suma +( $material->precio*$material->pivot->cantidad);    
                                }
                                if($material->pivot->metros){
                                    $suma = $suma +( $material->precio*$material->pivot->metros);
                                }
                             }
                           
                        }
                    }
                     $orden->pagoServicio()->update(['pago_total'=>$suma]);
                }
            }
            if($user->tipo==3){
                $orden= Orden::findOrFail($id)->update(['cierre_cliente'=> $user->id]);
            }
        }
        catch(ModelNotFoundException $e){
            return response()->json(['update' => false], 500);
        }
        catch(exeption $e){
            return response()->json(['delete' => false], 500);
        }
    }

    public function cancelar(Request $request,$id){
        $user=Auth::user(); 
        $orden= Orden::findOrFail($id);
        $orden->update(['cancelador_id'=> $user->id,'comentario'=>$request->comentario]);
        $pagoServicio =  $orden->pagoServicio()->update(['esatdo'=>'cancelado']);
    }
    public function calculoMonto($id){
        try {
             $suma=0;
            $actividades= Orden_servicios::findOrFail($id)->actividades;
            //dd($actividades);
             foreach ($actividades as $actividad) {
                if($equipoActividades=Actividades::findOrFail($actividad->id)->equipos->first()){
                    $accion= Actividades::findOrFail($actividad->id)->accion->costo;
                    //dd($equipoActividades->precio);
                    $suma = $suma +( $equipoActividades->precio*$equipoActividades->pivot->cantidad*$accion);
                 }
             }
            return $suma;
        }
        catch(ModelNotFoundException $e){
            return response()->json(['calculo' => false], 500);
        }
        catch(exeption $e){
            return response()->json(['calculo' => false], 500);
        }
    }
}
