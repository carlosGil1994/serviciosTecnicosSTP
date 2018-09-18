<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden_servicios extends Model
{
    //
    protected $fillable = [
        'cliente_id','fecha_ini', 'fecha_fin','descripcion','estado', 'creador_id','cancelador_id','comentario','servicio_id','tecnico_id'
    ];

    public function clientes(){
       return $this->belongsTo('App\Clientes','cliente_id');
    }

    public function servicio(){
        return $this->belongsTo('App\Servicios','servicio_id');
    }

    public function creador(){
        return $this->belongsTo('App\User','creador_id','id');
    }
    public function tecnico(){
        return $this->belongsTo('App\User','tecnico_id','id');
    }
    public function cancelador(){
        return $this->belongsTo('App\User','cancelador_id','id');
    }

    public function actividades(){
        return $this->hasMany('App\Actividades','orden_servicio_id','id');
    }

    public function pagoServicio(){
        return $this->hasOne('App\PagoServicios','orden_servicio_id','id');
    }

    public function pagoTecnico(){
        return $this->hasMany('App\PagoTecnicos','orden_servicio_id','id');
    }
    public function cotizaciones(){
        return $this->hasMany('App\Cotizaciones','orden_servicio_id','id');
    }


}
