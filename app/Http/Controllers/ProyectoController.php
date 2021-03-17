<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Proyecto;
use Illuminate\Http\Request;
use App\Empleado;
use App\ProyectoContador;
use App\Puesto;
use Illuminate\Support\Facades\DB;
use NumberFormatter;
use App\Sede;
use App\Debug;
class ProyectoController extends Controller
{
    
    function crear(){
        $listaSedes = Sede::All();

        return view('vigo.proyecto.create',compact('listaSedes'));
    }

    function store(Request $request){
        try {
            DB::beginTransaction();

            $proyecto = new Proyecto();
            $proyecto->nombre = $request->nombre;
            $proyecto->activo = 1;
            $proyecto->codSedePrincipal = $request->codSede;
            $proyecto->abreviatura = $request->abreviatura;
            $proyecto->save();

            DB::commit();

            return redirect()->route('proyecto.asignarGerentes')->with('datos','Proyecto creado exitosamente.');
        } catch (\Throwable $th) {
           
            Debug::mensajeError('PROYECTO CONTROLLER STORE',$th);
            DB::rollBack();
        }


    }

    //despliega la vista de los proyectos para asignarlos a sus gerentes.
    function listarProyectosYGerentes(){

        
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaGerentes = Empleado::getListaGerentesActivos();
        $listaContadores = Empleado::getListaContadoresActivos();

        return view('asignarGerentes',compact('listaProyectos','listaGerentes','listaContadores'));
    }

    function listarContadores($id){
        $proyecto=Proyecto::findOrFail($id);
        $contadoresSeleccionados=$proyecto->getContadores();
        $arr=[];
        foreach ($contadoresSeleccionados as $itemcontador) {
            $arr[]=$itemcontador->codEmpleado;
        }
        $contadores=Empleado::where('codPuesto','=',Puesto::getCodigo('Contador'))->whereNotIn('codEmpleado',$arr)->get();
        

        return view('contadoresProyecto',compact('proyecto','contadores','contadoresSeleccionados'));
    }

    function agregarContador(Request $request){
        $detalle=new ProyectoContador();
        $detalle->codProyecto=$request->codProyecto;
        $detalle->codEmpleadoContador=$request->codEmpleadoConta;
        $detalle->save();

        return redirect()->route('proyecto.listarContadores',$request->codProyecto);
    }

    function eliminarContador($id){
        $detalle=ProyectoContador::where('codEmpleadoContador','=',$id)->get();
        $detalle[0]->delete();

        return redirect()->route('proyecto.listarContadores',$detalle[0]->codProyecto);
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
