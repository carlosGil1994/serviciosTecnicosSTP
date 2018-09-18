<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Orden_servicios;
use App\Propiedades;
use App\Cotizaciones;
use App\User;
use App\PagoServicios;
use App\Actividades;
use Exception;
use DataTables;
use PDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class OrdenesController extends Controller
{
    const MODEL = 'Orden_servicios';
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
    public function cotizaciones($id){
        return view('Cotizaciones')->with(array(
            'mod' => 'Ordenes',
            'cantidad' => 0,
            'header' => 'Cotizaciones',
            'mostrarBoton'=>true,
            'id'=> $id,
        ));
    }
    public function cotizacionesTable($id){
        $cotizaciones=Cotizaciones::where('orden_servicio_id',$id)->get();
        return DataTables::of($cotizaciones)
        ->addColumn('action', function ($cotizacion) {
        $output =' <a href='."'".url("Ordenes/descargarPdf")."/".$cotizacion->id."'".'"data="'.$cotizacion->id.'" title="Descargar" class="btn btn-xs btn-primary "><i class="fas fa-download"></i></a>';
        $output .=' <a href='."'".url("Ordenes/showCotizacion")."/".$cotizacion->id."'".'"data="'.$cotizacion->id.'" title="visualizar" target="_blank" class="btn btn-xs btn-primary "><i class="far fa-eye"></i></a>';
       // $output .=' <a href='."'".url("Actividades/completar")."/".$actividad->id."'".'"data="'.$actividad->id.'"class="btn btn-xs btn-primary btn-table crear"><i class="glyphicon glyphicon-edit"></i>completar</a>';     
       return $output;
        })->make();
    }

    public function showCotizacion($id){
        $cotizacion=Cotizaciones::find($id);
        $url = $cotizacion->path;
        if ( file_exists($url))
         {
        return response()->file($url);
        }
    }
    public function descargarPdf($id){
        $cotizacion=Cotizaciones::find($id);
        $url = $cotizacion->path;
        if ( file_exists($url))
         {
        return response()->download($url);
        }
    }

    public function generarPdf($id){
        $orden= Orden_servicios::findOrFail($id);
       // $orden['cliente']=$orden->propiedades->user;
       // dd($orden['cliente']->name);
        $orden['cliente']=$orden->clientes;
        $actividades= $orden->actividades;
        $aux=Carbon::now();
        $date=[$aux->day,$aux->month,$aux->year];
        $orden['fecha']=$date;
        $suma=0;

        foreach ($actividades as $act) {
            $accion= Actividades::findOrFail($act->id)->accion->costo;
            $equiposArray=[];
            $materialesArray=[];
            $equipos=Actividades::find($act->id)->equipos;
            $materiales=Actividades::find($act->id)->materiales;
            if($equipos){
                foreach ($equipos as $equipo) {
                    $equiposArray[]=$equipo;
                    $suma = $suma +( $equipo->precio*$equipo->pivot->cantidad)+($accion*$equipo->pivot->cantidad);
                }
            }
            if($materiales){
                foreach ($materiales as $material) {
                    $materialesArray[]=$material;
                    if($material->pivot->cantidad){
                        $suma = $suma +( $material->precio*$material->pivot->cantidad);    
                    }
                    if($material->pivot->metros){
                        $suma = $suma +( $material->precio*$material->pivot->metros);
                    }
                }
            }
            $act['action']=Actividades::findOrFail($act->id)->accion;
            $act['equipos']= $equiposArray;
            $act['materiales']= $materialesArray;
        }
        $orden['subtotal']=$suma;
        $orden['actividades']=$actividades;
        
       // dd($orden);
        $data['orden']=$orden;
        $fecha= Carbon::now();
        $nombreArchivo = $orden['id'].'-'.$fecha->toDateString().' '.$fecha->hour.'-'.$fecha->minute.".pdf";
        $path=storage_path('app/public/cotizaciones').'/'.$nombreArchivo;
        
      
        $pdf = PDF::loadView('generarPdf2', $data);
        $output = $pdf->output();
        file_put_contents(storage_path('app/public/cotizaciones').'/'.$nombreArchivo, $output);
        $cotizacion= Cotizaciones::create(['path'=>$path,'fecha_creacion'=>$fecha,'orden_servicio_id'=>$orden->id]);
       // $cotizacion=Cotizaciones::find(1);
        $url = $cotizacion->path;
       // $cotizacion= Cotizaciones::create(['path'=>$path,'fecha_creacion'=>$fecha,'orden_servicio_id'=>$orden->id]);
       // $url = storage_path('app/public/cotizaciones').'/'.$nombreArchivo;
       // file_put_contents(storage_path('app/public/cotizaciones').'/'.$nombreArchivo, $output);
       // return $pdf->stream();
       // return "true";
        return response()->file($url); //para devolver sin descargar 
      /* $pdf = PDF::loadView('generarPdf2', $data);
       $fecha= Carbon::now();
       //dd($fecha->toDateString());
        $nombreArchivo = $orden['id'].'-'.$fecha->toDateString().".pdf";

//Guardalo en una variable
$output = $pdf->output();
file_put_contents(storage_path('app/public/cotizaciones').'/'.$nombreArchivo, $output);
        //\Storage::disk('public')->put($nombreArchivo,  \File::get($output));
        //dd($nombreArchivo);
       // return $pdf->download('hdtuto.pdf');*/
       //return $output;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fecha=new Carbon($request->fechaIni.' '.$request->timepicker1);
        $cliente=json_decode($request->cliente, true);
        
        if($request->has('tecnico')){
           $estado='asignado';
        }else{
            $estado='sin asignar';
        }
        try{ 
            $rules = [
                'descripcion'=>'required',
                'fechaIni'=> 'required',
                'servicio'=>'required|exists:servicios,id',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                 ]);
            }
            $orden= Orden_servicios::create(['cliente_id'=>$cliente['cliente'],'descripcion'=>$request->descripcion,'fecha_ini'=>$request->fecha,'creador_id'=>Auth::id(),'servicio_id'=>$request->servicio,'estado'=>$estado]);
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
            $orden= Orden_servicios::with('clientes','servicio','creador','tecnico','cancelador','actividades')->where('id',$id)->first();
            $aux=new Carbon($orden['fecha_ini']);
            $orden['fecha_ini']= $aux->format('g:i A');
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
       // dd($request);
        $fecha=new Carbon($request->fechaIni.' '.$request->timepicker1);
        $cliente=json_decode($request->cliente, true);
        $estado='asignado';
        try{ 
          /*  $rules = [
                'descripcion'=>'required',
                'servicio_id'=>'required|exists:servicios,id',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ]);
            }*/
            $orden= Orden_servicios::findOrFail($id);
            if($orden['estado']=="no asignado" && $request->has('tecnico')){
                $estado='asignado';
            }
            else{
                if($request->estado){
                    $estado=$request->estado;
                }
            }
            $orden->update(['cliente_id'=>$cliente['id'],'descripcion'=>$request->descripcion,'fecha_ini'=>$request->fecha,'servicio_id'=>$request->servicio,'estado'=>$estado]);
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
           $user=Auth::user(); 
          // $user=User::findOrfail(1);
            if($user->tipo==2){
                $suma=0;
                /// es tecnico
                //tambien se actualizara el pago del tecnico
                $orden= Orden_servicios::findOrFail($id);
                $orden->update(['cierre_tecnico'=> $user/*$user->id*/,'fecha_fin'=>Carbon::now()]);
                $actividades= $orden->actividades;
                //aqui se actualizara el precio del pago servicio si este es 0
              //  dd($orden->pagoServicio->pago_total);
                if($orden->pagoServicio->pago_total <= 0){
                  //  dd($orden->pagoServicio->pago_total);
                    foreach ($actividades as $actividad) {
                        // monto de equipos
                       // dd($actividad);
                        $accion= Actividades::findOrFail($actividad->id)->accion->costo;
                        //dd($accion);
                        if($equipoActividades=Actividades::findOrFail($actividad->id)->equipos){
                             //aqui se debe iterar
                             //dd($equipoActividades);
                            foreach ($equipoActividades as $equipo) {
                                $suma = $suma +( $equipo->precio*$equipo->pivot->cantidad)+($accion*$equipo->pivot->cantidad);
                                //dd($suma);
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
            return response()->json(['update' => true], 200);
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
