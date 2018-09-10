<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tlfns_cliente extends Model
{
    protected $fillable = [
        'numero','cliente_id'
    ];

    public function clientes(){
        return $this->belongTo('App\Clientes','cliente_id','id');
    }
}
