<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado;
use App\GastoCaja;
use App\PeriodoCaja;
use App\Caja;
use App\CDP;
use Illuminate\Support\Facades\DB;

class PeriodoCajaController extends Controller
{
    
    /* Vista de admin revisar solicitud de reposicion*/
    public function verRevisarPeriodo()
    {
        return view('marsky.jefeAdmin.revisarPeriodo');
    }

    /* Vista de admin ver listar periodos de las cajas chicas */
    public function listarPeriodosActuales()
    {
     
        //retorna la vista con la lista de todos los periodos en caja chica que aun no se hayan finalizado
        $empleado = Empleado::getEmpleadoLogeado();
        
        $listaPeriodos = PeriodoCaja::orderBy('codEstado','ASC')->get(); //lista todos los periodos no finalizados
        
       /*  return $listaPeriodos; */

        return view('marsky.jefeAdmin.listarPeriodos',compact('listaPeriodos'));

    }


    /* RESPONSABLE -> VER SU CAJA CHICA (detalels de sus gastos) */
    public function verPeriodoCajaParaResp()
    {

        $empleado = Empleado::getEmpleadoLogeado();
        
        $listaPeriodos = PeriodoCaja::where('codEmpleadoCajero','=',$empleado->codEmpleado)
        ->where('codEstado','=','1')->get();

        
        if(count($listaPeriodos)==0){
            return redirect()->route('resp.verAperturarPeriodo');
        }
        
        $periodo = $listaPeriodos[0];
        $listaGastos = GastoCaja::where('codPeriodoCaja','=',$periodo->codPeriodoCaja)->get();
           

        return view('marsky.cajaChicaResp.index',compact('periodo','listaGastos'));
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

            $periodo->save();
            db::commit();

            return redirect()->route('admin.listaPeriodos');
        } catch (\Throwable $th) {
            error_log('HA OCURRIDO UN ERRO EN PERIODOCAJA CONTROLLER 
            
            
            '.$th.'

            ');

            db::rollBack();
        }

        

    }

    public function verAperturarPeriodo(){
        $empleado = Empleado::getEmpleadoLogeado(); 
        $listaPeriodos = PeriodoCaja::where('codEmpleadoCajero','=',$empleado->codEmpleado)->get();


        return view('marsky.cajaChicaResp.nuevoPeriodo',compact('empleado','listaPeriodos'));

    }

}
