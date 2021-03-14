<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReposicionGastos extends Model
{
    protected $table = "reposicion_gastos";
    protected $primaryKey ="codReposicionGastos";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codEstadoReposicion','codEmpleadoSolicitante','codEmpleadoEvaluador',
    'codProyecto','codMoneda',
    'fechaEmision','codigoCedepas','girarAOrdenDe','codBanco','resumen','fechaHoraRevisionGerente','fechaHoraRevisionAdmin','observacion'];
}
