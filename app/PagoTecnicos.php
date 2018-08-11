<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoTecnicos extends Model
{
    protected $fillable = [
        'orden_servicio_id', 'pago'
    ];

    public function ordenServicio(){
        return $this->belongsTo('App\Orden_servicios','orden_servicio_id','id');
    }
}
