<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPeriodoCaja extends Model
{
    protected $table = "estado_periodo_caja";
    protected $primaryKey ="codEstado";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre'];
    
}
