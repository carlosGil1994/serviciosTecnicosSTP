<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Tlfns_usuarios;
use App\Propiedades;
use App\Servicios;
use Illuminate\Support\Facades\Hash;
use Exception;
use DataTables;
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
        $servicios=Servicios::all();
        return view('usuarios')->with(array(
            'mod' => self::MODEL,
            'cantidad' => 0,
            'header' => 'Usuarios',
            'servicios'=> $servicios,
            'mostrarBoton'=>true
        ));
    }

    public function usertable()
    {
        $users = User::all();
        return DataTables::of($users)
        ->addColumn('action', function ($user) {
            $output='';
            $output.='<a href="#edit-'.$user->id.'" data="'.$user->id.'" title="Editar" class="btn btn-xs btn-primary btn-table editar"><i class="fas fa-edit"></i></a>';
            if(Auth::user()->tipo==1){
                $output.= ' <a href="#edit-'.$user->id.'" data="'.$user->id.'"title="borrar" class="btn btn-xs btn-primary btn-table borrar"><i class="fas fa-trash-alt"></i></a>';
            }
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
    public function busqueda($busqueda){
        $usuarios = User::where('tipo',4)->where('name','LIKE','%'.$busqueda.'%')
        ->orWhere('apellido','LIKE','%'.$busqueda.'%')->get();
        return response()->json([
            'usuarios' => $usuarios
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
            ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                 ]);
            }
            try{
               /* if(isset($request->telefonosP)){
                    $telefonosP = explode(',', $request->telefonosP);
                    foreach ($telefonosP as $telefonoP) {
                        $telefonoParray[]['numero']=$telefonoP;
                    }
                }*/
                // se crea el usuario
                $usuario=User::create(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>Hash::make($request->password),'tipo'=>$request->tipo]);
               
                if(isset($request->telefonos)){
                    $usuario->telefonos()->createMany($telefonoarray);
                }
                // se crea la propiedad
               /* $propiedad=$usuario->propiedades()->create(['nombre'=>$request->nombreP,'direccion'=>$request->direccionP]);
                if(isset($request->telefonosP)){
                    $propiedad->telefonos()->createMany($telefonoParray);
                }*/
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
                        $serv= Servicios::find(intval($servicio));
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
            $usuarios=User::with('telefonos','especialidades')->where('id',$id)->first();
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
        if(isset($request->serviciosT)){
            $servicios = explode(',', $request->serviciosT);
            foreach ($servicios as $servicio) {
                $servicioarray[]['servicio']=intval($servicio);
            }
            //dd($servicioarray);
        }
        if(isset($request->telefonos)){
            $telefonos = explode(',', $request->telefonos);
            foreach ($telefonos as $telefono) {
                $telefonoarray[]['numero']=$telefono;
            }
        }
        try{
            if($request->tipo == 4 ){
                $usuario=User::findOrFail($id);
                $usuario->update(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>Hash::make($request->password)]);
                $telefonos = $usuario->telefonos;
                if(isset($request->telefonos)){
                    foreach ($telefonos as $key => $telefono) {
                        $telefono->delete();
                    }
                    $usuario->telefonos()->createMany($telefonoarray);
                }
                
            }
            if($request->tipo == 3 ){
                    /////////// esto hay que cambiarlo para que funcione con un arreglo enviado desde el front////
                ///////////////////////////////////////////////////////////////////////////////////////////////
                $usuario=User::findOrFail($id);
                $usuario->update(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>Hash::make($request->password)]);
                $telefonos = $usuario->telefonos;
                if(isset($request->telefonos)){
                    foreach ($telefonos as $key => $telefono) {
                        $telefono->delete();
                    }
                    $usuario->telefonos()->createMany($telefonoarray);
                }

                /*foreach ($telefonos as $telefono) {
                    for ($i=0; $i < count($ids) ; $i++) { 
                        if($telefono->id == $ids[$i]){
                            $telefono->numero=$telefonoarray[$i]['numero'];
                        }
                    }
                    $telefono->save();
                }*/
            }
            /*if($request->tipo == 4 ){
                $usuario=User::findOrFail($id);
                $usuario->update(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>Hash::make($request->password)]);
                $telefonos = $usuario->telefonos;
                $propiedades = $usuario->propiedades;
                foreach ($propiedades as $key => $propiedad) {
                    $propiedad->delete();
                }
                foreach ($telefonos as $key => $telefono) {
                    $telefono->delete();
                }

                $usuario->telefonos()->createMany($telefonoarray);

            }*/
            if($request->tipo == 2){
               // dd($servicioarray);
              // dd($servicioarray);
                $usuario=User::findOrFail($id);
                $usuario->update(['name'=>$request->name,'apellido'=>$request->apellido,'direccion'=>$request->direccion,'email'=>$request->email,'password'=>Hash::make($request->password)]);
                $telefonos = $usuario->telefonos;
                $especialidades= $usuario->especialidades;
               /* foreach ($telefonos as $key => $telefono) {
                    $telefono->delete();
                }*/
                foreach ($especialidades as $key => $especialidad) {
                    //dd($especialidad->id);
                    $usuario->especialidades()->detach($especialidad->id);
                }
                if(isset($request->telefonos)){
                    foreach ($telefonos as $key => $telefono) {
                        $telefono->delete();
                    }
                    $usuario->telefonos()->createMany($telefonoarray);
                }
                if(isset($request->serviciosT)){
                    foreach ($servicioarray as $servicio) {
                        //dd($servicio['servicio']);
                        $serv= Servicios::find($servicio['servicio']);
                        //dd( $serv);
                        $usuario->especialidades()->save($serv);
                    }
                }
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
            $usuario->clientes()->detach();
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
