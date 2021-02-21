<?php

namespace App;
use App\PeriodoCaja;
use Illuminate\Database\Eloquent\Model;

class GastoCaja extends Model
{
    protected $table = "gasto_caja";
    protected $primaryKey ="codGasto";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codPeriodoCaja','concepto','monto','codEmpleadoDestino'
        ,'codTipoCDP','terminacionArchivo','nroEnPeriodo','codigoPresupuestal'];
    

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
