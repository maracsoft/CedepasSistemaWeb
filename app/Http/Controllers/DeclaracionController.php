<?php

namespace App\Http\Controllers;

use App\Declaracion;
use Illuminate\Http\Request;

class DeclaracionController extends Controller
{


    public function listar(){
        $listaDeclaraciones=Declaracion::All();

        return view('marsky.pagos.index',compact('listaDeclaraciones'));
    }

    public function ver($id){
        $declaracion = Declaracion::findOrFail($id);
        return view('marsky.pagos.registrar');
    }


    public function create(){
        $listaEmpleados = [];
        return view('marsky.pagos.registrar',compact('listaEmpleados'));
    }
}
