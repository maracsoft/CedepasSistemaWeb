<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = "caja";
    protected $primaryKey ="codCaja";

  

    // le indicamos los campos de la tabla 
    protected $fillable = ['codSede','montoMaximo','montoActual'];
    
}
