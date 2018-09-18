<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $fillable = [
        'nombre', 'direccion','user_id','tipo'
    ];



    public function user(){
        return $this->belongsToMany('App\User','Usuario_por_clientes','cliente_id','user_id');
    }

    public function ordenServicio(){
        return $this->hasMany('App\Orden_servicios','cliente_id','id');
    }

    public function solicitud(){
        return $this->hasMany('App\Solicitudes','cliente_id','id');
    }

    public function telefonos(){
        return $this->hasMany('App\Tlfns_cliente','cliente_id','id');
    }
}
