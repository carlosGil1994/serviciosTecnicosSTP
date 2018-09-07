<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bancos;
use DataTables;

class BancoController extends Controller
{

    const MODEL = 'Bancos';
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cantidad = Bancos::all()->count();
        return view('bancos')->with(array(
            'mod' => self::MODEL,
            'cantidad' => $cantidad,
            'header' => 'Bancos'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // para crear
    public function create(Request $request)
    {
        $inputs = $request->all();
        Bancos::create($inputs);
        return response()->json('hola');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  Cuando le das al boton buscar
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */

    //  EL panel verde
    public function show(Request $request)
    {
        $bancos = Bancos::all();
        return DataTables::of($bancos)
        ->addColumn('action', function ($bancos) {    
            $output= <<<EOT
                <button class="btn btn-warning editar btn-table" id="$bancos->id">Editar</button>
                <button class="btn btn-danger eliminar btn-table" id="$bancos->id">Eliminar</button>            
EOT;
            return $output;
        })->make();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('item_id');
        $nombre = $request->input('nombre');
        $banco = Bancos::find($id);
        $banco->nombre = $nombre;
        $banco->save();
        return response()->json('hey');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $banco = Bancos::find($id);
        $nombre = $banco->nombre;
        $banco->delete();
        return response()->json($nombre);
    }
}
