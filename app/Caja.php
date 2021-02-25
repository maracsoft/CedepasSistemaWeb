<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = "caja";
    protected $primaryKey ="codCaja";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codProyecto','nombre','montoMaximo',
        'montoActual','codEmpleadoCajeroActual','activa'];
 
    public function getProyecto(){
        $proy = Proyecto::findOrFail($this->codProyecto);
        return $proy;
    }

    public function getEmpleadoActual(){
        $emp = Empleado::findOrFail($this->codEmpleadoCajeroActual);
        return $emp;

    }


    public function getEstadoActivo(){
        if($this->activa=='1')
            return "Activa"; //el proyecto sigue vigente
        else
            return "De baja"; //ya no es necesaria la CC porque el proyecto ya acabo

    }

    public function tienePeriodoEnProceso(){
        $periodo = PeriodoCaja::where('codCaja','=',$this->codCaja)
        ->orderBy('codPeriodoCaja','DESC')
        ->first();

        if(is_null($periodo)) //si no tiene ningun periodo aun
            return '0';

        if($periodo->codEstado==3){ //lista para iniciar otro periodo (el anterior fue finalizado)
            return '0';
        }

        return '1';

    }


    public static function getCajasActivas(){
        $lista = Caja::where('activa','=','1')->get();
        return $lista;
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

        if($this->activa==0) return "";

        $nombreEstado = '';
        
        if(is_null($periodo)){//si no tiene ningun periodo
            return "Lista para iniciar periodo";
        }

        
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
