<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = "caja";
    protected $primaryKey ="codCaja";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codProyecto','nombre','montoMaximo','montoActual','codEmpleadoCajeroActual'];
 
    public function getProyecto(){
        $proy = Proyecto::findOrFail($this->codProyecto);
        return $proy;
    }

    public function getEmpleadoActual(){
        $emp = Empleado::findOrFail($this->codEmpleadoCajeroActual);
        return $emp;

    }


    /*

     Si hay un periodo vigente, -> Gastadno
     Si se está esperando reposicion -> A espera de reponer
     Si ya se repuso -> Lista para iniciar periodo  

    */
    public function getEstado(){
        //OBTENEMOS EL ULTIMO PERIODO DE ESTA CAJA, PORQUE DE ESE DEPENDE
        $periodo = PeriodoCaja::where('codCaja','=',$this->codCaja)
        ->orderBy('codPeriodoCaja','DESC')
        ->first();
        
        $nombreEstado = '';
        switch ($periodo->codEstado) {
            case 1:
                $nombreEstado = "En proceso";
                break;
            case 2:
                $nombreEstado = "A espera de reposición";
                break;
            case 3:
                $nombreEstado = "Lista para iniciar periodo";
                break;
                
            default:
                # code...
                break;
        }

        return $nombreEstado;

    }
}
