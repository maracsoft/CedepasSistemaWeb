<?php

namespace App\Http\Controllers;

use App\AFP;
use App\Area;
use App\AvanceEntregable;
use App\Empleado;
use App\PeriodoEmpleado;
use App\Puesto;
use App\SueldoMes;
use App\TipoTurno;
use App\Turno;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Barryvdh\DomPDF\Facade as PDF;
use App\Proyecto;

class PeriodoEmpleadoController extends Controller
{
    public function listarContratos($id){
        
        $empleado=Empleado::find($id);
        //$contratos=$empleado->periodoEmpleado;
        $contratos=PeriodoEmpleado::where('activo','!=',0)->where('codEmpleado','=',$empleado->codEmpleado)->get();

        $cont=0;
        foreach ($contratos as $itemcontrato) {
            if($itemcontrato->activo==1) $cont=1;
        }
        //echo($cont);
        
        return view('felix.GestionarEmpleados.indexContrato',compact('empleado','contratos','cont'));
    }

    public function crearContrato($id){
        $arr = explode('*', $id);
        //$turnos=Turno::all();
        $empleado=Empleado::find($arr[0]);
        $tipoContrato=$arr[1];
        $areas=Area::all();
        $AFPS=AFP::all();
        $proyectos = Proyecto::getProyectosActivos();
        return view('felix.GestionarEmpleados.createContrato',
        compact('empleado','tipoContrato','areas','AFPS','proyectos'));
        
    }

    public function guardarCrearContrato(Request $request){
        date_default_timezone_set('America/Lima');
        $contrato=new PeriodoEmpleado();

        $arr = explode('/', $request->fechaInicio);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];
        $fechainicialF = new DateTime($arr[0].'-'.$arr[1].'-'.$arr[2]);     
        $contrato->fechaInicio=$nFecha; 

