<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleGastoPlanilla extends Model
{
    protected $table = "detalle_gasto_planilla";
    protected $primaryKey ="codDetalleGastoPlanilla";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['sueldoContrato','costoDiario','diasVac','diasFalta','sueldoBrutoXTrabajar',

        'montoPagadoVacaciones','baseImpAntesDeFaltas','descFaltas','baseImponible','SNP',
            'aporteObligatorio','comisionMixta','primaSeguro','totalDesctos','netoAPagar'
            ,'codGastoPlanilla','codAFP'];
    
}
