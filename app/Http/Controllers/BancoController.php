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
            'header' => 'Bancos',
            'mostrarBoton'=>true
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
        $inputs = $request->all();
        Bancos::create($inputs);
        return response()->json('hola');
    }
    public function show($id)
    {
        try{
            $banco=Bancos::findOrFail($id);
            return response()->json([
                'banco' => $banco
            ],200);
        }
        catch(ModelNotFoundException $e){
            return response()->json(['found' => false], 404);
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */

    //  EL panel verde
    public function bancosTable(Request $request)
    {
        $bancos = Bancos::all();
        return DataTables::of($bancos)
        ->addColumn('action', function ($banco) {    
            $output= <<<EOT
            <a href="#" data="$banco->id" title="Editar" class="btn btn-xs btn-primary btn-table editar"><i class="fas fa-edit"></i></a>
            <a href="#" data="$banco->id" title="borrar" class="btn btn-xs btn-primary btn-table borrar"><i class="fas fa-trash-alt"></i></a>           
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
    public function update(Request $request,$id)
    {
        $banco = Bancos::find($id);
        $banco->nombre = $request->nombre;
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
