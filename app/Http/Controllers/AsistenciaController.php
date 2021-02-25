<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\PeriodoEmpleado;
use App\Asistencia;
use App\Sede;
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
        //$asistencias=$contratos[0]->Asistencia;
        $asistencias= Asistencia::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->where('fecha','!=',date('y-m-d'))->get();
        foreach ($asistencias as $itemasistencia) {
            $itemasistencia->estado=2;
            $itemasistencia->save();
        }


        //CREAR UN NUEVO REGISTRO DE ASISTENCIA (para hoy)
        //$fecha=new Date();
        $evaluarAsistencias=Asistencia::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->where('fecha','=',date('y-m-d'))->get();
        $cont=0;
        foreach ($evaluarAsistencias as $item) {$cont+=1;}
        if ($cont==0) {
            //echo('entraaaaa');
            $asistencia=new Asistencia();
            $asistencia->codPeriodoEmpleado=$contratos[0]->codPeriodoEmpleado;
            $asistencia->estado=1;
            $asistencia->fecha=date('y-m-d');
            $asistencia->save();
        }


        $empleado=Empleado::find($id);
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$empleado->codEmpleado)->get();//agregar parametro que solo tome el contrato activo
        $asistencias=$contratos[0]->Asistencia;
        //$asistencias=Asistencia::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->where('fecha','=',date('y-m-d'))->get();
        return view('felix.GestionarAsistencias.indexEmpleado',compact('asistencias'));
    }

    public function marcar($id){
        date_default_timezone_set('America/Lima');
        $arr = explode('*', $id);
        $Asistencia=Asistencia::find($arr[0]);
        
        switch ($arr[1]) {
            case 1:
                $Asistencia->fechaHoraEntrada=new DateTime();
                //$Asistencia->fechaHoraEntrada->modify('-5 hours');
                break;
            case 2:
                $Asistencia->fechaHoraSalida=new DateTime();
                //$Asistencia->fechaHoraSalida->modify('-5 hours');
                # code...
                break;
            case 3:
                $Asistencia->fechaHoraEntrada2=new DateTime();
                //$Asistencia->fechaHoraEntrada2->modify('-5 hours');
                # code...
                break;
            case 4:
                $Asistencia->fechaHoraSalida2=new DateTime();
                //$Asistencia->fechaHoraSalida2->modify('-5 hours');
                # code...
                break;
        }
        $Asistencia->save();
        
        return redirect('/marcarAsistencia/'.$Asistencia->periodoEmpleado->empleado->codEmpleado);
    }


    /**PARA JEFES */
    public function listarAsistencia(){
        $empleados=Empleado::where('activo','=',1)->get();

        $empleados=DB::TABLE('empleado')
        ->JOIN('periodo_empleado', 'empleado.codEmpleado', '=', 'periodo_empleado.codEmpleado')
        ->SELECT('empleado.codEmpleado as codEmpleado', 'empleado.nombres as nombres',  
                    'empleado.apellidos as apellidos')
        ->where('periodo_empleado.activo','=',1)->orderBy('empleado.codEmpleado')->get();
        
        return view('felix.GestionarAsistencias.indexJefe',compact('empleados'));
    }

    
    public function filtroAsistencia(Request $request,$id){
        $arr = explode('*', $id);
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$arr[0])->where('activo','=',1)->get();
        $asistencias=Asistencia::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->get();

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



    public function exportarReporte($id){
        $empleados=DB::TABLE('empleado')
        ->JOIN('periodo_empleado', 'empleado.codEmpleado', '=', 'periodo_empleado.codEmpleado')
        ->SELECT('empleado.codEmpleado as codEmpleado', 'empleado.nombres as nombres',  
                    'empleado.apellidos as apellidos', 'periodo_empleado.codPuesto as codPuesto', 'periodo_empleado.codPuesto as codArea',
                    'periodo_empleado.codPuesto as cantAsistencias','periodo_empleado.codPuesto as contFaltas','periodo_empleado.codPuesto as contTardanzas')
        ->where('periodo_empleado.activo','=',1)->orderBy('empleado.codEmpleado')->get();

        foreach ($empleados as $itemempleado) {
            $itemempleado->codPuesto=app(Empleado::class)->getContratoHabil($itemempleado->codEmpleado)->puesto->nombre;
            $itemempleado->codArea=app(Empleado::class)->getContratoHabil($itemempleado->codEmpleado)->puesto->area->nombre;
            $itemempleado->cantAsistencias=app(Empleado::class)->getContratoHabil($itemempleado->codEmpleado)->parametros()[0];
            $itemempleado->contFaltas=app(Empleado::class)->getContratoHabil($itemempleado->codEmpleado)->parametros()[1];
            $itemempleado->contTardanzas=app(Empleado::class)->getContratoHabil($itemempleado->codEmpleado)->parametros()[2];
        }

        //Empleado::getContratoHabil($itemempleado->codEmpleado)->codTurno;
        $resultados=app(PeriodoEmpleado::class)->resultados();


        $pdf = \PDF::loadview('felix.GestionarAsistencias.reportePDF',array('empleados'=>$empleados,'resultados'=>$resultados))
                    ->setPaper('a4', 'portrait');
        return $pdf->download('asistenia.pdf');
    }
}
