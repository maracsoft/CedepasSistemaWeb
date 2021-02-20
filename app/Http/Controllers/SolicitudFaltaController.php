<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\PeriodoEmpleado;
use App\RegistroSolicitud;
use App\TipoLicencia;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SolicitudFaltaController extends Controller
{
    public function listarSolicitudes($id){
        $empleado=Empleado::find($id);
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$id)->where('activo','=',1)->get();
        $solicitudes=RegistroSolicitud::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->where('estado','!=',0)->get();
        return view('GestionarSolicitudes.index',compact('solicitudes','empleado'));
    }

    public function crearSolicitud($id){
        $empleado=Empleado::find($id);
        $tipos=TipoLicencia::all();
        return view('GestionarSolicitudes.create',compact('empleado','tipos'));
    }

    public function guardarCrearSolicitud(Request $request){
        date_default_timezone_set('America/Lima');
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$request->codEmpleado)->where('activo','=',1)->get();

        $solicitud=new RegistroSolicitud();

        $solicitud->codPeriodoEmpleado=$contratos[0]->codPeriodoEmpleado;
        $solicitud->descripcion=$request->descripcion;
        $solicitud->estado=1;
        $solicitud->fechaHoraRegistro=new DateTime();
        $solicitud->codTipoSolicitud=$request->codTipo;
        //$solicitud->documentoPrueba= 'tmr';

        //$certificado_archivo =$request->file('certificado');
        //$certificado = CertificadoCreado::where('iddocumento',$request->doc)->first();
        //Storage::disk('certificado')->delete($certificado->cer_archivo);
        //Storage::disk('certificado')->put($certificado->cer_archivo,\File::get($certificado_archivo));
        //Storage::put('solicitudes/',$certificado_archivo);


        $arr = explode('/', $request->fechaInicio);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];
        $solicitud->fechaInicio=$nFecha; 

        $arr = explode('/', $request->fechaFin);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];
        $solicitud->fechaFin=$nFecha; 
        $solicitud->documentoPrueba='';
        $solicitud->save();

        $solicitud->documentoPrueba= 'solicitud'.$solicitud->codRegistroSolicitud.'.pdf';

        $certificado_archivo =$request->file('certificado');
        /**para eliminar */
        //Storage::disk('solicitudes')->delete('6.pdf');
        /**para guardar */
        //Storage::disk('solicitudes')->put($solicitud->documentoPrueba,\File::get($certificado_archivo));
        $request->file('certificado')->storeAs('solicitudes',$solicitud->documentoPrueba);

        $solicitud->save();
        /**para descargar */
        //$pathtoFile = storage_path('app/solicitudes').'\\'.$solicitud->documentoPrueba;
        //return response()->download($pathtoFile);
        return redirect('/listarSolicitudes/'.$request->codEmpleado);
    }

    public function editarSolicitud($id){
        //$empleado=Empleado::find($id);
        $solicitud=RegistroSolicitud::find($id);
        $tipos=TipoLicencia::all();

        $arr = explode('-', $solicitud->fechaInicio);
        $nFecha = $arr[0].'/'.$arr[1].'/'.$arr[2];
        $solicitud->fechaInicio=$nFecha;

        $arr = explode('-', $solicitud->fechaFin);
        $nFecha = $arr[0].'/'.$arr[1].'/'.$arr[2];
        $solicitud->fechaFin=$nFecha;

        return view('GestionarSolicitudes.edit',compact('solicitud','tipos'));
    }


    public function guardarEditarSolicitud(Request $request){
        date_default_timezone_set('America/Lima');
        $solicitud=RegistroSolicitud::find($request->codRegistroSolicitud);

        
        $solicitud->descripcion=$request->descripcion;
        //$solicitud->estado=1;
        //$solicitud->fechaHoraRegistro=new DateTime();
        $solicitud->codTipoSolicitud=$request->codTipo;
        //$solicitud->documentoPrueba= 'tmr';

        //$certificado_archivo =$request->file('certificado');
        //$certificado = CertificadoCreado::where('iddocumento',$request->doc)->first();
        //Storage::disk('certificado')->delete($certificado->cer_archivo);
        //Storage::disk('certificado')->put($certificado->cer_archivo,\File::get($certificado_archivo));
        //Storage::put('solicitudes/',$certificado_archivo);


        $arr = explode('/', $request->fechaInicio);
        $nFecha = $arr[0].'-'.$arr[1].'-'.$arr[2];
        $solicitud->fechaInicio=$nFecha; 

        $arr = explode('/', $request->fechaFin);
        $nFecha = $arr[0].'-'.$arr[1].'-'.$arr[2];
        $solicitud->fechaFin=$nFecha; 
        //$solicitud->documentoPrueba='';
        $solicitud->save();

        //$solicitud->documentoPrueba= 'solicitud'.$solicitud->codRegistroSolicitud.'.pdf';
     
        if(!is_null($request->certificado)){
            Storage::disk('solicitudes')->delete($solicitud->documentoPrueba);
            $request->file('certificado')->storeAs('solicitudes',$solicitud->documentoPrueba);    
        }

        /**para eliminar */
        //Storage::disk('solicitudes')->delete('6.pdf');
        /**para guardar */
        //Storage::disk('solicitudes')->put($solicitud->documentoPrueba,\File::get($certificado_archivo));

        /**para descargar */
        //$pathtoFile = storage_path('app/solicitudes').'\\'.$solicitud->documentoPrueba;
        //return response()->download($pathtoFile);
        return redirect('/listarSolicitudes/'.$solicitud->periodoEmpleado->codEmpleado);
    }

    public function eliminarSolicitud($id){
        $solicitud=RegistroSolicitud::find($id);
        $solicitud->estado=0;
        $solicitud->save();
        return redirect('/listarSolicitudes/'.$solicitud->periodoEmpleado->codEmpleado);
    }

    public function mostrarAdjunto($id){
        date_default_timezone_set('America/Lima');
        /**para descargar */
        $solicitud=RegistroSolicitud::find($id);
        $pathtoFile = storage_path('app\solicitudes')."\\".$solicitud->documentoPrueba;
        return response()->download($pathtoFile);
    }

    /**PARA JEFES */
    public function listarSolicitudesJefe(){
        $empleados=DB::TABLE('empleado')
        ->JOIN('periodo_empleado', 'empleado.codEmpleado', '=', 'periodo_empleado.codEmpleado')
        ->SELECT('empleado.codEmpleado as codEmpleado', 'empleado.nombres as nombres',  
                    'empleado.apellidos as apellidos')
        ->where('periodo_empleado.activo','=',1)->orderBy('empleado.codEmpleado')->get();
        
        $solicitudes=RegistroSolicitud::where('estado','!=',0)->get();

        return view('GestionarSolicitudes.indexJefe',compact('empleados','solicitudes'));
    }

    public function evaluarSolicitud($id){
        $arr = explode('*', $id);
        $solicitud=RegistroSolicitud::find($arr[0]);
        
        switch ($arr[1]) {
            case 1:
                $solicitud->estado=2;
                //$registroAsistencia->fechaHoraEntrada->modify('-5 hours');
                break;
            case 2:
                $solicitud->estado=3;
                //$registroAsistencia->fechaHoraSalida->modify('-5 hours');
                # code...
                break;
        }
        $solicitud->save();
        
        return redirect('/listarSolicitudesJefe');
    }
}
