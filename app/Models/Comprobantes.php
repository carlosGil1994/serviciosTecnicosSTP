<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobantes extends Model
{
    protected $fillable = [
        'pago_servicio_id','fecha_pago','pago_parcial','banco_id','num_recibo','estado','pago_tecnicos_id'
    ];

    public function pagoSservicio(){
        return $this->belongsTo('App\PagoServicios','pago_servicio_id','id');
    }
    public function banco(){
        return $this->belongsTo('App\Bancos','banco_id','id');
    }
}
