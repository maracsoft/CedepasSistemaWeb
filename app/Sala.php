<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = "sala";
    protected $primaryKey ="codSala";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre'];

    public function mesa(){
        return $this->hasMany('App\Mesa','codSala','codSala');

    }
}
