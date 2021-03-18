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
use App\ProyectoContador;
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

    public function listarReposiciones(){

        $empleado = Empleado::getEmpleadoLogeado();
        $msj = session('datos');
        $datos='';
        if($msj!='')
            $datos = 'datos';

        if($empleado->esGerente()){
            return redirect()->route('reposicionGastos.listarRepoOfGerente')->with($datos,$msj);
        }
        if($empleado->esJefeAdmin()){
            return redirect()->route('reposicionGastos.listarRepoOfJefe')->with($datos,$msj);
        }
        if($empleado->esContador()){
            return redirect()->route('reposicionGastos.listarRepoOfContador')->with($datos,$msj);
        }
        return redirect()->route('reposicionGastos.listar')->with($datos,$msj);

    }

    //funcion servicio, será consumida solo por javascript
    public function listarDetalles($idReposicion){
        $vector = [];
        $listaDetalles = DetalleReposicionGastos::where('codReposicionGastos','=',$idReposicion)->get();
        for ($i=0; $i < count($listaDetalles) ; $i++) { 
            
            $itemDet = $listaDetalles[$i];
            $itemDet['nombreTipoCDP'] = $itemDet->getNombreTipoCDP(); //tengo que pasarlo aqui pq en el javascript no hay manera de calcularlo, de todas maneras no lo usaré como Modelo (objeto)
            $itemDet['nombreImagen'] = ReposicionGastos::getFormatoNombreCDP($itemDet->codReposicionGastos,$i+1,$itemDet->terminacionArchivo);
                // formato dado por sql 2021-02-11   
                //formato requerido por mi  12/02/2020
                $fechaDet = $itemDet->fechaComprobante;
                //DAMOS VUELTA A LA FECHA
                                // DIA                  MES                 AÑO
            $nuevaFecha=substr($fechaDet,8,2).'/'.substr($fechaDet,5,2).'/'.substr($fechaDet,0,4);
            $itemDet['fechaFormateada'] = $nuevaFecha;
            array_push($vector,$itemDet);            
        }
        return $vector  ;
    }



    function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
    }
    /**EMPLEADO */



    public function listarOfEmpleado(Request $request){
        $codProyectoBuscar=$request->codProyectoBuscar;
        $empleado=Empleado::getEmpleadoLogeado();

        if($codProyectoBuscar==0){
            $reposiciones= ReposicionGastos::where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
            ->orderBy('codEstadoReposicion')
            ->paginate($this::PAGINATION);
        }else
            $reposiciones= ReposicionGastos::where('codEmpleadoSolicitante','=',$empleado->codEmpleado)->where('codProyecto','=',$codProyectoBuscar)
                ->orderBy('codEstadoReposicion')
                ->paginate($this::PAGINATION);
        $proyectos=Proyecto::all();
    //return $reposiciones;
        return view('felix.GestionarReposicionGastos.Empleado.listarEmp',
            compact('reposiciones','empleado','codProyectoBuscar','proyectos'));
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
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('felix.GestionarReposicionGastos.Empleado.verEmp',compact('reposicion','empleadoLogeado','detalles'));
    }
    public function create(){
        $listaCDP = CDP::All();
        $proyectos = Proyecto::All();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('felix.GestionarReposicionGastos.Empleado.createRepo',compact('empleadoLogeado','listaCDP','proyectos','empleadosEvaluadores','monedas','bancos'));
    }


    public function editar($id){
        $reposicion = ReposicionGastos::findOrFail($id);
        $listaCDP = CDP::All();
        $proyectos = Proyecto::All();
        $monedas=Moneda::All();
        $bancos=Banco::All();
        $empleadosEvaluadores=Empleado::where('activo','!=',0)->get();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('felix.GestionarReposicionGastos.Empleado.editRepo',compact('empleadoLogeado','listaCDP','proyectos',
            'empleadosEvaluadores','monedas','bancos','reposicion'));


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
            $total=0;
                
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
                    $total+=(float)$request->get('colImporte'.$i);
                    $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                    $detalle->nroEnReposicion = $i+1;
                    $detalle->save();  
                    $i=$i+1;
            }
            $reposicion->totalImporte=$total;
            $reposicion->save();
            
            $nombresArchivos = explode(', ',$request->nombresArchivos);
            $j=0;
            $terminacionesArchivos='';
            foreach ($request->file('filenames') as $archivo)
            {   
                
                //separamos con puntos en un vector 
                $vectorS = explode('.',$nombresArchivos[$j]);
                $terminacion = end($vectorS); //ultimo elemento del vector
                $terminacionesArchivos=$terminacionesArchivos.'/'.$terminacion;
               
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
            return redirect()->route('reposicionGastos.listar')->with('datos','Se ha Registrado la reposicion N°'.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER STORE', $th);
            DB::rollBack();
            return redirect()->route('reposicionGastos.listar')->with('datos','Ha ocurrido un error.');
        }
        
    }





    
    public function update( Request $request){
        
        try {
            $reposicion=ReposicionGastos::findOrFail($request->codReposicionGastos);
            $reposicion->codProyecto=$request->codProyecto;
            $reposicion->codMoneda=$request->codMoneda;
     
            $reposicion->girarAOrdenDe=$request->girarAOrdenDe;
            $reposicion->numeroCuentaBanco=$request->numeroCuentaBanco;
            $reposicion->codBanco=$request->codBanco;
            $reposicion->resumen=$request->resumen;
            //si estaba observada, pasa a subsanada
            if($reposicion->verificarEstado('Observada'))
                $reposicion-> codEstadoReposicion = ReposicionGastos::getCodEstado('Subsanada');
            else
                $reposicion-> codEstadoReposicion = ReposicionGastos::getCodEstado('Creada');
            $reposicion-> save();        
            



            $total=0;
            //borramos todos los detalles pq los ingresaremos again
            DB::select('delete from detalle_reposicion_gastos where codReposicionGastos=" '.$reposicion->codReposicionGastos.'"');

            //RECORREMOS la tabla con gastos 
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleReposicionGastos();
                $detalle->codReposicionGastos=          $reposicion->codReposicionGastos ;//ultimo insertad
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
                $total+=(float)$request->get('colImporte'.$i);
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                $detalle->nroEnReposicion = $i+1;          
                $i=$i+1;
                $detalle->save();

            }  
            $reposicion->totalImporte=$total;
            $reposicion->save();  


            //SOLO BORRAMOS TODO E INSERTAMOS NUEVOS ARCHIVOS SI ES QUE SE INGRESÓ NUEVOS
            if( $request->nombresArchivos!='' ){
                $reposicion->borrarArchivosCDP(); /* FALTA HACER ESTA FUNCION */
                
                $nombresArchivos = explode(', ',$request->nombresArchivos);
                $terminacionesArchivos='';   $j=0;
                foreach ($request->file('filenames') as $archivo) //guardamos los que se insertaron ahora 
                {   
              
                    //separamos con puntos en un vector 
                    $vectorS = explode('.',$nombresArchivos[$j]);
                    $terminacion = end($vectorS); //ultimo elemento del vector
                    $terminacionesArchivos=$terminacionesArchivos.'/'.$terminacion;
                    
                    //               CDP-   000002                           -   5   .  jpg
                    $nombreImagen = ReposicionGastos::getFormatoNombreCDP($reposicion->codReposicionGastos ,$j+1 ,$terminacion ) ;
                    Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                    $fileget = \File::get( $archivo );
                
                    Storage::disk('reposiciones')
                    ->put($nombreImagen,$fileget );
                    $j++;
                }

                $reposicion->cantArchivos = $j;
                $terminacionesArchivos = trim($terminacionesArchivos,'/');
                $reposicion->terminacionesArchivos=$terminacionesArchivos;
            }
            $reposicion->save();
            


            DB::commit();  
            return redirect()
                ->route('reposicionGastos.listar')
                ->with('datos','Se ha Editado la reposicion N°'.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError(' REPOSICION GASTOS CONTROLLER UPDATE' ,$th);
            
            DB::rollback();
            return redirect()
                ->route('reposicionGastos.listar')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }
















    /**GERENTE DE PROYECTOS */
    public function listarOfGerente(Request $request){
        $codProyectoBuscar=$request->codProyectoBuscar;
        $empleado=Empleado::getEmpleadoLogeado();
        $proyectos=Proyecto::where('codEmpleadoDirector','=',$empleado->codEmpleado)->get();
        $arr=[];
        foreach ($proyectos as $itemproyecto) {
            $arr[]=$itemproyecto->codProyecto;
        }
        

        if($codProyectoBuscar==0){
            $reposiciones=ReposicionGastos::whereIn('codProyecto',$arr)->paginate($this::PAGINATION);
        }else
            $reposiciones=ReposicionGastos::where('codProyecto','=',$codProyectoBuscar)->paginate($this::PAGINATION);
        
        $proyectos=Proyecto::whereIn('codProyecto',$arr)->get();

        return view('felix.GestionarReposicionGastos.Gerente.listarGeren',compact('reposiciones','empleado','codProyectoBuscar','proyectos'));
    }





    public function viewGeren($id){
      
        $reposicion=ReposicionGastos::findOrFail($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

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







    
    /**JEFE DE ADMINISTRACION */
    public function listarOfJefe(Request $request){
        $codProyectoBuscar=$request->codProyectoBuscar;
        $empleado=Empleado::getEmpleadoLogeado();
       
        $empleados=Empleado::where('codSede','=',$empleado->codSede)->get();
        $arr2=[];
        foreach ($empleados as $itemempleado) {
            $arr2[]=$itemempleado->codEmpleado;
        }
        $arr=[2,3,5,6,7];
        


        if($codProyectoBuscar==0){
            $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->whereIn('codEmpleadoSolicitante',$arr2)->paginate($this::PAGINATION);
        }else
            $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->whereIn('codEmpleadoSolicitante',$arr2)->where('codProyecto','=',$codProyectoBuscar)->paginate($this::PAGINATION);
        
        $proyectos=Proyecto::all();


        return view('felix.GestionarReposicionGastos.Jefe.listarJefe',compact('reposiciones','empleado','codProyectoBuscar','proyectos'));
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
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        return view('felix.GestionarReposicionGastos.Jefe.verJefe',compact('reposicion','empleadoLogeado','detalles'));
    }

    /**CONTADOR */
    public function listarOfConta(Request $request){
        $codProyectoBuscar=$request->codProyectoBuscar;
        $empleado=Empleado::getEmpleadoLogeado();
        $detalles=ProyectoContador::where('codEmpleadoContador','=',$empleado->codEmpleado)->get();
        //$proyectos=Proyecto::where('codEmpleadoConta','=',$empleado->codEmpleado)->get();
        $arr2=[];
        foreach ($detalles as $itemproyecto) {
            $arr2[]=$itemproyecto->codProyecto;
        }
        $arr=[3,4,5];
        

        if($codProyectoBuscar==0 || $codProyectoBuscar==null){
            $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->whereIn('codProyecto',$arr2)->paginate($this::PAGINATION);
        }else
            $reposiciones=ReposicionGastos::whereIn('codEstadoReposicion',$arr)->where('codProyecto','=',$codProyectoBuscar)->paginate($this::PAGINATION);
        
        $proyectos=Proyecto::whereIn('codProyecto',$arr2)->get();

        return view('felix.GestionarReposicionGastos.Contador.listarCont',compact('reposiciones','empleado','codProyectoBuscar','proyectos'));
    }
    public function viewConta($id){
        $reposicion=ReposicionGastos::find($id);
        $detalles=$reposicion->detalles();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('felix.GestionarReposicionGastos.Contador.verCont',compact('reposicion','empleadoLogeado','detalles'));
    }



    public function aprobar($id){//gerente
        try{
            DB::beginTransaction();
            $reposicion=ReposicionGastos::find($id);
            $reposicion->codEstadoReposicion =  ReposicionGastos::getCodEstado('Aprobada');
            $reposicion->codEmpleadoEvaluador=Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->fechaHoraRevisionGerente=new DateTime();
            $reposicion->save();
            DB::commit();
            //return redirect()->route('reposicionGastos.listarRepoOfGerente')->with('datos','Se aprobo correctamente la Reposicion '.$reposicion->codigoCedepas);
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Se aprobo correctamente la Reposicion '.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            //return redirect()->route('reposicionGastos.listarRepoOfGerente')->with('datos','Ha ocurrido un error');
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Ha ocurrido un error');
        }
    }
    public function abonar($id){//jefe (codReposicion)
        try{
            DB::beginTransaction();
            date_default_timezone_set('America/Lima');
            $reposicion=ReposicionGastos::find($id);
            $reposicion->codEstadoReposicion=ReposicionGastos::getCodEstado('Abonada');
            $reposicion->codEmpleadoAdmin=Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->fechaHoraRevisionAdmin=new DateTime();
            $reposicion->save();
            DB::commit();
            //return redirect()->route('reposicionGastos.listarRepoOfJefe')->with('datos','Se abono correctamente la Reposicion '.$reposicion->codigoCedepas);
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Se abono correctamente la Reposicion '.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            //return redirect()->route('reposicionGastos.listarRepoOfJefe')->with('datos','Ha ocurrido un error');
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Ha ocurrido un error');

        }
    }

    public function observar($id){//gerente-jefe-contador (codReposicion-observacion)
        try{
            DB::beginTransaction();
            $empleado = Empleado::getEmpleadoLogeado();

            date_default_timezone_set('America/Lima');
            $arr = explode('*', $id);
            $reposicion=ReposicionGastos::find($arr[0]);
            $empleado=Empleado::getEmpleadoLogeado();
            if($empleado->esJefeAdmin()){
                $reposicion->codEmpleadoAdmin=Empleado::getEmpleadoLogeado()->codEmpleado;
                $reposicion->fechaHoraRevisionAdmin=new DateTime();
            }else if($empleado->esContador()){
                $reposicion->codEmpleadoConta=Empleado::getEmpleadoLogeado()->codEmpleado;
                $reposicion->fechaHoraRevisionConta=new DateTime();
            }else{
                $reposicion->codEmpleadoEvaluador=Empleado::getEmpleadoLogeado()->codEmpleado;
                $reposicion->fechaHoraRevisionGerente=new DateTime();
            }
            $reposicion->codEstadoReposicion=ReposicionGastos::getCodEstado('Observada');
            $reposicion->observacion=$arr[1];
            
            $reposicion->save();
            DB::commit();
            /*
            if($empleado->esJefeAdmin()){
                return redirect()->route('reposicionGastos.listarRepoOfJefe')->with('datos','Se observo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }else if($empleado->esContador()){
                return redirect()->route('reposicionGastos.listarRepoOfContador')->with('datos','Se observo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }else{
                return redirect()->route('reposicionGastos.listarRepoOfGerente')->with('datos','Se observo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }
            */
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Se observo correctamente la Reposicion '.$reposicion->codigoCedepas);
            
        }catch(\Throwable $th){
            DB::rollBack();
            /*
            if($empleado->esJefeAdmin()){
                return redirect()->route('reposicionGastos.listarRepoOfJefe')->with('datos','Ha ocurrido un error');
            }else if($empleado->esContador()){
                return redirect()->route('reposicionGastos.listarRepoOfContador')->with('datos','Ha ocurrido un error');
            }else{
                return redirect()->route('reposicionGastos.listarRepoOfGerente')->with('datos','Ha ocurrido un error');
            }
            */
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Ha ocurrido un error');
        }
    }
    public function rechazar($id){//gerente-jefe (codReposicion)
        try{
            DB::beginTransaction();
            $reposicion=ReposicionGastos::find($id);
            $empleado=Empleado::getEmpleadoLogeado();


            if($empleado->codPuesto==Puesto::getCodigo('Jefe de Administración')){
                $reposicion->codEmpleadoAdmin=$empleado->codEmpleado;
                $reposicion->fechaHoraRevisionAdmin=new DateTime();
            }else{
                $reposicion->codEmpleadoEvaluador=$empleado->codEmpleado;
                $reposicion->fechaHoraRevisionGerente=new DateTime();
            }
            $reposicion->codEstadoReposicion=ReposicionGastos::getCodEstado('Rechazada');
            $reposicion->save();
            DB::commit();
            /*
            if($empleado->esJefeAdmin()){
                return redirect()->route('reposicionGastos.listarRepoOfJefe')->with('datos','Se rechazo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }else{
                return redirect()->route('reposicionGastos.listarRepoOfGerente')->with('datos','Se rechazo correctamente la Reposicion '.$reposicion->codigoCedepas);
            }
            */
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Se rechazo correctamente la Reposicion '.$reposicion->codigoCedepas);
        }catch(\Throwable $th){
            //Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            /*
            if($empleado->esJefeAdmin()){
                return redirect()->route('reposicionGastos.listarRepoOfJefe')->with('datos','Ha ocurrido un error');
            }else{
                return redirect()->route('reposicionGastos.listarRepoOfGerente')->with('datos','Ha ocurrido un error');
            }
            */
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Ha ocurrido un error');
        }

    }


    public function contabilizar($cadena){
        try {
            DB::beginTransaction();
            date_default_timezone_set('America/Lima');
            $vector = explode('*',$cadena);
            $codReposicion = $vector[0];
            $listaItems = explode(',',$vector[1]);

            $reposicion = ReposicionGastos::findOrFail($codReposicion);
            $reposicion->codEstadoReposicion =  ReposicionGastos::getCodEstado('Contabilizada');
            $reposicion->codEmpleadoConta = Empleado::getEmpleadoLogeado()->codEmpleado;
            $reposicion->fechaHoraRevisionConta=new DateTime();
            $reposicion->save();
            foreach ($listaItems as $item) { //guardamos como contabilizados los items que nos llegaron
                $detGasto = DetalleReposicionGastos::findOrFail($item);
                $detGasto->contabilizado = 1;
                $detGasto->save();   
            }

            DB::commit();
            /*
            return redirect()
                ->route('reposicionGastos.listarRepoOfContador')
                ->with('datos','Se contabilizó correctamente la Reposicion '.$reposicion->codigoCedepas);
            */
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Se contabilizó correctamente la Reposicion '.$reposicion->codigoCedepas);
        } catch (\Throwable $th) {
            Debug::mensajeError('REPOSICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            /*
            return redirect()->route('reposicionGastos.listarRepoOfContador')
                ->with('datos','Ha ocurrido un error');
            */
            return redirect()->route('reposicionGastos.listarReposiciones')->with('datos','Ha ocurrido un error');
        }


    }


    public function descargarPDF($id){
        $reposicion=ReposicionGastos::findOrFail($id);
        $pdf = $reposicion->getPDF();
        return $pdf->download('Reposicion de Gastos '.$reposicion->codigoCedepas.'.pdf');
    }
    
    public function verPDF($id){
        $reposicion=ReposicionGastos::findOrFail($id);
        $pdf = $reposicion->getPDF();
        return $pdf->stream();
    }







}

