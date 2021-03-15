<?php

namespace App\Http\Controllers;

use App\Banco;
use App\CDP;
use App\DetalleReposicionGastos;
use App\Empleado;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Proyecto;
use App\ReposicionGastos;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReposicionGastosController extends Controller
{
    const PAGINATION = '20';

    function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
    }
    /**EMPLEADO */
    public function listarOfEmpleado($id){
        $empleado=Empleado::findOrFail($id);
        $arr=[1,3,5,6,7];
        $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->paginate($this::PAGINATION);
        //$reposiciones=$empleado->reposicion();
        return view('felix.GestionarReposicionGastos.Empleado.index',compact('reposiciones','empleado'));
    }
    public function view($id){
        /*
        $listaCDP = CDP::All();
        $proyectos = Proyecto::All();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        
        */
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        return view('felix.GestionarReposicionGastos.Empleado.view',compact('reposicion','empleadoLogeado','detalles'));
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
    public function store(Request $request){
        $reposicion=new ReposicionGastos();
        $reposicion->codEstadoReposicion=1;
        $reposicion->codEmpleadoSolicitante=Empleado::getEmpleadoLogeado()->codEmpleado;
        $reposicion->codEmpleadoEvaluador=Proyecto::find($request->codProyecto)->codEmpleadoDirector;
        $reposicion->codProyecto=$request->codProyecto;
        $reposicion->codMoneda=$request->codMoneda;
 
        $reposicion->fechaEmision=date('y-m-d');
        $reposicion->codigoCedepas=$request->codigoCedepas;
        $reposicion->girarAOrdenDe=$request->girarAOrdenDe;
        $reposicion->numeroCuentaBanco=$request->numeroCuentaBanco;
        $reposicion->codBanco=$request->codBanco;
        $reposicion->resumen=$request->resumen;
        $reposicion->fechaHoraRevisionGerente=null;
        $reposicion->fechaHoraRevisionAdmin=null;
        $reposicion->observacion=null;

        $reposicion->save();

        //creacion de detalles
        $vec[] = '';
            
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleReposicionGastos();
                $detalle->codReposicionGastos=$reposicion->codReposicionGastos ;//ultimo insertad
                // formato requerido por sql 2021-02-11   
                //formato dado por mi calnedar 12/02/2020
                $fechaDet = $request->get('colFecha'.$i);
                //DAMOS VUELTA A LA FECHA
                                                // AÑO                  MES                 DIA
                $detalle->fechaComprobante=                 substr($fechaDet,6,2).substr($fechaDet,3,2).substr($fechaDet,0,2);
                $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                $detalle->concepto=              $request->get('colConcepto'.$i);
                $detalle->importe=               $request->get('colImporte'.$i);    
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                $detalle->nroEnReposicion = $i+1;
                
                
                
                //ESTA WEA ES PARA SACAR LA TERMINACIONDEL ARCHIVO
                $nombreImagen = $request->get('nombreImg'.$i);  //sacamos el nombre completo
                $vec = explode('.',$nombreImagen); //separamos con puntos en un vector 
                $terminacion = end( $vec); //ultimo elemento del vector
                
                $detalle->terminacionArchivo = $terminacion; //guardamos la terminacion para poder usarla luego


                //               CDP-   000002                           -   5   .  jpg
                $nombreImagen = 'RepGastos-CDP-'.$this->rellernarCerosIzq($detalle->codReposicionGastos,6).'-'.$this->rellernarCerosIzq($i+1,2).'.'.$terminacion  ;
                $archivo =  $request->file('imagen'.$i);
                $fileget = \File::get( $archivo );
                Storage::disk('comprobantes')
                ->put(
                    $nombreImagen
                        ,
                        $fileget );
               
                $vec[$i] = $detalle;
                $detalle->save();
                                   
                $i=$i+1;
            }    

        return redirect()->route('reposicionGastos.listar',$request->codEmpleado);
    }
    /**GERENTE DE PROYECTOS */
    public function listarOfGerente($id){
        $empleado=Empleado::findOrFail($id);
        $proyectos=Proyecto::where('codEmpleadoDirector','=',$empleado->codEmpleado)->get();
        $arr=[];
        foreach ($proyectos as $itemproyecto) {
            $arr[]=$itemproyecto->codProyecto;
        }
        $reposiciones=ReposicionGastos::whereIn('codProyecto',$arr)->paginate($this::PAGINATION);
        return view('felix.GestionarReposicionGastos.Gerente.index',compact('reposiciones','empleado'));
    }
    public function viewGeren($id){
        /*
        $listaCDP = CDP::All();
        $proyectos = Proyecto::All();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        
        */
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        return view('felix.GestionarReposicionGastos.Gerente.view',compact('reposicion','empleadoLogeado','detalles'));
    }
    public function actualizarEstado($id){
        date_default_timezone_set('America/Lima');
        $arr = explode('*', $id);
        $reposicion=ReposicionGastos::find($arr[0]);
        $reposicion->codEstadoReposicion=$arr[1];
        $reposicion->fechaHoraRevisionGerente=new DateTime();
        $reposicion->save();
        return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
    }
    public function observarGeren($id){
        date_default_timezone_set('America/Lima');
        $arr = explode('*', $id);
        $reposicion=ReposicionGastos::find($arr[0]);
        $reposicion->codEstadoReposicion=5;
        $reposicion->observacion=$arr[1];
        $reposicion->fechaHoraRevisionGerente=new DateTime();
        $reposicion->save();
        return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
    }
    /**JEFE DE ADMINISTRACION */
    public function listarOfJefe(){
        $empleado=Empleado::getEmpleadoLogeado();
       
        $empleados=Empleado::where('codSede','=',$empleado->codSede)->get();
        $arr2=[];
        foreach ($empleados as $itemempleado) {
            $arr2[]=$itemempleado->codEmpleado;
        }
        $arr=[2,3,5,6,7];
        $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->whereIn('codEmpleadoSolicitante',$arr2)->paginate($this::PAGINATION);
        return view('felix.GestionarReposicionGastos.Jefe.index',compact('reposiciones','empleado'));
    }
    public function viewJefe($id){
        /*
        $listaCDP = CDP::All();
        $proyectos = Proyecto::All();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        
        */
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        return view('felix.GestionarReposicionGastos.Jefe.view',compact('reposicion','empleadoLogeado','detalles'));
    }
    public function actualizarEstadoJefe($id){
        date_default_timezone_set('America/Lima');
        $arr = explode('*', $id);
        $reposicion=ReposicionGastos::find($arr[0]);
        $reposicion->codEstadoReposicion=$arr[1];
        $reposicion->codEmpleadoAdmin=Empleado::getEmpleadoLogeado()->codEmpleado;
        $reposicion->fechaHoraRevisionAdmin=new DateTime();
        $reposicion->save();
        return redirect()->route('reposicionGastos.verificarJefe');
    }
    public function observarJefe($id){
        date_default_timezone_set('America/Lima');
        $arr = explode('*', $id);
        $reposicion=ReposicionGastos::find($arr[0]);
        $reposicion->codEstadoReposicion=5;
        $reposicion->observacion=$arr[1];
        $reposicion->fechaHoraRevisionAdmin=new DateTime();
        $reposicion->save();
        return redirect()->route('reposicionGastos.verificarJefe',$reposicion->codEmpleadoEvaluador);
    }
    /**CONTADOR */
    public function listarOfConta(){
        $empleado=Empleado::getEmpleadoLogeado();
       
        $empleados=Empleado::where('codSede','=',$empleado->codSede)->get();
        $arr2=[];
        foreach ($empleados as $itemempleado) {
            $arr2[]=$itemempleado->codEmpleado;
        }
        $arr=[3,4];
        $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->whereIn('codEmpleadoSolicitante',$arr2)->paginate($this::PAGINATION);
        return view('felix.GestionarReposicionGastos.Contador.index',compact('reposiciones','empleado'));
    }
    public function viewConta($id){
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        return view('felix.GestionarReposicionGastos.Contador.view',compact('reposicion','empleadoLogeado','detalles'));
    }
    public function actualizarEstadoConta($id){
        date_default_timezone_set('America/Lima');
        $arr = explode('*', $id);
        $reposicion=ReposicionGastos::find($arr[0]);
        $reposicion->codEstadoReposicion=$arr[1];
        $reposicion->codEmpleadoConta=Empleado::getEmpleadoLogeado()->codEmpleado;
        $reposicion->fechaHoraRevisionConta=new DateTime();
        $reposicion->save();
        return redirect()->route('reposicionGastos.verificarConta');
    }
}

