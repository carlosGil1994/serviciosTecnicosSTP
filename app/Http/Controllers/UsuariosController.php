<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tlfns_usuarios;
use App\Propiedades;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $usuarios=User::with('telefonos')->get();
            return response()->json([
                'usuarios' => $usuarios
            ],200);

        } 
        catch(Exeption $e){
            return response()->json(['found' => false,"mensaje"=>$e->getMessage()], 404);
        }
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
        //dd($request->direccion);
        $telefonos = explode(',', $request->telefonos);
        foreach ($telefonos as $key => $telefono) {
            $telefonoarray[]['numero']=$telefono;
        }
       /* $user= User::find(8);
        $user->direccion=$request->direccion;
        $user->save();*/
        //dd($telefonoarray);
       // dd($telefonos);
       /* if($request->tipo == 1 || 2 || 3){

        }
        else{
            if($request->tipo== 4 ){
                
            }
        }*/
        try{
            $usuario=User::create(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>$request->password,'tipo'=>$request->tipo])->telefonos()->createMany($telefonoarray);
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
        try{
            $usuarios=User::find($id)::with('telefonos','propiedades')->get();
            return response()->json([
                'usuarios' => $usuarios
            ],200);
        } 
        catch(Exeption $e){
            return response()->json(['found' => false,"mensaje"=>$e->getMessage()], 404);
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
            /////////// esto hay que cambiarlo para que funcione con un arreglo enviado desde el front////
            $telefonos = explode(',', $request->telefonos);
            foreach ($telefonos as $key => $telefono) {
                $telefonoarray[]['numero']=$telefono;
             }
            $ids=explode(',', $request->ids);
            ///////////////////////////////////////////////////////////////////////////////////////////////
            $usuario=User::findOrFail($id);
            $usuario->update(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>$request->password]);
            $telefonos = $usuario->telefonos;
             foreach ($telefonos as $telefono) {
                for ($i=0; $i < count($ids) ; $i++) { 
                    if($telefono->id == $ids[$i]){
                        $telefono->numero=$telefonoarray[$i]['numero'];
                    }
                }
                $telefono->save();
            }
            
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
        try{
            $usuario= User::find($id);
            $usuario->telefonos()->delete();
            $usuario->delete();
             return response()->json(['delete' => true],200);
        } 
        catch(exeption $e){
            return response()->json(['delete' => false], 500);
        }
        catch(ModelNotFoundException $e){
            return response()->json(['update' => false], 500);
        }
    }
}
