<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PeriodoEmpleado extends Model
{
    public $timestamps = false;

    protected $table = 'periodo_empleado';

    protected $primaryKey = 'codPeriodoEmpleado';

    protected $fillable = [
        'fechaInicio','fechaFin','fechaContrato','codTurno','codEmpleado','sueldoFijo','activo','valorPorHora','diasRestantes','codPuesto','codTipoContrato','nombreFinanciador','codAFP','asistencia','codProyecto','movito'
    ];

    public function turno(){//
        return $this->hasOne('App\Turno','codTurno','codTurno');//el tercer parametro es de Producto
    }

    public function empleado(){//
        return $this->hasOne('App\Empleado','codEmpleado','codEmpleado');//el tercer parametro es de Producto
    }

    public function puesto(){//
        return $this->hasOne('App\Puesto','codPuesto','codPuesto');//el tercer parametro es de Producto
    }

    public function tipoContrato(){//
        return $this->hasOne('App\TipoContrato','codTipoContrato','codTipoContrato');//el tercer parametro es de Producto
    }

    public function Asistencia(){//
        return $this->hasMany('App\Asistencia','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }

    public function SolicitudFalta(){//
        return $this->hasMany('App\SolicitudFalta','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }

    public function avances(){//
        return $this->hasMany('App\AvanceEntregable','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }

    public function proyecto(){//
        return Proyecto::find($this->codProyecto);
    }

    public function parametros(){
        $constante=(int)30;


        $asistencias=Asistencia::where('codPeriodoEmpleado','=',$this->codPeriodoEmpleado)->get();
        $contTotal=0;
        $contAsistencias=0;
        $contTardanzas=0;

        foreach ($asistencias as $itemasistencia) {
            if(!is_null($itemasistencia->fechaHoraEntrada)){
                    $horaEntrada=date('H:i', strtotime($itemasistencia->periodoEmpleado->turno->horaInicio));
                    $horaQueLlego=date('H:i', strtotime($itemasistencia->fechaHoraEntrada));

                    $horaInicio = new DateTime($horaEntrada);
                    $horaTermino = new DateTime($horaQueLlego);

                    $interval = $horaInicio->diff($horaTermino);
                    $totalMinutos=($interval->d * 24 * 60) + ($interval->h * 60) + $interval->i;
                    //if($horaEntrada<$horaQueLlego){
                    if($totalMinutos>$constante){
                        $contTardanzas++;
                    }

                $contAsistencias++;
            }
            if(!is_null($itemasistencia->fechaHoraEntrada2)){
                $horaEntrada=date('H:i', strtotime($itemasistencia->periodoEmpleado->turno->horaInicio2));
                $horaQueLlego=date('H:i', strtotime($itemasistencia->fechaHoraEntrada2));

                $horaInicio = new DateTime($horaEntrada);
                $horaTermino = new DateTime($horaQueLlego);

                $interval = $horaInicio->diff($horaTermino);
                $totalMinutos=($interval->d * 24 * 60) + ($interval->h * 60) + $interval->i;
                //if($horaEntrada<$horaQueLlego){
                if($totalMinutos>$constante){
                    $contTardanzas++;
                }

                $contAsistencias++;
            }

            if($itemasistencia->periodoEmpleado->turno->codTipoTurno==3){
                $contTotal+=2;
            }else{
                $contTotal+=1;
            }
            
        }

        $contTardanzas=(float)$contTardanzas/$contAsistencias*100;
        $contAsistencias=(float)$contAsistencias/$contTotal*100;
        $contFaltas=100-$contAsistencias;
        

        return array($contAsistencias,$contFaltas,$contTardanzas);
    }

    public function resultados(){

        $contFaltas=0;
        $contTardanzas=0;

        $empleados=DB::TABLE('empleado')
        ->JOIN('periodo_empleado', 'empleado.codEmpleado', '=', 'periodo_empleado.codEmpleado')
        ->SELECT('empleado.codEmpleado as codEmpleado','periodo_empleado.codPeriodoEmpleado as codPeriodoEmpleado')
        ->where('periodo_empleado.activo','=',1)->get();

        foreach ($empleados as $itemempleado) {
            $contrato=PeriodoEmpleado::find($itemempleado->codPeriodoEmpleado);
            $array=$contrato->parametros();
            if($array[1]>15){
                $contFaltas++;
            }
            if($array[2]>15){
                $contTardanzas++;
            }
        }

        $contFaltas=$contFaltas/count($empleados)*100;
        $contTardanzas=$contTardanzas/count($empleados)*100;

        return array($contFaltas,$contTardanzas);
    }
}
