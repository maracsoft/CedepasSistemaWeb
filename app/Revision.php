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
    
    function parametros(){
        $cantNoRevisado=0;
        $contDisponible=0;
        $contNoHabido=0;
        $contDeteriorado=0;
        $contDonado=0;

        $detalles=RevisionDetalle::where('codRevision','=',$this->codRevision)->get();
        foreach ($detalles as $itemdetalle) {
            switch ($itemdetalle->codEstado) {
                case '0':
                    $cantNoRevisado++;
                    break;
                case '1':
                    $contDisponible++;
                    break;
                case '2':
                    $contNoHabido++;
                    break;
                case '3':
                    $contDeteriorado++;
                    break;
                case '4':
                    $contDonado++;
                    break;
            }
        }
        $total=$cantNoRevisado+$contDisponible+$contNoHabido+$contDeteriorado+$contDonado;

        $cantNoRevisado=(float)$cantNoRevisado/$total*100;
        $contDisponible=(float)$contDisponible/$total*100;
        $contNoHabido=(float)$contNoHabido/$total*100;
        $contDeteriorado=(float)$contDeteriorado/$total*100;
        $contDonado=(float)$contDonado/$total*100;

        return array($cantNoRevisado,$contDisponible,$contNoHabido,$contDeteriorado,$contDonado);
    }

    function seRevisoTodo(){
        
        foreach ($this->getDetalles() as $itemdetalle) {
            if($itemdetalle->seReviso==0){
                return 0;
            }
        }
        return 1;
    }
}
