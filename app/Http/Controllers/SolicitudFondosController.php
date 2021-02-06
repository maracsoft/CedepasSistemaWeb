<?php

namespace App\Http\Controllers;

use App\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SolicitudFondos;

class SolicitudFondosController extends Controller
{

    const PAGINATION = '20';

    
    public function listarSolicitudesDeEmpleado(Request $request){
        
        $codUsuario = Auth::id(); //este es el idSolicitante 

        
        $empleados = Empleado::where('codUsuario','=',$codUsuario)->get();
        $empleado = $empleados[0];

        
        $listaSolicitudesFondos = SolicitudFondos::
        where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
        ->paginate();

        $buscarpor = "";

        return view('modulos.empleado.index',compact('buscarpor','listaSolicitudesFondos'));
    }

    


}
