<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tlfns_propiedades extends Model
{
    protected $fillable = [
        'numero','propiedad_id'
    ];

    public function propiedad(){
        return $this->belongTo('App\Propiedades','propiedad_id','id');
    }
}
