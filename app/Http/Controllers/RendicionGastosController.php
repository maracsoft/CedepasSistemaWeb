<?php

namespace App\Http\Controllers;

use App\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\SolicitudFondos;
use App\Banco;
use App\DetalleSolicitudFondos;
use App\Proyecto;
use App\Sede;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;
use App\CDP;
use App\DetalleRendicionGastos;
use App\RendicionGastos;
use App\SolicitudFalta;
use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;


use App\Debug;
use App\Numeracion;
use PhpOffice\PhpWord;
use PhpOffice\PhpWord\Element\Cell;
use PhpOffice\PhpWord\Style\Font;



class RendicionGastosController extends Controller
{
    

    const PAGINATION = '20';
    const raizArchivo = "RendGast-CDP-";

    //RUTA MAESTRA QUE REDIRIJE A LOS INDEX DE LOS 3 ACTORES
    public function listarRendiciones(){

        $empleado = Empleado::getEmpleadoLogeado();
        $msj = session('datos');
        $datos='';
        if($msj!='')
            $datos = 'datos';

        if($empleado->esGerente()){
            //lo enrutamos hacia su index
            return redirect()->route('rendicionGastos.listarGerente')->with($datos,$msj);
        }

        if($empleado->esJefeAdmin())//si es jefe de administracion
        {
            return redirect()->route('rendicionGastos.listarJefeAdmin')->with($datos,$msj);
        }
        return redirect()->route('rendicionGastos.listarEmpleado')->with($datos,$msj);


    }

    public function listarContador(){
        $empleado = Empleado::getEmpleadoLogeado();
        
        //AQUI FALTA PREGUNTAR EL FILTRO POR EL QUE SE ORDENARAN Y APARECERAN PARA CADA CONTADOR
        
        //solo ver las que estan aprobadas (pa contabilizar)
        $listaRendiciones = RendicionGastos::
            where('codEstadoRendicion','=',RendicionGastos::getCodEstado('Aprobada') )
            ->orwhere('codEstadoRendicion','=',RendicionGastos::getCodEstado('Contabilizada'))
            ->get();
        
        //ordena la coleccion ascendentemente
        $listaRendiciones=$listaRendiciones->sortBy('codEstadoRendicion');

        //PARA PODER PAGINAR EL COLECTTION USE https://gist.github.com/iamsajidjaved/4bd59517e4364ecec98436debdc51ecc#file-appserviceprovider-php-L23
        $listaRendiciones=$listaRendiciones->paginate($this::PAGINATION);
        $buscarpor = '';
        return view('RendicionGastos.contador.listarRendiciones',compact('listaRendiciones','empleado','buscarpor'));
        


    }


    //retorna todas las rendiciones, tienen prioridad de ordenamiento las que están esperando reposicion
    public function listarJefeAdmin(){
        $listaRendiciones = RendicionGastos::where('codEstadoRendicion','>','0')
            ->orderby('codEstadoRendicion','ASC')
            ->get();

        $buscarpor = '';
        $empleado = Empleado::getEmpleadoLogeado();
        return view('RendicionGastos.administracion.listarRendiciones',compact('listaRendiciones','empleado','buscarpor'));
        
    }


    //lista todas las rendiciones del gerente (pertenecientes a los  proyectos que este lidera)
    public function listarDelGerente(){
        
        $empleado = Empleado::getEmpleadoLogeado();
        if(count($empleado->getListaProyectos())==0)
            return "ERROR: NO TIENE NINGUN PROYECTO ASIGNADO.";
        
        $listaRendiciones = $empleado->getListaRendicionesGerente();
        //ordena la coleccion ascendentemente
        $listaRendiciones=$listaRendiciones->sortBy('codEstadoRendicion');

        //PARA PODER PAGINAR EL COLECTTION USE https://gist.github.com/iamsajidjaved/4bd59517e4364ecec98436debdc51ecc#file-appserviceprovider-php-L23
        $listaRendiciones=$listaRendiciones->paginate($this::PAGINATION);
        
        $buscarpor = '';

        return view('RendicionGastos.gerente.listarRendiciones',compact('listaRendiciones','empleado','buscarpor'));
        
    }

