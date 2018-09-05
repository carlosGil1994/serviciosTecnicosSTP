<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propiedades extends Model
{
    protected $fillable = [
        'nombre', 'direccion','user_id',
    ];



    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function ordenServicio(){
        return $this->hasMany('App\Orden_servicios','propiedad_id','id');
    }

    public function solicitud(){
        return $this->hasMany('App\Solicitudes','propiedad_id','id');
    }

    public function telefonos(){
        return $this->hasMany('App\Tlfns_propiedades','propiedad_id','id');
    }
}
