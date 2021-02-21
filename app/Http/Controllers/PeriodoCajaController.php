<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleado;
use App\GastoCaja;
use App\PeriodoCaja;
use App\Caja;


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
            return "Debe aperturar un periodo primero";
        }
        
        $periodo = $listaPeriodos[0];
        $listaGastos = GastoCaja::where('codPeriodoCaja','=',$periodo->codPeriodoCaja)->get();
           

        return view('marsky.cajaChicaResp.index',compact('periodo','listaGastos'));
    }

    /* Registrar gasto  */
    public function verRegistrarGasto()
    {

        return view('marsky.cajaChicaResp.registrar');
    }

    /* Liquidar la caja  */
    public function verLiquidar()
    {
        return view('marsky.cajaChicaResp.liquidar');
    }

}