    //retorna las rendiciones del emp logeado, tienen prioridad de ordenamiento las que están esperando reposicion
    public function listarEmpleado(){
        $empleado = Empleado::getEmpleadoLogeado();
        //primero agarramos las solicitudes del empleado logeado
        $listaSolicitudes = SolicitudFondos::where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
            ->get();

        //ahora agarramos de cada solicitud, su rendicion (si la tiene)
        $listaRendiciones= new Collection();
        for ($i=0; $i < count($listaSolicitudes); $i++) { //recorremos cada solicitud
            $itemSol = $listaSolicitudes[$i];
            if(!is_null($itemSol->codSolicitud)){ 
                $itemRend = RendicionGastos::
                    where('codSolicitud','=',$itemSol->codSolicitud)
                    ->first();
                if(!is_null($itemRend))
                    $listaRendiciones->push($itemRend);
            }
        }

        //ordena la coleccion ascendentemente
        $listaRendiciones=$listaRendiciones->sortBy('codEstadoRendicion');

        $buscarpor = '';
        //return $listaRendiciones;
        return view('RendicionGastos.empleado.listarRendiciones',
            compact('listaRendiciones','empleado','buscarpor'));
        
    }


    
   




    //del empleado
    public function ver($id){ 
        $rendicion = RendicionGastos::findOrFail($id);
        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$solicitud->codSolicitud)->get();
        
