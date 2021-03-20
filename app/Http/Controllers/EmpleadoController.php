<?php

namespace App\Http\Controllers;

use App\Area;
use App\Empleado;
use App\PeriodoEmpleado;
use App\Puesto;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Proyecto;
use App\Sede;

class EmpleadoController extends Controller
{
    const PAGINATION = '10';

    public function listarEmpleados(Request $request){
        $dniBuscar=$request->dniBuscar;
        $empleados = Empleado::where('activo','=',1)->where('dni','like',$dniBuscar.'%')->orderBy('fechaRegistro','desc')->paginate($this::PAGINATION);
        return view('Empleados.index',compact('empleados','dniBuscar'));
    }
    public function crearEmpleado(){
        //$areas=Area::all();
        //$proyectos = Proyecto::All();
        $puestos=Puesto::where('estado','!=',0)->get();
        $sedes=Sede::all();
        return view('Empleados.create',compact('puestos','sedes'));
    }
    /*
    public function listarPuestos(Request $request,$id){
        $puestos=Puesto::where('codArea','=',$id)->get();
        return response()->json(['puestos'=>$puestos]);
    }
    */


    public function guardarCrearEmpleado(Request $request){
        //Usuario
        $usuario=new User();
        $usuario->usuario=$request->usuario;
        $usuario->password=hash::make($request->contraseña);
        $usuario->isAdmin=0;
        $usuario->save();
        //Empleado
        $empleado=new Empleado();
        $empleado->codUsuario=$usuario->codUsuario;
        $empleado->nombres=$request->nombres;
        $empleado->apellidos=$request->apellidos;
        //$empleado->direccion=$request->direccion;

        //$arr = explode('/', $request->fechaNacimiento);
        //$nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        //$empleado->fechaNacimiento=$nFecha;   

        //$empleado->sexo=$request->codSexo;
        //$empleado->tieneHijos=$request->tieneHijos;
        $empleado->activo=1;
        $empleado->codigoCedepas=$request->codigo;
        $empleado->dni=$request->DNI;
        $empleado->codPuesto=$request->codPuesto;
        
        //$arr = explode('/', $request->fechaInicio);
        //$nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        $empleado->fechaRegistro=date('y-m-d');   
        //$arr = explode('/', $request->fechaFin);
        //$nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        //$empleado->fechaFin=$nFecha;  
        
        $empleado->codSede=$request->codSede;

        //$empleado->codProyecto = $request->codProyectoDestino;
        //$empleado->fechaNacimiento=$request->fechaNacimiento->format('y-m-d');
        //$empleado->fechaNacimiento=date_format($request->fechaNacimiento,'y-m-d');


        //$empleado->codPuesto=$request->codPuesto;
        
        $empleado->save();

        return redirect()->route('GestionUsuarios.listarEmpleados');
    }

    public function editarEmpleado($id){
        $puestos=Puesto::where('estado','!=',0)->get();
        $sedes=Sede::all();
        $empleado=Empleado::find($id);
        //$areas=Area::all();
        //$puestos=Puesto::all();
        return view('Empleados.edit',compact('empleado','puestos','sedes'));
    }

    public function guardarEditarEmpleado(Request $request){
        //Usuario
        //$usuario=new User();
        $empleado=Empleado::find($request->codEmpleado);
        $usuario=$empleado->usuario();
        $usuario->usuario=$request->usuario;
        $usuario->password=hash::make($request->contraseña);
        //$usuario->isAdmin=0;
        $usuario->save();
        //Empleado
        $empleado->nombres=$request->nombres;
        $empleado->apellidos=$request->apellidos;
        $empleado->codigoCedepas=$request->codigo;
        $empleado->dni=$request->DNI;
        $empleado->codPuesto=$request->codPuesto; 
        $empleado->codSede=$request->codSede;

        $empleado->save();

        return redirect()->route('GestionUsuarios.listarEmpleados');
    }

    public function cesarEmpleado($id){
        $empleado=Empleado::find($id);
        $empleado->fechaDeBaja=date('y-m-d');
        $empleado->activo=0;
        $empleado->save();

        $usuario=$empleado->usuario();
        $usuario->delete();
        return redirect()->route('GestionUsuarios.listarEmpleados');
    }

}
