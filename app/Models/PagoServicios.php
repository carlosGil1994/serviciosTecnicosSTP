<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoServicios extends Model
{
    protected $fillable = [
        'orden_servicio_id','pago_total', 'estado'
    ];

    public function ordenServicio(){
        return $this->belongsTo('App\Orden_servicios','orden_servicio_id','id');
     }
     public function compromabte(){
         return $this->hasMany('App\Comprobantes','pago_servicio_id','id');
     }
}
