<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Declaracion extends Model
{
    protected $table = "declaracion";
    protected $primaryKey ="ingresos";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['gastos','gastoPlanilla','impuestos','fechaDeclaracion','codEmpleadoAutor','mesDeclarado'];
    
}
