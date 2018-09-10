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
        'name','direccion', 'apellido','email', 'usuario','password','tipo',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function clientes(){
        return $this->belongsToMany('App\Clientes','Usuario_por_clientes','user_id','cliente_id');
    }

    public function ordenCreador(){
        return $this->hasMany('App\Orden_servicios','creador_id','id');
    }
    public function ordenCancelador(){
        return $this->hasMany('App\Orden_servicios','cancelador_id','id');
    }
    public function especialidades(){
        return $this->belongsToMany('App\Servicios','Especialidades','user_id','servicio_id');
    }

    public function telefonos(){
        return $this->hasMany('App\Tlfns_usuarios','user_id','id');
    }




}