        if($request->fechaFin!=null && $request->fechaFin!=""){
            $arr = explode('/', $request->fechaFin);
            $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];
            $fechafinalF = new DateTime($arr[0].'-'.$arr[1].'-'.$arr[2]);
            $contrato->fechaFin=$nFecha; 
        }else{
            $contrato->fechaFin=null;
        }

        $contrato->fechaContrato=date('y-m-d');
        $contrato->codTurno=$request->codTurno;
        $contrato->codEmpleado=$request->codEmpleado;
        $contrato->sueldoFijo=$request->sueldo;

            $cont=0;
            $contratos=PeriodoEmpleado::where('codEmpleado','=',$request->codEmpleado)->get();
            foreach ($contratos as $zzz) {
                if($zzz->activo==1){
                    $cont+=1;
                }
            }
        if($cont==0){
            $contrato->activo=1;
        }
        else{
            $contrato->activo=3;   
        }
        $contrato->valorPorHora=3;
        $contrato->diasRestantes=30;
        
        $contrato->codTipoContrato=$request->codTipoContrato;

        if($request->codTipoContrato==1){
            
            $contrato->nombreFinanciador=$request->nombreFinanciador;
            $contrato->codPuesto=$request->codPuesto;
            $contrato->codProyecto=$request->codProyecto;
            $contrato->motivo=null;
            $contrato->codAFP=$request->codAFP;
            $contrato->asistencia=$request->asistencia;
        }
        if($request->codTipoContrato==2){//por locacion
            $contrato->nombreFinanciador=null;
            $contrato->codPuesto=null;
            $contrato->codProyecto=null;
            $contrato->motivo=$request->motivo;
            $contrato->codAFP=null;
            $contrato->asistencia=0;
        }
        
        
        $contrato->save();
        
        //CALCULO DE SUELDOS MENSUALES(tabla sueldo_mes)
        $fechainicial=$contrato->fechaInicio;
        $fechafinal=$contrato->fechaFin;

        //$fechainicialF = new DateTime('2012-01-01');
        //$fechafinalF = new DateTime('2013-01-01');
        if($contrato->fechaFin!=null){
            $diferencia = $fechainicialF->diff($fechafinalF);//tienen que ser del tipo DateTime
            $meses = ( $diferencia->y * 12 ) + $diferencia->m;
        }else{
            $meses=12;
        }
        
        if($request->codTipoContrato==1){
            for ($i=0; $i < $meses; $i++) {
                //date_add($fechainicial, date_interval_create_from_date_string("1 month"));
                
                $sueldo=new SueldoMes();
                $sueldo->codPeriodoEmpleado=$contrato->codPeriodoEmpleado;
                $arr = explode('-', $fechainicial);
                //$sueldo->anio=date("Y", $fechainicial);
                //$sueldo->mes=date("m", $fechainicial);
                $sueldo->anio=$arr[0];
                $sueldo->mes=$arr[1];
                $sueldo->diaInicio=$arr[2];

                //cuando el contrato no tiene fin los pagos ingresados son mensuales
                if($contrato->fechaFin!=null){
                    //$sueldo->sueldoMensual=($contrato->sueldoFijo)/$meses;
                    $sueldo->sueldoMensual=$contrato->sueldoFijo;
                }else{
                    $sueldo->sueldoMensual=$contrato->sueldoFijo;
                }

                //$sueldo->sueldoMensual=($contrato->sueldoFijo)/$meses;
                $sueldo->save();
                $fechainicial=date("Y-m-d",strtotime($fechainicial."+ 1 month"));
            }
        }
        if($request->codTipoContrato==2){
            $descripciones = $request->get('descripcion');
            $fechas = $request->get('fecha');
            $porcentajes = $request->get('porcentaje');            

            $cont = 0;

            while ($cont<count($descripciones)) {
                $detalle=new AvanceEntregable();
                $detalle->descripcion=$descripciones[$cont];

                $arr = explode('/', $fechas[$cont]);
                $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];
                $detalle->fechaEntrega=$nFecha;

                $detalle->porcentaje=$porcentajes[$cont];
                $detalle->monto=((int)$detalle->porcentaje)*((int)$contrato->sueldoFijo)/100;                
                $detalle->codPeriodoEmpleado=$contrato->codPeriodoEmpleado;
                $detalle->save();                     
                $cont=$cont+1;
            }  
        }
        
        return redirect('/listarEmpleados/listarContratos/'.$request->codEmpleado);
    }










    public function editarContrato($id){
        $contrato=PeriodoEmpleado::find($id);
        //$turnos=Turno::all();
        $areas=Area::all();
        $AFPS=AFP::all();
        $puesto=$contrato->puesto;
        $area=$contrato->puesto->area;
        $puestos=Puesto::where('codArea','=',$area->codArea)->get();
        return view('felix.GestionarEmpleados.editContrato',compact('contrato','areas','AFPS','puestos'));
    }









    public function guardarEditarContrato(Request $request){
        $contrato=PeriodoEmpleado::find($request->codPeriodoEmpleado);;

        $arr = explode('/', $request->fechaInicio);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];   
        $contrato->fechaInicio=$nFecha; 

        $arr = explode('/', $request->fechaFin);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        $contrato->fechaFin=$nFecha; 

        $contrato->codTurno=$request->codTurno;
        //$contrato->codEmpleado=$request->codEmpleado;
        if ($contrato->sueldoFijo!=$request->sueldo) {
            
        }
        $contrato->sueldoFijo=$request->sueldo;

        //$contrato->activo=1;
        //$contrato->valorPorHora=3;
        //$contrato->diasRestantes=30;
        if($contrato->codTipoContrato==1){
            //$contrato->nombreFinanciador=null;
            $contrato->codPuesto=$request->codPuesto;
        }
        if($contrato->codTipoContrato==2){
            $contrato->nombreFinanciador=$request->nombreFinanciador;
            //$contrato->codPuesto=null;
        }
        $contrato->codAFP=$request->codAFP;
        $contrato->asistencia=$request->asistencia;

        $contrato->save();

        return redirect('/listarEmpleados/listarContratos/'.$contrato->empleado->codEmpleado);
    }//NOSE SI SE UTILIZARA :V










    public function eliminarContrato($id){
        $contrato=PeriodoEmpleado::find($id);
        $contrato->activo=0;
        $contrato->save();
        return redirect('/listarEmpleados/listarContratos/'.$contrato->empleado->codEmpleado);
    
    }









    /**HORARIO */
    public function crearHorario($id){
        $contrato=PeriodoEmpleado::find($id);
        $tiposTurno=TipoTurno::all();
        return view('felix.GestionarEmpleados.createHorario',compact('tiposTurno','contrato'));
    }










    public function guardarCrearHorario(Request $request){
        $turno=new Turno();
        switch ($request->codTipoTurno) {
            case 1:
                $turno->horaInicio=$request->horaInicioInput;
                $turno->horaFin=$request->horaFinInput;
                //var_dump($request->horaInicio1);
                break;
            case 2:
                $turno->horaInicio2=$request->horaInicio2Input;
                $turno->horaFin2=$request->horaFin2Input;
                # code...
                break;
            case 3:
                $turno->horaInicio=$request->horaInicioInput;
                $turno->horaFin=$request->horaFinInput;
                $turno->horaInicio2=$request->horaInicio2Input;
                $turno->horaFin2=$request->horaFin2Input;
                break;
        }
        $turno->codTipoTurno=$request->codTipoTurno;
        $turno->save();
        $contrato=PeriodoEmpleado::find($request->codPeriodoEmpleado);
        $contrato->codTurno=$turno->codTurno;
        $contrato->save();
        return redirect('/listarEmpleados/listarContratos/'.$contrato->codEmpleado);
    }

    public function editarHorario($id){
        $contrato=PeriodoEmpleado::find($id);
        $turno=$contrato->turno;
        $tiposTurno=TipoTurno::all();
        return view('felix.GestionarEmpleados.editHorario',compact('turno','tiposTurno'));
    }

    public function guardarEditarHorario(Request $request){
        $turno=Turno::find($request->codTurno);
        $turno->horaInicio=null;
        $turno->horaFin=null;
        $turno->horaInicio2=null;
        $turno->horaFin2=null;
        switch ($request->codTipoTurno) {
            case 1:
                $turno->horaInicio=$request->horaInicioInput;
                $turno->horaFin=$request->horaFinInput;
                //var_dump($request->horaInicio1);
                break;
            case 2:
                $turno->horaInicio2=$request->horaInicio2Input;
                $turno->horaFin2=$request->horaFin2Input;
                # code...
                break;
            case 3:
                $turno->horaInicio=$request->horaInicioInput;
                $turno->horaFin=$request->horaFinInput;
                $turno->horaInicio2=$request->horaInicio2Input;
                $turno->horaFin2=$request->horaFin2Input;
                break;
        }
        $turno->codTipoTurno=$request->codTipoTurno;
        $turno->save();
        $contrato=PeriodoEmpleado::find($request->codPeriodoEmpleado);
        return redirect('/listarEmpleados/listarContratos/'.$turno->periodoEmpleado->codEmpleado);
    }

    public function exportarContrato($id){//para matrices ya registradas
        $contrato=PeriodoEmpleado::find($id);

        if($contrato->codTipoContrato==1){
            $pdf = \PDF::loadview('felix.GestionarEmpleados.contratoPlazoPDF',array('contrato'=>$contrato))->setPaper('a4', 'portrait');
        }else{
            $pdf = \PDF::loadview('felix.GestionarEmpleados.contratoLocacionPDF',array('contrato'=>$contrato))->setPaper('a4', 'portrait');
        }

        
        return $pdf->download('contrato-'.$contrato->codPeriodoEmpleado.'.pdf');
    }
    /*
    public function generarCDP($id){
        date_default_timezone_set('America/Lima');
        $pdf = \PDF::loadView('modulos.caja.CDP');
        $pdf->setPaper(array(0, 0, 301, 623.622), 'portrait');
        //$pdf->set_option('defaultFont', 'Courier');
        
        
        //var_dump($data[0]->elementos->descripcionElemento);

        //return $pdf->download('dinamicoV1.pdf');
        return $pdf->stream();
    }
    */
}
