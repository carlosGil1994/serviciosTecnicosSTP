<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    protected $fillable = [
        'orden_servicio_id','accion_id', 'horas','fechaCreacion','estado'
    ];

    public function ordenServicio(){
        return $this->belongsTo('App\Orden_servicios','orden_servicio_id');
    }

    public function accion(){
        return $this->belongsTo('App\Acciones','accion_id');
    }

    public function equipos(){
        return $this->belongsToMany('App\Equipos','equipos_por_actividad','actividad_id','equipo_id')->withPivot('cantidad');
    }

    public function materiales(){
        return $this->belongsToMany('App\Materiales','materiales_por_actividad','actividad_id','material_id')->withPivot('cantidad','metros');
    }

    /*public function fallas(){
        return $this->belongsToMany('App\Fallas','falla_por_actividades','actividad_id','falla_id');
    }*/
    public function fallas(){
        return $this->hasMany('App\Fallas', 'actividad_id', 'id');
    }
    
}
