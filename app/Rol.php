<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillabe = ['nombre', 'descripcion', 'condicion'];
    protected $timestamps = false;

    public function users(){
        return $this->hasMany('App\User');
    }
}
