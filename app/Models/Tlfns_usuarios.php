<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tlfns_usuarios extends Model
{
    protected $fillable = [
        'user_id', 'numero'
    ];
    public function user(){
        return $this->belongTo('App\User','user_id','id');
    }
}
