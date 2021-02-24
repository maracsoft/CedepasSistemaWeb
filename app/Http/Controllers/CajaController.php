<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caja;
use App\Proyecto;
use App\Empleado;
USE Illuminate\Support\Facades\DB;

class CajaController extends Controller
{
    public function listar(){
        $listaCajas = Caja::where('codCaja','>','0')->orderBy('activa','DESC')->get();

      
        return view('marsky.jefeAdmin.listarCajas',compact('listaCajas'));
        
    }


    public function verCrear(){

        $proyectos = Proyecto::All();
        $empleados = Empleado::All();

        return view('marsky.jefeAdmin.crearCaja',compact('proyectos','empleados'));
    }



    public function store(Request $request){



        $proy = Proyecto::findOrFail($request->codProyectoDestino);
        if($proy->tieneCaja()==1){
            return redirect()->route('caja.index')->with('datos','¡Error: el proyecto seleccionado ya tiene una caja.!');
        }


        try {


            DB::beginTransaction();
            $caja = new Caja();
            $caja->nombre = $request->nombre;
            $caja->montoMaximo = $request->montoMaximo;
            $caja->montoActual = $request->montoMaximo;
            $caja->codEmpleadoCajeroActual = $request->codEmpleadoResponsable; 
            $caja->codProyecto = $request->codProyectoDestino;
            $caja->activa = '1';

            $caja->save();

            
            db::commit();
            
            return redirect()->route('caja.index')->with('datos','¡Caja creada exitosamente!');
            
        } catch (\Throwable $th) {
            error_log('
             HA OCURRIDO UN ERROR EN CAJA CONTROLLER 
            
            '.$th.'

            ');

            
        
        }


    } 

    public function edit($codCaja){
        $caja = Caja::findOrFail($codCaja);

        
        $proyectos = Proyecto::All();
        $empleados = Empleado::All();

        return view('marsky.jefeAdmin.editCaja',compact('caja','proyectos','empleados'));
    }

    public function update(Request $request,$codCaja){
        try {


            DB::beginTransaction();
            $caja = Caja::findOrFail($codCaja);
            $empleado = Empleado::findOrFail($request->codEmpleadoResponsable);

            if($caja->codEmpleadoCajeroActual != $request->codEmpleadoResponsable) 
            //si se está cambiando el responsable 
            {

                if($caja->tienePeriodoEnProceso()=='1') //y la caja tiene un periodo activo (gastandose)
                    return redirect()->route('caja.index')->with('datos',
                    'No se puede cambiar el responsable de la caja si el actual '.
                        'no liquida su caja y finaliza su periodo.');
                if($empleado->tieneCaja()=='1')
                return redirect()->route('caja.index')->with('datos',
                    'No se puede cambiar por un empleado que ya es responsable de una caja ');
            }

            $caja->nombre = $request->nombre;
            $caja->montoMaximo = $request->montoMaximo;
            //el monto actual no se debe alterar
            $caja->codEmpleadoCajeroActual = $request->codEmpleadoResponsable; 
            

            $caja->save();

            
            db::commit();
            
            return redirect()->route('caja.index')->with('datos','¡Caja editada exitosamente!');
            
        } catch (\Throwable $th) {
            error_log('
             HA OCURRIDO UN ERROR EN CAJA CONTROLLER 
            
            '.$th.'

            ');

            
        
        }


    } 
/* LE DA DE BAJA A UNA CAJA. ESTO SOLO PUEDE HACERSE SI LA CAJA NO TIENE NINGUN PERIODO EN PROCESO */
    public function destroy($codCaja){

        $caja = Caja::findOrFail($codCaja);
        if($caja->tienePeriodoEnProceso()=='1')
            return redirect()->route('caja.index')->with('datos',
            'No se puede dar de baja la caja si el actual responsable '.
                'no liquida sus gastos y finaliza su periodo.');

        try {
            DB::beginTransaction();
            
            $caja->activa = '0';
            $caja->codEmpleadoCajeroActual = '0';
            
            $caja->save();
            
            db::commit();
            
            return redirect()->route('caja.index')->with('datos','¡Caja dada de baja exitosamente!');
        } catch (\Throwable $th) {
            error_log('
             HA OCURRIDO UN ERROR EN CAJA CONTROLLER  DESTROY
            
            '.$th.'

            ');

        }
    }

}