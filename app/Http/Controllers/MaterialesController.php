<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materiales;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $Materiales=Materiales::all();
            return response()->json([
                'Materiales' => $Materiales
            ],200);
        }
        catch(Exception $e){
            return response()->json(['found' => false], 404);
        } 
    }

    public function busqueda($busqueda)
    {
        $Materiales= Materiales::where('nombre','LIKE','%'.$busqueda.'%')->get();
        return response()->json([
            'Materiales' => $Materiales
        ],200);
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
        $rules = [
            'descripcion'=> 'required',
            'nombre'=> 'required|unique:materiales',
            ];
 
        try {
            // Ejecutamos el validador y en caso de que falle devolvemos la respuesta
            // con los errores
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ]);
            }
            // Si el validador pasa, almacenamos
            Materiales::create($request->all());
            return response()->json(['created' => true]);
        } catch (Exception $e) {
            // Si algo sale mal devolvemos un error.
            //\Log::info('Error creating user: '.$e);//esto es para hacer un log
            return response()->json(['created' => false], 500);
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
            $Material=Materiales::findOrFail($id);
            return response()->json([
                'Material' => $Material
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
        try{
            $Material=Materiales::findOrFail($id);
            $Material->update($request->all());
            return response()->json(['update' => true]);
        } 
        catch(ModelNotFoundException $e){
            return response()->json(['update' => false], 500);
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
            $Material=Materiales::findOrFail($id);
            $Material->delete();
            return response()->json(['delete' => true]);
        } 
        catch(ModelNotFoundException $e){
            return response()->json(['delete' => false], 500);
        }
    }
}
