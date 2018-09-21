<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use App\User;
use Exception;
use DataTables;
use App\Tlfns_cliente;
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
            'header' => 'Clientes',
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
    public function clienteTable()
    {
        $cliente = Clientes::all();
        return DataTables::of($cliente)
        ->addColumn('action', function ($cliente) {
            return '<a href="#edit-'.$cliente->id.'" data="'.$cliente->id.'" title="Editar" class="btn btn-xs btn-primary btn-table editar"><i class="fas fa-edit"></i></a>';
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
        $telefonoarray=[];
        if(isset($request->telefonosP)){
            $telefonos = explode(',', $request->telefonos);
            foreach ($telefonos as $telefono) {
                $telefonoarray[]['numero']=$telefono;
            }
        }
        $datos=[];
        $datos['nombre']=$request->nombreP;
        $datos['direccion']=$request->direccionP;
        $datos['tipo']=$request->tipo;
        $datos['telefonos']=$telefonoarray;
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
            if(isset($request->telefonosP)){
                $cliente->telefonos()->createMany($telefonoarray);
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
            $cliente=clientes::with('telefonos','user')->where('id',$id)->first();
            return response()->json([
                'cliente' => $cliente
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
       // dd('afsaf');
       /* $rules = [
            'nombre'=> 'required',
            'direccion'=>'required'
        ];
      
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ]);
            }*/
           // dd($request->telefonosP);
            try{
                $telefonoarray=[];
                if(isset($request->telefonosP)){
                    $telefonos = explode(',', $request->telefonosP);
                    foreach ($telefonos as $telefono) {
                        $telefonoarray[]['numero']=$telefono;
                    }
                }
               
                $datos=[];
                $datos['nombre']=$request->nombreP;
                $datos['direccion']=$request->direccionP;
                $datos['tipo']=$request->tipo;
                $datos['telefonos']=$telefonoarray;
                $datos['usuarios']=json_decode($request->usuariosT, true);
                $cliente=Clientes::findOrFail($id);
                $cliente->update(['nombre'=>$datos['nombre'],'direccion'=> $datos['direccion'],'tipo'=>$datos['tipo']]);
                $cliente->user()->detach();
                if($datos['usuarios']!=null){
                   
                    foreach ($datos['usuarios'] as $usuario) {
                       // dd($equipo);
                        $usuario=User::findOrFail($usuario['usuario_id']);
                        $cliente->user()->where("cliente_id",$cliente->id)
                        ->save($usuario);
                    }
                }
               
                if(isset($request->telefonosP)){
                    $telefonos = $cliente->telefonos;
                    foreach ($telefonos as $telefono) {
                        $telefono->delete();
                    }
                    
                        $cliente->telefonos()->createMany($telefonoarray);
                }
            return response()->json(['update' => true], 200);
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
