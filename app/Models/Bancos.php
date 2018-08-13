<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{
    protected $fillable = [
        'nombre'
    ];
    public function pagoServicios(){
        return $this->hasOne('App\PagoServicios','banco_id','id');
    }
}
