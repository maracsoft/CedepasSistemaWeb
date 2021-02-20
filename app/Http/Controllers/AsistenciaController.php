<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\PeriodoEmpleado;
use App\RegistroAsistencia;
use App\Turno;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class AsistenciaController extends Controller
{
    /**PARA EMPLEADOS */
    public function marcarAsistencia($id){
        date_default_timezone_set('America/Lima');


        $empleado=Empleado::find($id);
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$empleado->codEmpleado)->where('activo','=',1)->get();//agregar parametro que solo tome el contrato activo
        //$asistencias=$contratos[0]->registroAsistencia;
        $asistencias=RegistroAsistencia::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->where('fecha','!=',date('y-m-d'))->get();
        foreach ($asistencias as $itemasistencia) {
            $itemasistencia->estado=2;
            $itemasistencia->save();
        }


        //CREAR UN NUEVO REGISTRO DE ASISTENCIA (para hoy)
        //$fecha=new Date();
        $evaluarAsistencias=RegistroAsistencia::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->where('fecha','=',date('y-m-d'))->get();
        $cont=0;
        foreach ($evaluarAsistencias as $item) {$cont+=1;}
        if ($cont==0) {
            //echo('entraaaaa');
            $asistencia=new RegistroAsistencia();
            $asistencia->codPeriodoEmpleado=$contratos[0]->codPeriodoEmpleado;
            $asistencia->estado=1;
            $asistencia->fecha=date('y-m-d');
            $asistencia->save();
        }


        $empleado=Empleado::find($id);
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$empleado->codEmpleado)->get();//agregar parametro que solo tome el contrato activo
        $asistencias=$contratos[0]->registroAsistencia;
        //$asistencias=RegistroAsistencia::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->where('fecha','=',date('y-m-d'))->get();
        return view('GestionarAsistencias.indexEmpleado',compact('asistencias'));
    }

    public function marcar($id){
        date_default_timezone_set('America/Lima');
        $arr = explode('*', $id);
        $registroAsistencia=RegistroAsistencia::find($arr[0]);
        
        switch ($arr[1]) {
            case 1:
                $registroAsistencia->fechaHoraEntrada=new DateTime();
                //$registroAsistencia->fechaHoraEntrada->modify('-5 hours');
                break;
            case 2:
                $registroAsistencia->fechaHoraSalida=new DateTime();
                //$registroAsistencia->fechaHoraSalida->modify('-5 hours');
                # code...
                break;
            case 3:
                $registroAsistencia->fechaHoraEntrada2=new DateTime();
                //$registroAsistencia->fechaHoraEntrada2->modify('-5 hours');
                # code...
                break;
            case 4:
                $registroAsistencia->fechaHoraSalida2=new DateTime();
                //$registroAsistencia->fechaHoraSalida2->modify('-5 hours');
                # code...
                break;
        }
        $registroAsistencia->save();
        
        return redirect('/marcarAsistencia/'.$registroAsistencia->periodoEmpleado->empleado->codEmpleado);
    }


    /**PARA JEFES */
    public function listarAsistencia(){
        $empleados=Empleado::where('activo','=',1)->get();

        $empleados=DB::TABLE('empleado')
        ->JOIN('periodo_empleado', 'empleado.codEmpleado', '=', 'periodo_empleado.codEmpleado')
        ->SELECT('empleado.codEmpleado as codEmpleado', 'empleado.nombres as nombres',  
                    'empleado.apellidos as apellidos')
        ->where('periodo_empleado.activo','=',1)->orderBy('empleado.codEmpleado')->get();
        
        return view('GestionarAsistencias.indexJefe',compact('empleados'));
    }

    public function filtroAsistencia(Request $request,$id){
        $arr = explode('*', $id);
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$arr[0])->where('activo','=',1)->get();
        $asistencias=RegistroAsistencia::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->get();

        foreach ($asistencias as $item) {
            if(!is_null($item->fechaHoraEntrada)) $item->fechaHoraEntrada=date('H:i:s', strtotime($item->fechaHoraEntrada));
            if(!is_null($item->fechaHoraSalida)) $item->fechaHoraSalida=date('H:i:s', strtotime($item->fechaHoraSalida));
            if(!is_null($item->fechaHoraEntrada2)) $item->fechaHoraEntrada2=date('H:i:s', strtotime($item->fechaHoraEntrada2));
            if(!is_null($item->fechaHoraSalida2)) $item->fechaHoraSalida2=date('H:i:s', strtotime($item->fechaHoraSalida2));
        }
        $turno=$contratos[0]->turno;
        $tipoTurno=$turno->tipoTurno;
        //$empleados=Empleado::all();
        
        return response()->json(['asistencias'=>$asistencias,'numero'=>$arr[1],'turno'=>$turno,'tipoTurno'=>$tipoTurno]);
    }
}
