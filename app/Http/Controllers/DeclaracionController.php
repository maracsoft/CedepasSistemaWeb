<?php
namespace App\Http\Controllers;

use App\Declaracion;
use Illuminate\Http\Request;
use App\Empleado;

class DeclaracionController extends Controller
{


    public function ver($id){
        $declaracion = Declaracion::findOrFail($id);
        return view('marsky.pagos.registrar');
    }


}
