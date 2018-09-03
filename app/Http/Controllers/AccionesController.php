<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Acciones;

class AccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Acciones::all();
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
            'nombre'=> 'required|unique:acciones',
            'costo'=>'required'
        ];
        try{
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ]);
            }
            $accion= Acciones::create([$request->all()]);
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
            $accion=Acciones::findOrFail($id);
            return response()->json([
                'Acciones' => $accion
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
            'nombre'=> 'required|unique:acciones',
            'costo'=>'required'
        ];
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ]);
             }
        try{
            $accion = Acciones::findOrFail($request->id)->update($request->all());
            return response()->json(['create' => true], 200);
        } 
        catch(Exeption $e){
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
            $accion = Acciones::findOrFail($request->id)->delete();
            return response()->json(['delete' => true], 200);
        }
        catch(Exeption $e){
            return response()->json(['delete' => false,"mensaje"=>$e->getMessage()], 404);
        }
    }
}
