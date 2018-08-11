<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fallas extends Model
{
    protected $fillable = [
        'descripcion', 'causa','solucion'
    ];

    public function actividades(){
        return $this->belongsToMany('App\Actividades','falla_por_actividades','falla_id','actividad_id')->withPivot('equipo_id');
    }
    public function equipos(){
        return $this->belongsToMany('App\Equipos','fallas_por_equipos','falla_id','equipo_id');
    }
}
