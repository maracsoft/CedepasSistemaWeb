<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RendicionGastos extends Model
{
    protected $table = "rendicion_gastos";
    protected $primaryKey ="codRendicionGastos";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codSolicitud','codigoCedepas','totalImporteRecibido',
    'totalImporteRendido','saldoAFavorDeEmpleado',
    'resumenDeActividad','estadoDeReposicion'];


}
