<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado;
use App\GastoCaja;
use App\PeriodoCaja;
use App\Caja;
use App\CDP;
use App\Sede;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PeriodoCajaController extends Controller
{
    
    /* Vista de admin revisar UNA solicitud de reposicion*/
    public function verRevisarPeriodo($idPeriodo)
    {
        $periodo = PeriodoCaja::findOrFail($idPeriodo);
        $listaGastos = GastoCaja::where('codPeriodoCaja','=',$periodo->codPeriodoCaja)->get();


        return view('marsky.jefeAdmin.revisarPeriodo',compact('periodo','listaGastos'));
    }

    /* ACCION DE REPONER LA CAJA () */
    public function reponer($idPeriodo){
        try {
            DB::beginTransaction();

            $periodo = PeriodoCaja::findOrFail($idPeriodo); 
            $caja = Caja::findOrFail($periodo->codCaja);

            $periodo->codEstado = '3';  //marcar el periodo como finalizado (ya repuesto)
            $caja->montoActual = $caja->montoMaximo;

            $caja->save();
            $periodo->save();

            DB::commit();
            return redirect()->route('admin.listaPeriodos')->with('datos','¡Periodo finalizado y caja repuesta!');
        } catch (\Throwable $th) {
            error_log('HA OCURRIDO UN ERRO EN PERIODOCAJA CONTROLLER verRevisarPeriodo 
            
            
            '.$th.'

            ');

            db::rollBack();
            return redirect()->route('admin.listaPeriodos')->with('datos','Ha ocurrido un error.');
        }


    }



    /* Vista de admin ver listar periodos de las cajas chicas */
    public function listarPeriodosActuales()
    {
     
        //retorna la vista con la lista de todos los periodos en caja chica que aun no se hayan finalizado
        $empleado = Empleado::getEmpleadoLogeado();
        $listaSedes = Sede::all();
        $listaPeriodos = PeriodoCaja::orderBy('codEstado','ASC')->get(); //lista todos los periodos no finalizados
        
       /*  return $listaPeriodos; */

        return view('marsky.jefeAdmin.listarPeriodos',compact('listaPeriodos','listaSedes'));

    }


    /* RESPONSABLE -> VER SU CAJA CHICA (detalels de sus gastos) */
    public function verPeriodoCajaParaResp($idPeriodo)
    {

        if($idPeriodo=='-1')//si no tiene ningun 
            return redirect()->route('resp.listarMisPeriodos');

        $periodo = PeriodoCaja::findOrFail($idPeriodo);

        /* if($periodo->codEstado==3){
            return redirect()->route('resp.listarMisPeriodos')->with('datos','No tiene ningun periodo activo.');
        } */


        $listaGastos = GastoCaja::where('codPeriodoCaja','=',$periodo->codPeriodoCaja)->get();
           

        return view('marsky.cajaChicaResp.verPeriodo',compact('periodo','listaGastos'));
    }

    /* Registrar gasto  */
    public function verRegistrarGasto()
    {
        $empleado = Empleado::getEmpleadoLogeado();
        
        $listaPeriodos = PeriodoCaja::where('codEmpleadoCajero','=',$empleado->codEmpleado)
        ->where('codEstado','=','1')->get();

        $periodo = $listaPeriodos[0];
        $listaEmpleados = Empleado::orderby('apellidos','ASC')
        ->where('codEmpleado','!=','1')    
        ->get();
        $listaCDP = CDP::All();
        /* return $listaEmpleados; */
        return view('marsky.cajaChicaResp.registrar',compact('listaEmpleados','listaCDP','periodo'));
    }

    /* Liquidar la caja  */
    public function verLiquidar($id)
    {
        $periodo = PeriodoCaja::findOrFail($id);
        $listaGastos = GastoCaja::where('codPeriodoCaja','=',$periodo->codPeriodoCaja)->get();

        return view('marsky.cajaChicaResp.liquidar',compact('periodo','listaGastos'));
    }

    public function liquidar(Request $request){
        try {
            db::beginTransaction();
            $periodo = PeriodoCaja::findOrFail($request->codPeriodoCaja);
            $periodo->justificacion = $request->justificacion;
            $periodo->codEstado = '2';

            $periodo->fechaFinal = Carbon::now()->format('Y-m-d');
            

            $periodo->save();
            db::commit();

            return redirect()->route('resp.listarMisPeriodos')->with('datos','¡Caja Chica liquidada, queda a espera de reposición!');
        } catch (\Throwable $th) {
            error_log('HA OCURRIDO UN ERRO EN PERIODOCAJA CONTROLLER liquidar 
            
            
            '.$th.'

            ');

            db::rollBack();
        }

        

    }
/* VISTA DEL RESPONSABLE DE CC PARA VER SUS PERIODOS */
    public function listarMisPeriodos(){
        
        
        $empleado = Empleado::getEmpleadoLogeado(); 
        $listaPeriodos = PeriodoCaja::where('codEmpleadoCajero','=',$empleado->codEmpleado)
        ->orderBy('fechaInicio','DESC')
        ->get();
        $listaSedes = Sede::All();
        
        $caja = $empleado->getCaja();
        if($caja == '-1')
            return "Usted no es cajero de ninguna caja.";
       
        
        
        return view('marsky.cajaChicaResp.listarPeriodos',
                compact('empleado','listaPeriodos','listaSedes','caja'));

    }

    /* APERTURA NUEVO PERIODO, ES COMO EL STORE  */
    public function aperturarPeriodo(){ //aun no lo acabo
        
        try {
            DB::beginTransaction();
            $empleado = Empleado::getEmpleadoLogeado();

            $periodo = new PeriodoCaja();
            $periodo->fechaInicio = Carbon::now()->subDay(10)->format('Y-m-d');
            
            $caja = $empleado->getCaja();
            if($caja=='-1'){ //no es encargado de ninguna caja

            }

            $periodo->codCaja =  $caja->codCaja;
            $periodo->montoApertura = $caja->montoActual; 
            $periodo->montoFinal = $caja->montoActual;

            $periodo->codEmpleadoCajero = $empleado->codEmpleado;
            $periodo->codEstado='1';

            $periodo->save();

            DB::commit();
            return redirect()->route('resp.listarMisPeriodos')->with('datos','¡Periodo aperturado exitosamente!');

        } catch (\Throwable $th) {
            error_log('HA OCURRIDO UN ERRO EN PERIODOCAJA CONTROLLER AperturarPeriodo 
            
            
            '.$th.'

            ');

            db::rollBack();
        }
        

    }
}
