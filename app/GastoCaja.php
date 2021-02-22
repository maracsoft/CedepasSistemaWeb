<?php

namespace App;
use App\PeriodoCaja;
use Illuminate\Database\Eloquent\Model;

class GastoCaja extends Model
{
    protected $table = "gasto_caja";
    protected $primaryKey ="codGastoPeriodo";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codPeriodoCaja','fechaComprobante','concepto','monto','codEmpleadoDestino'
        ,'codTipoCDP','terminacionArchivo','nroEnPeriodo','codigoPresupuestal','nroCDP'];
    

    public function getNombreCajero(){
        $periodo = PeriodoCaja::findOrFail($this->codPeriodoCaja);
        return $periodo->getCajero()->nombre;
    }
    public function getNombreEmpleadoDestino(){
        $emp =Empleado::findOrFail($this->codEmpleadoDestino);
        return $emp->getNombreCompleto();

    }

    public function getNombreTipoCDP(){
        $cdp = CDP::findOrFail($this->codTipoCDP);
        return $cdp->nombreCDP;
    }

}
