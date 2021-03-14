<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Proyecto;
use Illuminate\Http\Request;
use App\Empleado;
use App\Puesto;


class ProyectoController extends Controller
{
    


    //despliega la vista de los proyectos para asignarlos a sus gerentes.
    function listarProyectosYGerentes(){

        
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaGerentes = Empleado::getListaGerentesActivos();

        return view('asignarGerentes',compact('listaProyectos','listaGerentes'));
    }
}
