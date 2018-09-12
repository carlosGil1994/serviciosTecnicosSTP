<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use App\User;
use Exception;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientesController extends Controller
{
    const MODEL = 'Clientes';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Clientes')->with(array(
            'mod' => self::MODEL,
            'cantidad' => 0,
            'header' => 'Clientes'
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
    public function clienteTable()
    {
        $cliente = Clientes::all();
        return DataTables::of($cliente)
        ->addColumn('action', function ($cliente) {
            return '<a href="#edit-'.$cliente->id.'" data="'.$cliente->id.'"class="btn btn-xs btn-primary btn-table editar"><i class="glyphicon glyphicon-edit"></i> Editar</a>';
        })->make();
    }

    public function busqueda($busqueda){
        $cliente = Clientes::where('nombre','LIKE','%'.$busqueda.'%')->get();
        return response()->json([
            'cliente' => $cliente
        ],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datos=[];
        $datos['nombre']=$request->nombreP;
        $datos['direccion']=$request->direccionP;
        $datos['tipo']=$request->tipo;
        $datos['telefonos']=json_decode($request->telefonosP, true);
        $datos['usuarios']=json_decode($request->usuariosT, true);
        
        try{
         
            $cliente = Clientes::create(['nombre'=>$datos['nombre'],'direccion'=> $datos['direccion'],'tipo'=>$datos['tipo']]);
            if($datos['usuarios']!=null){
                foreach ($datos['usuarios'] as $equipo) {
                   // dd($equipo);
                    $usuario=User::findOrFail($equipo['usuario_id']);
                    $cliente->user()->where("cliente_id",$cliente->id)
                    ->save($usuario);
                }
            }
            return response()->json(['create' => true], 200);
        } 
        catch(exeption $e){
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
        try{
            $propuedad=Propiedades::findOrFail($id);
            return response()->json([
                'Propiedad' => $propiedad
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
        $rules = [
            'id'=>'required|exists:propiedades,id',
            'nombre'=> 'required',
            'direccion'=>'required'
        ];
        try{
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ]);
            }
            $propiead = Propiedades::findOrFail($request->id)->update($request->all());
            return response()->json(['create' => true], 200);
        } 
        catch(exeption $e){
            return response()->json(['create' => false,"mensaje"=>$e->getMessage()], 404);
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
            $propiead = Propiedades::findOrFail($request->id)->delete();
            return response()->json(['delete' => true], 200);
        }
        catch(Exeption $e){
            return response()->json(['delete' => false,"mensaje"=>$e->getMessage()], 404);
        }

    }
}
