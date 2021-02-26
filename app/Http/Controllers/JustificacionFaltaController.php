<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\PeriodoEmpleado;
use App\Justificacion;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JustificacionFaltaController extends Controller
{
    public function listarJustificaciones($id){
        $empleado=Empleado::find($id);
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$id)->where('activo','=',1)->get();
        $justificaciones=Justificacion::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->where('estado','!=',0)->get();
        return view('felix.GestionarJustificaciones.index',compact('justificaciones','empleado'));
    }

    public function crearJustificacion($id){
        $empleado=Empleado::find($id);
        //$tipos=TipoLicencia::all();
        return view('felix.GestionarJustificaciones.create',compact('empleado'));
    }

    public function guardarCrearJustificacion(Request $request){
        date_default_timezone_set('America/Lima');
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$request->codEmpleado)->where('activo','=',1)->get();

        $justificacion=new Justificacion();

        $justificacion->codPeriodoEmpleado=$contratos[0]->codPeriodoEmpleado;
        $justificacion->descripcion=$request->descripcion;
        $justificacion->estado=1;
        $justificacion->fechaHoraRegistro=new DateTime();

        $arr = explode('/', $request->fechaInicio);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];
        $justificacion->fechaInicio=$nFecha; 

        $arr = explode('/', $request->fechaFin);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];
        $justificacion->fechaFin=$nFecha; 
        $justificacion->documentoPrueba='';
        $justificacion->save();

        $justificacion->documentoPrueba= 'justificacion'.$justificacion->codRegistroJustificacion.'.pdf';


        $request->file('certificado')->storeAs('justificaciones',$justificacion->documentoPrueba);

        $justificacion->save();

        return redirect('/listarJustificaciones/'.$request->codEmpleado);
    }

    public function editarJustificacion($id){
        //$empleado=Empleado::find($id);
        $justificacion=Justificacion::find($id);

        $arr = explode('-', $justificacion->fechaInicio);
        $nFecha = $arr[0].'/'.$arr[1].'/'.$arr[2];
        $justificacion->fechaInicio=$nFecha;

        $arr = explode('-', $justificacion->fechaFin);
        $nFecha = $arr[0].'/'.$arr[1].'/'.$arr[2];
        $justificacion->fechaFin=$nFecha;

        return view('felix.GestionarJustificaciones.edit',compact('justificacion'));
    }

    public function guardarEditarJustificacion(Request $request){
        date_default_timezone_set('America/Lima');
        $justificacion=Justificacion::find($request->codRegistroJustificacion);

        
        $justificacion->descripcion=$request->descripcion;

        /*
        $arr = explode('/', $request->fechaInicio);
        $nFecha = $arr[0].'-'.$arr[1].'-'.$arr[2];
        $justificacion->fechaInicio=$nFecha; 

        $arr = explode('/', $request->fechaFin);
        $nFecha = $arr[0].'-'.$arr[1].'-'.$arr[2];
        $justificacion->fechaFin=$nFecha; 
        //$solicitud->documentoPrueba='';
        $justificacion->save();
        */
        $arr = explode('/', $request->fechaInicio);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];
        $justificacion->fechaInicio=$nFecha; 

        $arr = explode('/', $request->fechaFin);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];
        $justificacion->fechaFin=$nFecha; 
        //$justificacion->documentoPrueba='';
        $justificacion->save();

        //$solicitud->documentoPrueba= 'solicitud'.$solicitud->codRegistroSolicitud.'.pdf';
     
        if(!is_null($request->certificado)){
            Storage::disk('justificaciones')->delete($justificacion->documentoPrueba);
            $request->file('certificado')->storeAs('justificaciones',$justificacion->documentoPrueba);    
        }

        return redirect('/listarJustificaciones/'.$justificacion->periodoEmpleado->codEmpleado);
    }

    public function eliminarJustificacion($id){
        $justificacion=Justificacion::find($id);
        $justificacion->estado=0;
        $justificacion->save();
        return redirect('/listarJustificaciones/'.$justificacion->periodoEmpleado->codEmpleado);
    }

    public function mostrarAdjunto($id){
        /**para descargar */
        $justificacion=Justificacion::find($id);
        $pathtoFile = storage_path('app\justificaciones')."\\".$justificacion->documentoPrueba;
        return response()->download($pathtoFile);
    }

    /**PARA JEFES */
    public function listarJustificacionesJefe(){
        $empleados=DB::TABLE('empleado')
        ->JOIN('periodo_empleado', 'empleado.codEmpleado', '=', 'periodo_empleado.codEmpleado')
        ->SELECT('empleado.codEmpleado as codEmpleado', 'empleado.nombres as nombres',  
                    'empleado.apellidos as apellidos')
        ->where('periodo_empleado.activo','=',1)->orderBy('empleado.codEmpleado')->get();
        
        $justificaciones=Justificacion::where('estado','!=',0)->get();

        return view('felix.GestionarJustificaciones.indexJefe',compact('empleados','justificaciones'));
    }

    public function evaluarJustificacion($id){
        $arr = explode('*', $id);
        $justificacion=Justificacion::find($arr[0]);
        
        switch ($arr[1]) {
            case 1:
                $justificacion->estado=2;
                //$registroAsistencia->fechaHoraEntrada->modify('-5 hours');
                break;
            case 2:
                $justificacion->estado=3;
                //$registroAsistencia->fechaHoraSalida->modify('-5 hours');
                # code...
                break;
        }
        $justificacion->save();
        
        return redirect('/listarJustificacionesJefe');
    }
}
