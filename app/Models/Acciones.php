<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acciones extends Model
{
    protected $fillable = [
        'nombre','costo'
    ];

    public function actividades(){
        return $this->hasMany('App\Actividades','accion_id','id');
    }
}
