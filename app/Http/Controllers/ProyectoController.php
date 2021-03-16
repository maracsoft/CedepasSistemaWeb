<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Proyecto;
use Illuminate\Http\Request;
use App\Empleado;
use App\Puesto;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    


    //despliega la vista de los proyectos para asignarlos a sus gerentes.
    function listarProyectosYGerentes(){

        
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaGerentes = Empleado::getListaGerentesActivos();
        $listaContadores = Empleado::getListaContadoresActivos();

        return view('asignarGerentes',compact('listaProyectos','listaGerentes','listaContadores'));
    }

    function listarContadores($id){

        
        $proyecto=Proyecto::findOrFail($id);

        return view('contadoresProyecto',compact('proyecto'));
    }


    function actualizarProyectosYGerentesContadores($id){
        try{
            $arr = explode('*', $id);
            DB::beginTransaction();
            $proyecto=Proyecto::findOrFail($arr[0]);
            $gerente=Empleado::findOrFail($arr[1]);
            if($arr[2]==1){
                $proyecto->codEmpleadoDirector=$gerente->codEmpleado;
            }else{
                $proyecto->codEmpleadoConta=$gerente->codEmpleado;
            }
            $proyecto->save();
            DB::commit();
            return true;
        }catch(\Throwable $th){
            DB::rollBack();
            return false;
        }
    }
    
}
