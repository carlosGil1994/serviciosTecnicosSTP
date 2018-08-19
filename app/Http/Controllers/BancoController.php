<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bancos;

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
        $query = $request->input('query');
        if(!empty($query)){
            $rows = Bancos::where('nombre', 'LIKE', '%'.$query.'%')->get();
        }else{
            $rows = Bancos::all();
        }
        $output = '';
        
        if($rows->count()){
            $output.= <<<EOT
            <div class="list-group">
EOT;
        foreach($rows as $result){
            $output.=<<<EOT
            <div class="list-group-item">
                <a href="#" class="search-result" data-id="$result->id">
                    <span>Nombre: <b>$result->nombre</b></span><br>
                </a>
            </div>
EOT;
        }
        $output.=<<<EOT
            </div>
EOT;

        }
        else{
            $output.=<<<EOT
            <div class="list-group">
                <div class="list-group-item">
                    <span>No se encontraron registros</span>
                </div>
            </div>
EOT;
        }
        return response()->json($output);

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
        $id = $request->input('id');
        $record = Bancos::find($id);
        $output = <<<EOT
            <div>
                <span>Nombre: <b>$record->nombre</b></span><br>
                <span>Creado: <b>$record->created_at</b></span><br>
            </div>
EOT;
        return response()->json($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */
    public function edit(Facultades $facultades)
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
