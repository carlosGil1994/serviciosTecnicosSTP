<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Tlfns_usuarios;
use App\Propiedades;
use App\Servicios;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsuariosController extends Controller
{
    const MODEL = 'Usuarios';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*try{
            $usuarios=User::with('telefonos')->get();
            return response()->json([
                'usuarios' => $usuarios
            ],200);

        } 
        catch(Exeption $e){
            return response()->json(['found' => false,"mensaje"=>$e->getMessage()], 404);
        }*/
        return view('usuarios')->with(array(
            'mod' => self::MODEL,
            'cantidad' => 0,
            'header' => 'Usuarios'
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->serviciosT)){
            $servicios = explode(',', $request->serviciosT);
            foreach ($servicios as $servicio) {
                $servicioarray[]['servicio']=$servicio;
            }
            //dd($servicioarray);
        }
        if(isset($request->telefonos)){
            $telefonos = explode(',', $request->telefonos);
            foreach ($telefonos as $telefono) {
                $telefonoarray[]['numero']=$telefono;
            }
        }
        if($request->tipo== 4){
            $rules = [
                'name'=>'required',
                'apellido'=> 'required',
                'direccion'=>'required',
                'email'=>'required',
                'nombreP'=>'required',
                'direccionP'=>'required',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                 ]);
            }
            try{
                if(isset($request->telefonosP)){
                    $telefonosP = explode(',', $request->telefonosP);
                    foreach ($telefonosP as $telefonoP) {
                        $telefonoParray[]['numero']=$telefonoP;
                    }
                }
                // se crea el usuario
                $usuario=User::create(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>Hash::make($request->password),'tipo'=>$request->tipo]);
               
                if(isset($request->telefonos)){
                    $usuario->telefonos()->createMany($telefonoarray);
                }
                // se crea la propiedad
                $propiedad=$usuario->propiedades()->create(['nombre'=>$request->nombreP,'direccion'=>$request->direccionP]);
                if(isset($request->telefonosP)){
                    $propiedad->telefonos()->createMany($telefonoParray);
                }
                return response()->json(['create' => true], 200);
            }
            catch(Exeption $e){
                return response()->json(['create' => false,"mensaje"=>$e->getMessage()], 404);
            } 
        }
        //dd($request->input('nameP'));
        //dd($request->direccion);
      
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
        if($request->tipo == 3 ){
            try{
                $usuario=User::create(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>Hash::make($request->password),'tipo'=>$request->tipo])->telefonos()->createMany($telefonoarray);
                return response()->json(['create' => true], 200);
            }
            catch(Exeption $e){
                return response()->json(['create' => false,"mensaje"=>$e->getMessage()], 404);
            }
        }
        if($request->tipo == 2 ){
            $rules = [
                'name'=>'required',
                'apellido'=> 'required',
                'direccion'=>'required',
                'email'=>'required',
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                 ]);
            }
           
            try{
                $usuario=User::create(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>Hash::make($request->password),'tipo'=>$request->tipo]);
                if(isset($request->telefonos)){
                    $usuario->telefonos()->createMany($telefonoarray);
                }
                if(isset($request->serviciosT)){
                    foreach ($servicioarray as $key => $servicio) {
                        $serv= Servicios::where('descripcion',$servicio)->first();
                        //dd( $serv);
                        $usuario->especialidades()->save($serv);
                    }
                }
                return response()->json(['create' => true], 200);
            }
            catch(Exeption $e){
                return response()->json(['create' => false,"mensaje"=>$e->getMessage()], 404);
            }
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
        $request->telefonos=[
            ['numero'=>424],
            ['numero'=>4249243767]
        ];
        try{
            /////////// esto hay que cambiarlo para que funcione con un arreglo enviado desde el front////
           // $telefonos = explode(',', $request->telefonos);
            foreach ($request->telefonos as $key => $telefono) {
                $telefonoarray[]['numero']=$telefono['numero'];
             }
           // $ids=explode(',', $request->ids);
            ///////////////////////////////////////////////////////////////////////////////////////////////
            $usuario=User::findOrFail($id);
            $usuario->update(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>Hash::make($request->password)]);
            $telefonos = $usuario->telefonos;
            foreach ($telefonos as $key => $telefono) {
                $telefono->delete();
            }
            $usuario->telefonos()->createMany($telefonoarray);

             /*foreach ($telefonos as $telefono) {
                for ($i=0; $i < count($ids) ; $i++) { 
                    if($telefono->id == $ids[$i]){
                        $telefono->numero=$telefonoarray[$i]['numero'];
                    }
                }
                $telefono->save();
             }*/
            
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
