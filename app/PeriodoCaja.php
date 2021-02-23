<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\EstadoPeriodoCaja;
use App\Caja;
class PeriodoCaja extends Model
{
    
    protected $table = "periodo_caja";
    protected $primaryKey ="codPeriodoCaja";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['fechaInicio','fechaFinal','codCaja'
        ,'montoApertura','montoFinal','codEmpleadoCajero','justificacion',
            'codEstado'];
    

    public function cantidadGastos(){
        $i = 0;
        $lista = GastoCaja::where('codPeriodoCaja','=',$this->codPeriodoCaja)->get();
        return count($lista);
    }
    public function getSede(){
        
        $caja = Caja::findOrFail($this->codCaja);
        $sede = Sede::findOrFail($caja->codSede);
        return $sede;
    }

    //retorna al empleado responsable 
    public function getCajero(){
        $em = Empleado::findOrFail($this->codEmpleadoCajero);
        return $em;
    }
    public function getMontoSolicitado(){
        if($this->codEstado>1)
            return ($this->montoApertura)-($this->montoFinal);
        else
            return 'No solicitado.';

    }
    public function getNombreEstado(){

        $es = EstadoPeriodoCaja::findOrFail($this->codEstado);
        return $es->nombre;
    }


    public function getPorcentaje(){
        return round( 100- ($this->montoFinal/$this->montoApertura)*100,2);

    }
}
