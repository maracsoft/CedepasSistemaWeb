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
        $listaCajas = Caja::All();

      
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
       
            $caja->nombre = $request->nombre;
            $caja->montoMaximo = $request->montoMaximo;
            $caja->montoActual = $request->montoMaximo;
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


}