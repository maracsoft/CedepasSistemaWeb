<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = "empleado";
    protected $primaryKey ="codEmpleado";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codTipoEmpleado','nombres','apellidos','telefono','fechaContrato','fechaFinContrato','activo'];
}
