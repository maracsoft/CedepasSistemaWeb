<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    protected $table = "revision";
    protected $primaryKey ="codRevision";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['fechaHoraInicio','fechaHoraCierre','codEmpleadoResponsable','descripcion'];

    function getDetalles(){
        $detalles=RevisionDetalle::where('codRevision','=',$this->codRevision)->get();
        return $detalles;
    }

    function getResponsable(){
        $empleado=Empleado::find($this->codEmpleadoResponsable);
        return $empleado;
    }
}
