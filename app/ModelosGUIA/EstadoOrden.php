<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoOrden extends Model
{
    protected $table = "estado_orden";
    protected $primaryKey ="codEstado";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre'];

}
