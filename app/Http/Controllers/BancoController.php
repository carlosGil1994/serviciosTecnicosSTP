<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bancos;

class BancoController extends Controller
{
    public function create(Request $request){
        $input = $request->input('TextValue');
        dd($input);
    }
}
