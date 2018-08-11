<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $fillable = [
        'descripcion'
    ];

    public function ordenServicio(){
        return $this->hasOne('App\Orden_servicios','servicio_id','id');
    }
}
