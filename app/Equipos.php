<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    protected $fillable = [
        'descripcion', 'modelo'
    ];

    public function actividades(){
        return $this->belongsToMany('App\Actividades','equipos_por_actividad','equipos_id','actividad_id')->withPivot('cantidad');
    }
    public function fallas(){
        return $this->belongsToMany('App\Fallas','fallas_por_equipos','equipo_id','falla_id');
    }
}
