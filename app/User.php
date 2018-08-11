<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'apellido','correo', 'usuario','clave','tipo',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'clave', 'remember_token',
    ];

    public function propiedades(){
        return $this->hasMany('App\Propiedades','user_id','id');
    }

    public function ordenCreador(){
        return $this->hasMany('App\Orden_servicios','creador_id','id');
    }
    public function ordenCancelador(){
        return $this->hasMany('App\Orden_servicios','cancelador_id','id');
    }


}