        return view('RendicionGastos.empleado.verRend',compact('rendicion','solicitud','empleado','detallesRend','detallesSolicitud'));
    }
    
    //despliuega vista de  rendicion, del admiin
    public function verAdmin($id){ //le pasamos la id de la solicitud de fondos a la que está enlazada
        $rendicion = RendicionGastos::findOrFail($id);

        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
        
        return view('RendicionGastos.administracion.verRend',compact('rendicion','solicitud','empleado','detallesRend'));     
    }


    //despliuega vista de  rendicion,
    public function verGerente($codRend){ 
        //le pasamos la id de la solicitud de fondos a la que está enlazada
        
        $rendicion = RendicionGastos::findOrFail($codRend);
        
        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
        
        return view('RendicionGastos.gerente.revisarRend',compact('rendicion','solicitud','empleado','detallesRend'));        
    }

    //despliuega vista de  contabilizar rendicion,
    public function verContabilizar($id){ //le pasamos la id de la rend
        $rendicion = RendicionGastos::findOrFail($id);
        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();

        return view('RendicionGastos.contador.contabilizarRend',compact('rendicion','solicitud','empleado','detallesRend'));
    }

    public function contabilizar($cadena ){
        
        try {
            DB::beginTransaction(); 
            $vector = explode('*',$cadena);
            $codRendicion = $vector[0];
            $listaItems = explode(',',$vector[1]);

            $rendicion = RendicionGastos::findOrFail($codRendicion);
            $rendicion->codEstadoRendicion =  RendicionGastos::getCodEstado('Contabilizada');
            $rendicion->codEmpleadoContador = Empleado::getEmpleadoLogeado()->codEmpleado;
            $rendicion->save();
            foreach ($listaItems as $item) {
                $detGasto = DetalleRendicionGastos::findOrFail($item);
                $detGasto->contabilizado = 1;
                $detGasto->save();   
            }
            DB::commit();
            return redirect()->route('rendicionGastos.listarContador')->with('datos','Se contabilizó correctamente la Rendicion '.$rendicion->codigoCedepas);
        } catch (\Throwable $th) {
            Debug::mensajeError('RENDICION GASTOS CONTROLLER CONTABILIZAR', $th);
            DB::rollBack();
            return redirect()->route('rendicionGastos.listarContador')->with('datos','Ha ocurrido un error');
        }


    }



    public function verReponer($id){ //le pasamos la id de la solicitud de fondos a la que está enlazada
        $listaRend = RendicionGastos::where('codSolicitud','=',$id)->get();
        $rendicion = $listaRend[0];

        $solicitud = SolicitudFondos::findOrFail($id);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
        
        return view('RendicionGastos.administracion.verReponer',compact('rendicion','solicitud','empleado','detallesRend'));
    }



    //despliega vista de edicion
    public function editar($idRendicion){
        $rendicion = RendicionGastos::findOrFail($idRendicion);
        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $listaCDP = CDP::All();
        return view('RendicionGastos.empleado.editRendFondos',compact('rendicion','solicitud','listaCDP'));

    }


    public function revisar($id){ //le pasamos la id de la rendicion de gastos
        $rendicion = RendicionGastos::findOrFail($id);

        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rendicion->codRendicionGastos)->get();
        
        return view('RendicionGastos.gerente.revisarRend',compact('rendicion','solicitud','empleado','detallesRend'));
    }



    public function rechazar($codRendicion){
        try{

            DB::beginTransaction();
            error_log('cod rend = '.$codRendicion);
            $rendicion = RendicionGastos::findOrFail($codRendicion);
            $rendicion->codEstadoRendicion = RendicionGastos::getCodEstado('Rechazada');
            
            $empleadoLogeado = Empleado::getEmpleadoLogeado();
            $rendicion->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $rendicion->fechaHoraRevisado = Carbon::now();

            $rendicion->save();
            DB::commit();
            return redirect()->route('rendicionGastos.listarRendiciones')
            ->with('datos','Rendicion '.$rendicion->codigoCedepas.' Rechazada');

        } catch (\Throwable $th) {
            error_log('
            
                OCURRIO UN ERROR EN RENDICION GASTOS CONTROLLER : RECHAZAR
            
                '.$th.'

            ');

            DB::rollBack();
            return redirect()->route('rendicionGastos.listarRendiciones')
            ->with('datos','Ha ocurrido un error');
        }

    }

    
    public function aprobar($codRendicion){
        try{

            DB::beginTransaction();
            error_log('cod rend = '.$codRendicion);
            $rendicion = RendicionGastos::findOrFail($codRendicion);
            $rendicion->codEstadoRendicion = RendicionGastos::getCodEstado('Aprobada');
            
            $empleadoLogeado = Empleado::getEmpleadoLogeado();
            $rendicion->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $rendicion->fechaHoraRevisado = Carbon::now();

            $rendicion->save();
            DB::commit();
            return redirect()->route('rendicionGastos.listarRendiciones')
            ->with('datos','Rendicion '.$rendicion->codigoCedepas.' Aprobada');

        } catch (\Throwable $th) {
            error_log('
            
                OCURRIO UN ERROR EN RENDICION GASTOS CONTROLLER : APROBAR
            
                '.$th.'

            ');

            DB::rollBack();
            return redirect()->route('rendicionGastos.listarRendiciones')
            ->with('datos','Ha ocurrido un error');
        }

    }




    public function observar($cadena){

        try{
            $vector = explode('*',$cadena);
            if(count($vector)<2)
                throw new Exception('El argumento cadena no es valido');

            $codRendicion = $vector[0];
            $textoObs = $vector[1];

            DB::beginTransaction();
            error_log('cod rend = '.$codRendicion);
            $rendicion = RendicionGastos::findOrFail($codRendicion);
            $rendicion->codEstadoRendicion = RendicionGastos::getCodEstado('Observada');
            $rendicion->observacion = $textoObs;
            error_log('
            
            
            
            razon request:'.$textoObs);
            $empleadoLogeado = Empleado::getEmpleadoLogeado();
            $rendicion->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $rendicion->fechaHoraRevisado = Carbon::now();
            

            $rendicion->save();
            DB::commit();
            return redirect()->route('rendicionGastos.listarRendiciones')
            ->with('datos','Rendicion '.$rendicion->codigoCedepas.' Observada');

        } catch (\Throwable $th) {
            error_log('
            
                OCURRIO UN ERROR EN RENDICION GASTOS CONTROLLER : OBSERVAR
            
                '.$th.'


            ');

            DB::rollBack();
            return redirect()->route('rendicionGastos.listarRendiciones')
            ->with('datos','Ha ocurrido un error');
        }

    }












    //en este caso el terminacionArchivo se llena con la terminacion del cbte de abono del pago de cedepas al empleado
    // se le devuelve al empleado los gastos que hizo en exceso
    //deprecato
    /* public function reponer(Request $request){ //id de la rendicion

        $rendicion = RendicionGastos::findOrFail($request->codRendicionGastos);
        
        
        try{
            db::beginTransaction();
        
            //cambiamos el estado de la rendicion
            $rendicion->codEstadoRendicion = RendicionGastos::getCodEstado('Repuesta a Favor');
            
            //guardamos el archivo comprobante del abono


            //ESTA WEA ES PARA SACAR LA TERMINACIONDEL ARCHIVO
            $nombreImagen = $request->get('nombreImgImagenEnvio');  //sacamos el nombre completo
            $vec = explode('.',$nombreImagen); //separamos con puntos en un vector 
            $terminacion = end( $vec); //ultimo elemento del vector
            
            
            $rendicion->terminacionArchivo = $terminacion; //guardamos la terminacion para poder usarla luego
            //               RF-Repos-                           -   5   .  jpg
            $nombreImagen =
                 'RF-Repos-'.
                 $this->rellernarCerosIzq($rendicion->codRendicionGastos,6)
                 .'.'.
                 $terminacion;

            error_log('
            AA
            '.$nombreImagen.'
            
            ');
            
            $archivo =  $request->file('imagenEnvio');
            $fileget = \File::get( $archivo );
            Storage::disk('comprobantesAbono')
            ->put($nombreImagen, $fileget );


            $rendicion->save();
            db::commit();

            return redirect()->route('rendicionGastos.listarRendiciones')->with('datos','Gastos repuestos efectivamente');
        }catch(Exception $e){

            error_log('\\n ---------------------- RENDICION FONDOS CONTROLLER REPONER 
            Ocurrió el error:'.$e->getMessage().'
            
            
            ' );

            DB::rollback();
            return redirect()
                ->route('rendicionGastos.listarRendiciones')
                ->with('datos','Ha ocurrido un error.');
        }


    } */
    
    
    
    
    
    
    
    
    
    
    /* 
    ALMACENAR LOS DATOS Y LOS ARCHIVOS DE DETALLES QUE ESTAN SUBIENDO
    CADA ARCHIVO ES UNA FOTO DE UN CDP, pero están independientes xd o sea un archivo no está ligado necesariamente a un item de gasto 

    https://www.itsolutionstuff.com/post/laravel-7-multiple-file-upload-tutorialexample.html
    */
    public function store( Request $request){
        try {
           
                DB::beginTransaction();   
            $solicitud = SolicitudFondos::findOrFail($request->codigoSolicitud);
            $solicitud ->estaRendida = 1; //cambiamos el estaod de la solicitud a rendida
            $solicitud->save();

            $rendicion = new RendicionGastos();
            $rendicion-> codSolicitud = $solicitud->codSolicitud;
           
            $rendicion-> totalImporteRecibido = $solicitud->totalSolicitado; //ESTE ES EL DE LA SOLICITUD
            $rendicion-> totalImporteRendido = $request->totalRendido;
            $rendicion-> saldoAFavorDeEmpleado = $rendicion->totalImporteRendido - $rendicion->totalImporteRecibido;
            $rendicion-> resumenDeActividad = $request->resumen;
            $rendicion-> fechaRendicion = Carbon::now();
            $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Creada');
            $rendicion->codMoneda = $solicitud->codMoneda;

            $rendicion->codigoCedepas = RendicionGastos::calcularCodigoCedepas(Numeracion::getNumeracionREN());
            Numeracion::aumentarNumeracionREN();
            

            $rendicion-> save();    
            $codRendRecienInsertada = (RendicionGastos::latest('codRendicionGastos')->first())->codRendicionGastos;
            

            $vec[] = '';
            
            //PRIMERO RECORREMOS la tabla con gastos 
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleRendicionGastos();
                $detalle->codRendicionGastos=          $codRendRecienInsertada ;//ultimo insertad
                // formato requerido por sql 2021-02-11   
                //formato dado por mi calnedar 12/02/2020
                $fechaDet = $request->get('colFecha'.$i);
                //DAMOS VUELTA A LA FECHA
                                                // AÑO                  MES                 DIA
                $detalle->fecha=                 substr($fechaDet,6,2).substr($fechaDet,3,2).substr($fechaDet,0,2);
                $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                $detalle->concepto=              $request->get('colConcepto'.$i);
                $detalle->importe=               $request->get('colImporte'.$i);    
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                $detalle->nroEnRendicion = $i+1;         
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
                $nombreImagen = $this::raizArchivo.$this->rellernarCerosIzq($codRendRecienInsertada,6).'-'.$this->rellernarCerosIzq($j+1,2).'.'.$terminacion  ;
                Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                $fileget = \File::get( $archivo );
                Debug::mensajeSimple('LLEGO 4 ');
                Storage::disk('rendiciones')
                ->put($nombreImagen,$fileget );
                $j++;
            }

            $rendicion->cantArchivos = $j;
            $terminacionesArchivos = trim($terminacionesArchivos,'/');
            $rendicion->terminacionesArchivos=$terminacionesArchivos;

            $rendicion->save();
            Debug::mensajeSimple('LLEGO 5 ');

            DB::commit();  
            return redirect()
                ->route('rendicionGastos.listarRendiciones')
                ->with('datos','Se ha creado la rendicion N°'.$rendicion->codigoCedepas);
        }catch(Exception $e){

            error_log('\\n ---------------------- RENDICION GASTOS CONTROLLER STORE 
            Ocurrió el error:'.$e->getMessage().'
            
            
            ' );

            DB::rollback();
            return redirect()
                ->route('rendicionGastos.listarRendiciones')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }




















    public function prueba(){

        
        $string = 'SOF ES '.Numeracion::getNumeracionSOF()->numeroLibreActual;

        Numeracion::aumentarNumeracionSOF();
        $string .= 'SOF NUEVO ES '.Numeracion::getNumeracionSOF()->numeroLibreActual;


        
        return $string;

    }  

    //retorna un vector de enteros
    public static function getCodigosDetallesDeRendicion($codRendicion){
        $lista = DetalleRendicionGastos::Select('codDetalleRendicion')
        ->where('codRendicionGastos','=',$codRendicion)
        ->get()
        ->toArray();
        $vector = [];
        for ($i=0; $i <count($lista); $i++) { 
            $elemento = $lista[$i]['codDetalleRendicion'];
            array_push($vector,$elemento);
        }
        return $vector;
    }
    //ESTAS DOS FUNCIONES SON PAREJA, LAS USO A LA VEZ
    //retora vector de strings 
    public static function getTerminacionesArchivoDetallesDeRendicion($codRendicion){
        $lista = DetalleRendicionGastos::Select('codDetalleRendicion','terminacionArchivo')
        ->where('codRendicionGastos','=',$codRendicion)
        ->get()
        ->toArray();
        $vector = [];
        for ($i=0; $i <count($lista); $i++) { 
            $elemento= $lista[$i]['terminacionArchivo'];   
            array_push($vector,$elemento);
        }
        return $vector;
    }
    


    public function update( Request $request){
        try {

            
            DB::beginTransaction();   
            $rendicion = RendicionGastos::findOrFail($request->codRendicion);
            $rendicion-> totalImporteRendido = $request->totalRendido;
            $rendicion-> saldoAFavorDeEmpleado = $rendicion->totalImporteRendido - $rendicion->totalImporteRecibido;
            $rendicion-> resumenDeActividad = $request->resumen;
            
            //si estaba observada, pasa a subsanada
            if($rendicion->verificarEstado('Observada'))
                $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Subsanada');
            else
                $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Creada');
            $rendicion-> save();        
            
            //borramos todos los detalles pq los ingresaremos again
            DB::select('delete from detalle_rendicion_gastos where codRendicionGastos=" '.$rendicion->codRendicionGastos.'"');

            //RECORREMOS la tabla con gastos 
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleRendicionGastos();
                $detalle->codRendicionGastos=          $rendicion->codRendicionGastos ;//ultimo insertad
                // formato requerido por sql 2021-02-11   
                //formato dado por mi calnedar 12/02/2020
                $fechaDet = $request->get('colFecha'.$i);
                //DAMOS VUELTA A LA FECHA
                                                // AÑO                  MES                 DIA
                $detalle->fecha=                 substr($fechaDet,6,2).substr($fechaDet,3,2).substr($fechaDet,0,2);
                $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                $detalle->concepto=              $request->get('colConcepto'.$i);
                $detalle->importe=               $request->get('colImporte'.$i);    
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                $detalle->nroEnRendicion = $i+1;          
                $i=$i+1;
                $detalle->save();

            }    


            //SOLO BORRAMOS TODO E INSERTAMOS NUEVOS ARCHIVOS SI ES QUE SE INGRESÓ NUEVOS
            if( $request->nombresArchivos!='' ){
                $rendicion->borrarArchivosCDP();
                
                $nombresArchivos = explode(', ',$request->nombresArchivos);
                $terminacionesArchivos='';   $j=0;
                foreach ($request->file('filenames') as $archivo) //guardamos los que se insertaron ahora 
                {   
              
                    //separamos con puntos en un vector 
                    $vectorS = explode('.',$nombresArchivos[$j]);
                    $terminacion = end($vectorS); //ultimo elemento del vector
                    $terminacionesArchivos=$terminacionesArchivos.'/'.$terminacion;
                    
                    //               CDP-   000002                           -   5   .  jpg
                    $nombreImagen = RendicionGastos::getFormatoNombreCDP($rendicion->codRendicionGastos ,$j+1 ,$terminacion ) ;
                    Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);

                    $fileget = \File::get( $archivo );
                
                    Storage::disk('rendiciones')
                    ->put($nombreImagen,$fileget );
                    $j++;
                }

                $rendicion->cantArchivos = $j;
                $terminacionesArchivos = trim($terminacionesArchivos,'/');
                $rendicion->terminacionesArchivos=$terminacionesArchivos;
            }
            $rendicion->save();
            


            DB::commit();  
            return redirect()
                ->route('rendicionGastos.listarRendiciones')
                ->with('datos','Se ha Editado la rendicion N°'.$rendicion->codigoCedepas);
        }catch(\Throwable $th){
            Debug::mensajeError(' RENDICION GASTOS CONTROLLER UPDATE' ,$th);
            
            DB::rollback();
            return redirect()
                ->route('rendicionGastos.listarRendiciones')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }


    



    function rellernarCerosIzq($numero, $nDigitos){
       return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);

    }


    //se le pasa el INDEX del archivo 
    function descargarCDP($cadena){
        
        $vector = explode('*',$cadena);
        $codRend = $vector[0];
        $i = $vector[1];
        
        $rendicion = RendicionGastos::findOrFail($codRend);
        $nombreArchivo = RendicionGastos::getFormatoNombreCDP(
                $rendicion->codRendicionGastos,$i,$rendicion->getTerminacionNro($i)
        );
 
        return Storage::download("/comprobantes/rendiciones/".$nombreArchivo);

    }



    //descarga el archivo que subió el empleado pq le sobró dinero  
    // o tambien el archivo de reposicion de cedepas hacia el empleado
    //DEPRECATO
    /* function descargarArchivoRendicion($id){
        
        $rendicion = RendicionGastos::findOrFail($id);
        if($rendicion->codEstadoRendicion== RendicionGastos::getCodEstado('Repuesta a Favor') )
            $prefijo = 'Repos';
        if($rendicion->codEstadoRendicion== RendicionGastos::getCodEstado('Rendida en contra')    )
            $prefijo = 'Devol';
        
        $nombreArchivo = $this::raizArchivo.$this->rellernarCerosIzq($id,6).'.'.$rendicion->terminacionArchivo ;
        
        
        return Storage::download("comprobantesAbono/".$nombreArchivo);

    } */













    public function reportes(Request $request){

        try 
        {
              

            $fechaI = $request->fechaI;
            $fechaF = $request->fechaF;
            
            $tipoInforme = $request->tipoInforme;

           
            switch ($tipoInforme) {
                case '1': //POR SEDES
                    //Reporte de las sumas acumuladas de los gastos de cada sede, con fecha inicio y fecha final
                    $listaX = RendicionGastos::reportePorSedes($fechaI,$fechaF);
                    
                    return view('RendicionGastos.administracion.reportes.reporteSedes',compact('listaX','fechaI','fechaF'));
                    


                    break;
                case '2': //POR EMPLEADOS
                    //Reporte de las sumas acumuladas de los gastos de cada empleado, con fecha inicio y fecha final

                    $listaX = RendicionGastos::reportePorEmpleados($fechaI,$fechaF);
                    
                    return view('RendicionGastos.administracion.reportes.reporteEmpleado',compact('listaX','fechaI','fechaF'));
                    break;
                case '3':

                    $listaX = RendicionGastos::reportePorProyectos($fechaI,$fechaF);
                    return view('RendicionGastos.administracion.reportes.reporteProyectos',compact('listaX','fechaI','fechaF'));
                
                    break;
                
                case '4':
                    $sede  = Sede::findOrFail($request->ComboBoxSede);
                    $listaX = RendicionGastos::reportePorSedeYEmpleados($fechaI,$fechaF,$sede->codSede);

                return view('RendicionGastos.administracion.reportes.reporteEmpleadoXSede',compact('listaX','fechaI','fechaF','sede'));
                    break;

                            
                default:
                    # code...
                    break;
            }

        } catch (\Throwable $th) {
            

            error_log('\\n ----------------------  RENDICION GASTOS : REPORTES
            Ocurrió el error:'.$th->getMessage().'


            ' );

            return $th->getMessage();

        }
    }



    public function descargarReportes($string){
        try 
        {
            error_log('----------------------------------------------------------'.$string);
            $vector = explode('*',$string);

            
            
            $fechaI      = $vector[0];
            $fechaF      = $vector[1];
            $tipoInforme = $vector[2];
            if ($tipoInforme == 4)
                $codSede = $vector[3];

            $nombreVista = '';
            $argumentosVista ='';
            switch ($tipoInforme) {
                case '1': //POR SEDES
                    //Reporte de las sumas acumuladas de los gastos de cada sede, con fecha inicio y fecha final
                    //return $fechaI;
                    //return $fechaF;
                    $listaX = RendicionGastos::reportePorSedes($fechaI,$fechaF);
                    
                // return  $listaX;
                $nombreVista = 'RendicionGastos.administracion.reportes.reporteSedes';
                $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);


                    break;
                case '2': //POR EMPLEADOS
                    //Reporte de las sumas acumuladas de los gastos de cada empleado, con fecha inicio y fecha final

                    $listaX = RendicionGastos::reportePorEmpleados($fechaI,$fechaF);
                    

                    $nombreVista = 'RendicionGastos.administracion.reportes.reporteEmpleado';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);
                    
                    break;
                case '3':

                    $listaX = RendicionGastos::reportePorProyectos($fechaI,$fechaF);
                    

                    $nombreVista = 'RendicionGastos.administracion.reportes.reporteProyectos';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);
                    
                    
                break;
                case '4':
                    $sede = Sede::findOrFail($codSede);
                    $listaX = RendicionGastos::reportePorSedeYEmpleados($fechaI,$fechaF,$codSede);


                    $nombreVista = 'RendicionGastos.administracion.reportes.reporteEmpleadoXSede';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI,'sede'=>$sede);
                            
                    
                    break;

                            
                default:
                    # code...
                    break;
            }
          

            $pdf = new PDF();
       
            
            $pdf = PDF::loadView($nombreVista,$argumentosVista)->setPaper('a4','landscape');
            return $pdf->download('informeMiau.pdf');

        } catch (\Throwable $th) {
        
            error_log('\\n ----------------------  RENDICIONGASTOS: DESCARGAR REPORTES
            Ocurrió el error:'.$th->getMessage().'


            ' );

        }
    }

    
    //funcion servicio, será consumida solo por javascript
    public function listarDetalles($idRendicion){
        $vector = [];
        $listaDetalles = DetalleRendicionGastos::where('codRendicionGastos','=',$idRendicion)->get();
        for ($i=0; $i < count($listaDetalles) ; $i++) { 
            
            $itemDet = $listaDetalles[$i];
            $itemDet['nombreTipoCDP'] = $itemDet->getNombreTipoCDP(); //tengo que pasarlo aqui pq en el javascript no hay manera de calcularlo, de todas maneras no lo usaré como Modelo (objeto)
            $itemDet['nombreImagen'] = 'RendGast-CDP-'.$this->rellernarCerosIzq($itemDet->codRendicionGastos,6).'-'.$this->rellernarCerosIzq($i+1,2).'.'.$itemDet->terminacionArchivo;
                // formato dado por sql 2021-02-11   
                //formato requerido por mi  12/02/2020
                $fechaDet = $itemDet->fecha;
                //DAMOS VUELTA A LA FECHA
                                // DIA                  MES                 AÑO
            $nuevaFecha=substr($fechaDet,8,2).'/'.substr($fechaDet,5,2).'/'.substr($fechaDet,0,4);
            $itemDet['fechaFormateada'] = $nuevaFecha;
            array_push($vector,$itemDet);            
        }
        return $vector  ;
    }

    public function descargarPDF($codRendicion){
        $rendicion = RendicionGastos::findOrFail($codRendicion);
        $pdf = $rendicion->getPDF();
        return $pdf->download('Rendición de Gastos '.$rendicion->codigoCedepas.'.pdf');
    }   
    
    public function verPDF($codRendicion){
        $rendicion = RendicionGastos::findOrFail($codRendicion);
        $pdf = $rendicion->getPDF();
        return $pdf->stream();
    }


}
