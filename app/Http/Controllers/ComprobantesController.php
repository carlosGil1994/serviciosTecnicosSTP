<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PagoServicios;
use App\Comprobantes;
use App\Bancos;
use DataTables;
use Carbon\Carbon;

class ComprobantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $bancos= Bancos::all();
        return view('Comprobantes')->with(array(
            'mod' => 'Comprobantes',
            'cantidad' => 0,
            'header' => 'Comprobantes',
            'id'=>$id,
            'bancos'=>$bancos,
            'mostrarBoton'=>true
        ));
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
    public function ComprobantesTable($id){
        $comprobantes= Comprobantes::with('banco')->where('pago_servicio_id',$id)->get();
        return DataTables::of($comprobantes)
       /* ->addColumn('action', function ($comprobante) {
            $output = <<<EOT
            <a data="$orden->id"class="btn btn-xs btn-primary btn-table editar"><i class="glyphicon glyphicon-edit"></i>Panel</a>
EOT;
        $output .=' <a data="'.$comprobante->comprobante->id.'"class="btn btn-xs btn-primary btn-table completar"><i class="glyphicon glyphicon-edit"></i>panel</a>';
       // $output .=' <a href='."'".url("Comprobantes/index")."/".$comprobante->id."'".'"data="'.$comprobante->id.'"class="btn btn-xs btn-primary "><i class="glyphicon glyphicon-edit"></i>Comprobantes</a>';
       // $output .=' <a href='."'".url("Actividades/completar")."/".$actividad->id."'".'"data="'.$actividad->id.'"class="btn btn-xs btn-primary btn-table crear"><i class="glyphicon glyphicon-edit"></i>completar</a>';
            return $output;
        })*/->make();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comprobante= Comprobantes::create(['estatus'=>'asffs','pago_parcial'=>$request->pago,'fecha_pago'=>Carbon::now(),'pago_servicio_id'=>$request->pagoServicioId,'banco_id'=>$request->banco,'num_recibo'=>$request->recibo]);
        return response()->json([
            'create' => true
        ],200);
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
