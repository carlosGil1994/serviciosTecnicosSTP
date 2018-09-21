<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orden_servicios;
use App\User;
use App\Servicios;
use Carbon\Carbon;
use App\PagoServicios;
use Illuminate\Support\Facades\Auth;
use DataTables;

class PagoServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('PagoServicios')->with(array(
            'mod' => 'Ordenes',
            'cantidad' => 0,
            'header' => 'Pago de servicios',
            'mostrarBoton'=>false
        ));
    }
    public function estadisticas()
    {
        return view('EstadisticasAdministracion')->with(array(
            'mod' => 'PagoServicios',
            'cantidad' => 0,
            'header' => 'Estadisticas',
            'mostrarBoton'=>false
        ));
    }

    public function PagoTable(){
        if(Auth::user()->tipo==4){
            $ordenes=[];
            $ordenesPorClientes=User::with('clientes.ordenServicio','clientes.ordenServicio.servicio','clientes.ordenServicio.pagoServicio')->where('id',Auth::id())->first();
           
           // dd($ordenesPorClientes);
            foreach ($ordenesPorClientes->clientes as $cliente) {
                // dd($cliente);
                 foreach ($cliente['ordenServicio'] as $order) {
                     $order['cliente']=$cliente->nombre;
                     $order['servicio']=$order->servicio->descripcion;
                     $order['pago_total']=$order->pagoServicio->pago_total;
                     $ordenes[]= $order;
                 }
             }
        }else{
            $ordenesAux= Orden_servicios::with('clientes.user','pagoServicio','servicio')->get();
            foreach ($ordenesAux as $orden) {
                // dd($cliente);
                $orden['cliente']=$orden->clientes->nombre;
                $orden['servicio']=$orden->servicio->descripcion;
                $orden['pago_total']=$orden->pagoServicio->pago_total;
                $ordenes[]=$orden;
             }
        }
       


      //  $ordenes= Orden_servicios::with('clientes.user','pagoServicio','servicio')->get();
        return DataTables::of($ordenes)
        ->addColumn('action', function ($orden) {
            $output ='';
            $output .=' <a href='."'".url("Comprobantes/index")."/".$orden->pagoservicio->id."'".'"data="'.$orden->pagoservicio->id.'" title="Comprobantes "class="btn btn-xs btn-primary "><i class="fas fa-money-check"></i></a>';
            if(Auth::user()->tipo==3){
                $output .=' <a  href="#" data="'.$orden->pagoservicio->id.'" title="Comprobar el pago del servicio" class="btn btn-xs btn-primary btn-table comprobar"><i class="fas fa-check-double"></i></a>';
                if($orden->pagoServicio->estado=='Espera del 50%'){
                    $output .=' <a  href="#" data="'.$orden->pagoservicio->id.'" title="Comprobar pago 50%" class="btn btn-xs btn-primary btn-table comprobar50"><i class="fas fa-check"></i></a>';
                }
            }
            /*$output = <<<EOT
            <a href="#" data="$orden->id" title="Editar" class="btn btn-xs btn-primary btn-table editar"><i class="fas fa-edit"></i></a>
EOT;*/
       // $output .=' <a data="'.$ordenes->id.'"class="btn btn-xs btn-primary btn-table completar"><i class="glyphicon glyphicon-edit"></i>completar</a>';
        //$output .=' <a href='."'".url("Comprobantes/index")."/".$orden->pagoservicio->id."'".'"data="'.$orden->pagoservicio->id.'" title="Comprobantes "class="btn btn-xs btn-primary "><i class="fas fa-money-check"></i></a>';
       // $output .=' <a  href="#" data="'.$orden->pagoservicio->id.'" title="Comprobar el pago del servicio" class="btn btn-xs btn-primary btn-table comprobar"><i class="fas fa-check"></i></a>';
        // $output .=' <a href='."'".url("Actividades/completar")."/".$actividad->id."'".'"data="'.$actividad->id.'"class="btn btn-xs btn-primary btn-table crear"><i class="glyphicon glyphicon-edit"></i>completar</a>';
            return $output;
        })->make();
        
    }

    public function comprobar($id){
        $pagoServicio=PagoServicios::find($id)->update(['estado'=>'pagado']);
        return response()->json(['update' => true]);
    }
    public function comprobar50($id){
        $pagoServicio=PagoServicios::find($id)->update(['estado'=>'Pagado 50%']);
        return response()->json(['update' => true]);
    }

    public function montoServicios(Request $request){
        
        $fechaInicio = new Carbon($request->fechaInicio.' '.'00:00:00');
        $fechaFinal = new Carbon($request->fechaFinal.' '."23:59:59");
        $pagoServicios= PagoServicios::whereBetween('created_at', [ $fechaInicio,  $fechaFinal])->where('estado','pagado')->get();
       // dd($pagoServicios);
        $servicios= Servicios::all();
        foreach ($servicios as $servicio) {
             $suma=0;
            foreach($pagoServicios as $pagoServicio) {
              //  dd($suma);
                $servicioOrden=$pagoServicio->ordenServicio->servicio;
              //  dd($pagoServicios);
                if($servicioOrden->id == $servicio->id){
                    $suma+=$pagoServicio->pago_total;
                }
            }
            $servicio['monto']=$suma;
        }
        return response()->json(['servicios' =>  $servicios]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
