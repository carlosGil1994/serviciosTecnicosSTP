<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    protected $fillable = [
        'servicio_id','problema','cliente_id'
    ];

    public function clientes(){
        return $this->belongsTo('App\Clientes','cliente_id','id');
    }

    public function servicio(){
        return $this->belongTo('App\Servicios','servicio_id','id');
    }
}
