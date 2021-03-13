<?php

namespace App\Http\Controllers;

use App\Banco;
use App\CDP;
use App\Empleado;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Proyecto;
use App\ReposicionGastos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReposicionGastosController extends Controller
{
    /**EMPLEADO */
    public function listarOfEmpleado($id){
        $empleado=Empleado::findOrFail($id);
        $reposicion=$empleado->reposicion();
        return view('felix.GestionarReposicionGastos.Empleado.index',compact('reposicion','empleado'));
    }
    public function create(){
        $listaCDP = CDP::All();
        $proyectos = Proyecto::All();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        return view('felix.GestionarReposicionGastos.Empleado.create',compact('empleadoLogeado','listaCDP','proyectos','empleadosEvaluadores','monedas','bancos'));
    }
    /**GERENTE DE PROYECTOS */
    /**JEFE DE ADMINISTRACION */
}
