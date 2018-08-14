<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
    protected $fillable = [
        'servicio_id','problema','propiedad_id'
    ];

    public function propiedad(){
        return $this->belongsTo('App\Propiedades','propiedad_id','id');
    }

    public function servicio(){
        return $this->belongTo('App\Servicios','servicio_id','id');
    }
}
