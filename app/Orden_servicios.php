<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden_servicios extends Model
{
    //
    protected $fillable = [
        'propiedad_id','fecha_ini', 'fecha_fin','descripcion','estado', 'creador_id','cancelador_id','comentario','servicio_id'
    ];

    public function propiedades(){
       return $this->belongsTo('App\propiedades','propiedad_id');
    }

    public function servicio(){
        return $this->belongsTo('App\Servicio','servicio_id');
    }

    public function creador(){
        return $this->belongsTo('App\User','creador_id','id');
    }
    public function cancelador(){
        return $this->belongsTo('App\User','cancelador_id','id');
    }

    public function actividades(){
        return $this->hasMany('App\Actividades','orden_servicio_id','id');
    }

    public function pagoServicio(){
        return $this->hasMany('App\PagoServicios','orden_servicio_id','id');
    }

    public function pagoTecnico(){
        return $this->hasMany('App\PagoTecnicos','orden_servicio_id','id');
    }

}
