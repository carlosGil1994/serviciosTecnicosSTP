<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Propiedades extends Model
{
    protected $fillable = [
        'nombre', 'apellido','user_id','correo', 'usuario','clave','tipo',
    ];



    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function ordenServicio(){
        return $this->hasMany('App\Orden_servicios','propiedad_id','id');
    }
}
