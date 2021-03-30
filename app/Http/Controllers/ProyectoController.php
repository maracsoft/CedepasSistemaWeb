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

        return view('Proyectos.Create',compact('listaSedes'));
    }

    function editar($codProyecto){
        $proyecto = Proyecto::findOrFail($codProyecto);
        $listaSedes = Sede::All();

        return view('Proyectos.Edit',compact('listaSedes','proyecto'));
    }

    
    function getCodigoPresupuestal($id){
        error_log('['.Proyecto::findOrFail($id)->codigoPresupuestal.']');
        return Proyecto::findOrFail($id)->codigoPresupuestal;
    } 


    function store(Request $request){
        try {
            DB::beginTransaction();

            $proyecto = new Proyecto();
            $proyecto->nombre = $request->nombre;
            $proyecto->activo = 1;
            $proyecto->codSedePrincipal = $request->codSede;
            $proyecto->codigoPresupuestal = $request->codigoPresupuestal;
            $proyecto->nombreLargo = $request->nombreLargo;
            
            $proyecto->save();

            DB::commit();

            return redirect()->route('GestiónProyectos.Listar')->with('datos','Proyecto creado exitosamente.');
        } catch (\Throwable $th) {
           
            Debug::mensajeError('PROYECTO CONTROLLER STORE',$th);
            DB::rollBack();
            return redirect()->route('GestiónProyectos.Listar')->with('datos','Ha ocurrido un ERROR.');
        }


    }

    function update(Request $request){
        try {
            DB::beginTransaction();

            $proyecto = Proyecto::findOrFail($request->codProyecto);
            $proyecto->nombre = $request->nombre;
            $proyecto->codSedePrincipal = $request->codSede;
            $proyecto->codigoPresupuestal = $request->codigoPresupuestal;
            $proyecto->nombreLargo = $request->nombreLargo;
            
            $proyecto->save();

            DB::commit();

            return redirect()->route('GestiónProyectos.Listar')->with('datos','Proyecto actualizado exitosamente.');
        } catch (\Throwable $th) {
           
            Debug::mensajeError('PROYECTO CONTROLLER STORE',$th);
            DB::rollBack();
            return redirect()->route('GestiónProyectos.Listar')->with('datos','Ha ocurrido un ERROR.');
        }


    }


    function darDeBaja($codProyecto){
        try {
            DB::beginTransaction();

            $proyecto = Proyecto::findOrFail($codProyecto);
            $proyecto->activo = 0;
            $proyecto->save();

            DB::commit();

            return redirect()->route('GestiónProyectos.Listar')->with('datos','Proyecto Dado de baja exitosamente.');
        } catch (\Throwable $th) {
           
            Debug::mensajeError('PROYECTO CONTROLLER STORE',$th);
            DB::rollBack();
            return redirect()->route('GestiónProyectos.Listar')->with('datos','Ha ocurrido un ERROR.');
        }


    }
    //VISTA INDEX de proyectos
    function index(){
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaGerentes = Empleado::getListaGerentesActivos();
        $listaContadores = Empleado::getListaContadoresActivos();

        return view('Proyectos.ListarProyectos',
            compact('listaProyectos','listaGerentes','listaContadores'));


    }


    function listarContadores($id){
        $proyecto=Proyecto::findOrFail($id);
        $contadoresSeleccionados=$proyecto->getContadores();
        $arr=[];
        foreach ($contadoresSeleccionados as $itemcontador) {
            $arr[]=$itemcontador->codEmpleado;
        }
        $contadores=Empleado
            ::where('codPuesto','=',Puesto::getCodigo('Contador'))
            ->whereNotIn('codEmpleado',$arr)->get();
            

        return view('Proyectos.ContadoresProyecto',compact('proyecto','contadores','contadoresSeleccionados'));
    }

    function agregarContador(Request $request){
        $detalle=new ProyectoContador();
        $detalle->codProyecto=$request->codProyecto;
        $detalle->codEmpleadoContador=$request->codEmpleadoConta;
        $detalle->save();

        return redirect()->route('GestiónProyectos.ListarContadores',$request->codProyecto);
    }

    function eliminarContador($id){
        $detalle=ProyectoContador::where('codEmpleadoContador','=',$id)->get();
        $detalle[0]->delete();

        return redirect()->route('GestiónProyectos.ListarContadores',$detalle[0]->codProyecto);
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
