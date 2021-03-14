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
    public function listarEmpleados(){
        
        $empleados = Empleado::where('activo','=',1)->get();
        /*
        foreach ($Empresas as $Empresa) {//$Empresa es un registro
            echo $Empresa->nombre;
        }
        */
       
        return view('felix.GestionarEmpleados.index',compact('empleados'));//pasar variables del controlador a la vista
                                                                //nombre, valor
    }
    public function crearEmpleado(){
        //$areas=Area::all();
        //$proyectos = Proyecto::All();
        $puestos=Puesto::where('estado','!=',0)->get();
        $sedes=Sede::all();
        return view('felix.GestionarEmpleados.create',compact('puestos','sedes'));
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
        $empleado->direccion=$request->direccion;

        $arr = explode('/', $request->fechaNacimiento);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        $empleado->fechaNacimiento=$nFecha;   

        $empleado->sexo=$request->codSexo;
        $empleado->tieneHijos=$request->tieneHijos;
        $empleado->activo=1;
        $empleado->codigoCedepas='E'.'00'.$usuario->codUsuario;
        $empleado->dni=$request->DNI;
        $empleado->codPuesto=$request->codPuesto;
        
        $arr = explode('/', $request->fechaInicio);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        $empleado->fechaInicio=$nFecha;   
        $arr = explode('/', $request->fechaFin);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        $empleado->fechaFin=$nFecha;  
        
        $empleado->codSede=$request->codSede;

        //$empleado->codProyecto = $request->codProyectoDestino;
        //$empleado->fechaNacimiento=$request->fechaNacimiento->format('y-m-d');
        //$empleado->fechaNacimiento=date_format($request->fechaNacimiento,'y-m-d');


        //$empleado->codPuesto=$request->codPuesto;
        
        $empleado->save();

        return redirect('listarEmpleados');
    }

    public function editarEmpleado($id){
        $puestos=Puesto::where('estado','!=',0)->get();
        $sedes=Sede::all();
        $empleado=Empleado::find($id);
        //$areas=Area::all();
        //$puestos=Puesto::all();
        return view('felix.GestionarEmpleados.edit',compact('empleado','puestos','sedes'));
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
        //$empleado=new Empleado();
        //$empleado->codUsuario=$usuario->codUsuario;
        $empleado->nombres=$request->nombres;
        $empleado->apellidos=$request->apellidos;
        $empleado->direccion=$request->direccion;

        $arr = explode('/', $request->fechaNacimiento);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        $empleado->fechaNacimiento=$nFecha;   

        $empleado->sexo=$request->codSexo;
        $empleado->tieneHijos=$request->tieneHijos;
        //$empleado->activo=1;
        //$empleado->codigoCedepas='E'.'00'.$usuario->codUsuario;
        $empleado->dni=$request->DNI;
        $empleado->codPuesto=$request->codPuesto;
        
        $arr = explode('/', $request->fechaInicio);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        $empleado->fechaInicio=$nFecha;   
        $arr = explode('/', $request->fechaFin);
        $nFecha = $arr[2].'-'.$arr[1].'-'.$arr[0];     
        $empleado->fechaFin=$nFecha;  
        
        $empleado->codSede=$request->codSede;

        //$empleado->codProyecto = $request->codProyectoDestino;
        //$empleado->fechaNacimiento=$request->fechaNacimiento->format('y-m-d');
        //$empleado->fechaNacimiento=date_format($request->fechaNacimiento,'y-m-d');


        //$empleado->codPuesto=$request->codPuesto;
        
        $empleado->save();

        return redirect('listarEmpleados');
    }

    public function cesarEmpleado($id){
        $empleado=Empleado::find($id);
        $empleado->activo=0;
        $empleado->save();

        $usuario=$empleado->usuario();
        $usuario->delete();
        return redirect('listarEmpleados');
    }

}
