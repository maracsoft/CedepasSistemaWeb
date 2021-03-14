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

        return view('asignarGerentes',compact('listaProyectos','listaGerentes'));
    }

    function actualizarProyectosYGerentes($id){
        try{
            $arr = explode('*', $id);
            DB::beginTransaction();
            $proyecto=Proyecto::findOrFail($arr[0]);
            $gerente=Empleado::findOrFail($arr[1]);
            $proyecto->codEmpleadoDirector=$gerente->codEmpleado;
            $proyecto->save();
            DB::commit();
            return true;
        }catch(\Throwable $th){
            DB::rollBack();
            return false;
        }
    }
}
