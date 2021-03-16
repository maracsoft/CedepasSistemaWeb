<?php

namespace App\Http\Controllers;

use App\Banco;
use App\CDP;
use App\Debug;
use App\DetalleReposicionGastos;
use App\Empleado;
use App\Http\Controllers\Controller;
use App\Moneda;
use App\Proyecto;
use App\Puesto;
use App\ReposicionGastos;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        return view('felix.GestionarReposicionGastos.Empleado.listarEmp',compact('reposiciones','empleado'));
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

        return view('felix.GestionarReposicionGastos.Empleado.verEmp',compact('reposicion','empleadoLogeado','detalles'));
    }
    public function create(){
        $listaCDP = CDP::All();
        $proyectos = Proyecto::All();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        return view('felix.GestionarReposicionGastos.Empleado.createRepo',compact('empleadoLogeado','listaCDP','proyectos','empleadosEvaluadores','monedas','bancos'));
    }


    /*  
    ALMACENAR LOS DATOS Y LOS ARCHIVOS DE DETALLES QUE ESTAN SUBIENDO
    CADA ARCHIVO ES UNA FOTO DE UN CDP, pero están independientes xd o sea un archivo no está ligado necesariamente a un item de gasto 

    https://www.itsolutionstuff.com/post/laravel-7-multiple-file-upload-tutorialexample.html
    */
    public function store(Request $request){
        try{
            DB::beginTransaction(); 
            $reposicion=new ReposicionGastos();
            $reposicion->codEstadoReposicion=1;
            $reposicion->codEmpleadoSolicitante=Empleado::getEmpleadoLogeado()->codEmpleado;
            //$reposicion->codEmpleadoEvaluador=Proyecto::find($request->codProyecto)->codEmpleadoDirector;
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
            $codRepRecienInsertada = (ReposicionGastos::latest('codReposicionGastos')->first())->codReposicionGastos;
            
            //creacion de detalles
            $vec[] = '';
                
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) 
            {
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
                    $detalle->save();  
                    $i=$i+1;
            }


            
            Debug::mensajeSimple('LLEGO 1 ');
            $nombresArchivos = explode(', ',$request->nombresArchivos);
            $j=0;
            $terminacionesArchivos='';
            foreach ($request->file('filenames') as $archivo)
            {   
                Debug::mensajeSimple('LLEGO 2 ');
                //separamos con puntos en un vector 
                $vectorS = explode('.',$nombresArchivos[$j]);
                $terminacion = end($vectorS); //ultimo elemento del vector
                $terminacionesArchivos=$terminacionesArchivos.'/'.$terminacion;
                Debug::mensajeSimple('LLEGO 3 ');
                //               CDP-   000002                           -   5   .  jpg

                $nombreImagen = ReposicionGastos::getFormatoNombreCDP($codRepRecienInsertada, $j+1,$terminacion);
                Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                $fileget = \File::get( $archivo );
                Debug::mensajeSimple('LLEGO 4 ');
                Storage::disk('reposiciones')
                ->put($nombreImagen,$fileget );
                $j++;
            }

            
            $reposicion->cantArchivos = $j;
            $terminacionesArchivos = trim($terminacionesArchivos,'/');
            $reposicion->terminacionesArchivos=$terminacionesArchivos;

            $reposicion->save();

            DB::commit();
            return redirect()->route('reposicionGastos.listar',$request->codEmpleado);
        }catch(\Throwable $th){
            
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER STORE', $th);
            DB::rollBack();
            return redirect()->route('reposicionGastos.listar',$request->codEmpleado);
        }
        
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
        return view('felix.GestionarReposicionGastos.Gerente.listarGeren',compact('reposiciones','empleado'));
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

        return view('felix.GestionarReposicionGastos.Gerente.verGeren',compact('reposicion','empleadoLogeado','detalles'));
    }
    


    //se le pasa el INDEX del archivo 
    function descargarCDP($cadena){
        $vector = explode('*',$cadena);
        $codRend = $vector[0];
        $i = $vector[1];
        $repo = ReposicionGastos::findOrFail($codRend);
        $nombreArchivo = ReposicionGastos::getFormatoNombreCDP(
                $repo->codReposicionGastos,$i,$repo->getTerminacionNro($i)
        );
        return Storage::download("/comprobantes/reposiciones/".$nombreArchivo);

    }







    public function observarGeren($id){
        try{
            DB::beginTransaction();
            date_default_timezone_set('America/Lima');
            $arr = explode('*', $id);
            $reposicion=ReposicionGastos::find($arr[0]);
            $reposicion->codEstadoReposicion=5;
            $reposicion->observacion=$arr[1];
            $reposicion->fechaHoraRevisionGerente=new DateTime();
            $reposicion->save();
            DB::commit();
            return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
        }catch(\Throwable $th){
            DB::rollBack();
            return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
        }
        
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
        return view('felix.GestionarReposicionGastos.Jefe.listarJefe',compact('reposiciones','empleado'));
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

        return view('felix.GestionarReposicionGastos.Jefe.verJefe',compact('reposicion','empleadoLogeado','detalles'));
    }
    public function actualizarEstadoJefe($id){
        try{
            DB::beginTransaction();
            date_default_timezone_set('America/Lima');
            $arr = explode('*', $id);
            $reposicion=ReposicionGastos::find($arr[0]);
            $reposicion->codEstadoReposicion=$arr[1];
            $reposicion->codEmpleadoAdmin=Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->fechaHoraRevisionAdmin=new DateTime();
            $reposicion->save();
            DB::commit();
            return redirect()->route('reposicionGastos.verificarJefe');
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            return redirect()->route('reposicionGastos.verificarJefe');
        }
        
    }
    public function observarJefe($id){
        try{
            DB::beginTransaction();
            date_default_timezone_set('America/Lima');
            $arr = explode('*', $id);
            $reposicion=ReposicionGastos::find($arr[0]);
            $reposicion->codEstadoReposicion=5;
            $reposicion->observacion=$arr[1];
            $reposicion->fechaHoraRevisionAdmin=new DateTime();
            $reposicion->save();
            DB::commit();
            return redirect()->route('reposicionGastos.verificarJefe',$reposicion->codEmpleadoEvaluador);
        }catch(\Throwable $th){
            DB::rollBack();
            return redirect()->route('reposicionGastos.verificarJefe',$reposicion->codEmpleadoEvaluador);
        }
        
    }
    /**CONTADOR */
    public function listarOfConta(){
        $empleado=Empleado::getEmpleadoLogeado();
       
        $proyectos=Proyecto::where('codEmpleadoConta','=',$empleado->codEmpleado)->get();
        $arr2=[];
        foreach ($proyectos as $itemproyecto) {
            $arr2[]=$itemproyecto->codProyecto;
        }
        $arr=[3,4];
        $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->whereIn('codProyecto',$arr2)->paginate($this::PAGINATION);
        return view('felix.GestionarReposicionGastos.Contador.listarCont',compact('reposiciones','empleado'));
    }
    public function viewConta($id){
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        return view('felix.GestionarReposicionGastos.Contador.verCont',compact('reposicion','empleadoLogeado','detalles'));
    }
    public function actualizarEstadoConta($id){
        try{
            DB::beginTransaction();
            date_default_timezone_set('America/Lima');
            $arr = explode('*', $id);
            $reposicion=ReposicionGastos::find($arr[0]);
            $reposicion->codEstadoReposicion=$arr[1];
            $reposicion->codEmpleadoConta=Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->fechaHoraRevisionConta=new DateTime();
            $reposicion->save();
            DB::commit();
            return redirect()->route('reposicionGastos.verificarConta');
        }catch(\Throwable $th){
            DB::rollBack();
            return redirect()->route('reposicionGastos.verificarConta');
        }
        
    }

    public function actualizarEstado($id){
        try{
            DB::beginTransaction();
            date_default_timezone_set('America/Lima');
            $arr = explode('*', $id);
            $reposicion=ReposicionGastos::find($arr[0]);
            $reposicion->codEstadoReposicion=$arr[1];
            $reposicion->fechaHoraRevisionGerente=new DateTime();
            $reposicion->save();
            DB::commit();
            return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
        }
        
    }


    public function aprobar($id){//gerente
        try{
            DB::beginTransaction();
            $reposicion=ReposicionGastos::find($id);
            $reposicion->codEstadoReposicion=2;
            $reposicion->fechaHoraRevisionGerente=new DateTime();
            $reposicion->save();
            DB::commit();
            return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
        }
    }
    public function abonar($id){}
    public function contabilizar($id){}
    public function observar($id){}
    public function rechazar($id){//gerente-jefe (codReposicion)
        try{
            DB::beginTransaction();
            $reposicion=ReposicionGastos::find($id);
            $empleado=Empleado::getEmpleadoLogeado();
            if($empleado->codPuesto==Puesto::getCodigo('Gerente')){}
            $reposicion->codEstadoReposicion=Empleado::getEmpleadoLogeado()->codEmpleado;;
            $reposicion->fechaHoraRevisionGerente=new DateTime();
            $reposicion->save();
            DB::commit();
            return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            return redirect()->route('reposicionGastos.verificar',$reposicion->codEmpleadoEvaluador);
        }
    }
}

