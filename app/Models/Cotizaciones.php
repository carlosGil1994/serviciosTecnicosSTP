<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizaciones extends Model
{
    protected $fillable = [
        'orden_servicio_id','fecha_creacion','path'
    ];
}
