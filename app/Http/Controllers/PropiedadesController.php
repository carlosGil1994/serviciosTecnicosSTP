<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Propiedades;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PropiedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'nombre'=> 'required|unique:propiedades',
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
            $propiead = User::findOrFail($request->user_id)->propiedades()->create($request->all());
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
