<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orden_servicios;
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
            'header' => 'Pago de servicios'
        ));
    }

    public function PagoTable(){
        $ordenes= Orden_servicios::with('clientes','pagoServicio','servicio')->get();
        return DataTables::of($ordenes)
        ->addColumn('action', function ($orden) {
            $output = <<<EOT
            <a data="$orden->id"class="btn btn-xs btn-primary btn-table editar"><i class="glyphicon glyphicon-edit"></i>Panel</a>
EOT;
       // $output .=' <a data="'.$ordenes->id.'"class="btn btn-xs btn-primary btn-table completar"><i class="glyphicon glyphicon-edit"></i>completar</a>';
        $output .=' <a href='."'".url("Comprobantes/index")."/".$orden->pagoservicio->id."'".'"data="'.$orden->pagoservicio->id.'"class="btn btn-xs btn-primary "><i class="glyphicon glyphicon-edit"></i>Comprobantes</a>';
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
