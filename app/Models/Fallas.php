<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fallas extends Model
{
    protected $fillable = [
        'descripcion', 'causa','solucion','equipo_id'
    ];

   public function actividades(){
        return $this->belongsToMany('App\Actividades','falla_por_actividades','falla_id','actividad_id');
    }
   /* public function equipos(){
        return $this->belongsToMany('App\Equipos','fallas_por_equipos','falla_id','equipo_id')->withPivot('actividad_id')->withTimestamps('created_at', 'updated_at');
    }*/
    public function equipos(){
        return $this->belongsTo('App\Equipos', 'equipo_id', 'id');
    }
}
