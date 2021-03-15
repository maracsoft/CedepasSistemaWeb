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

    //retorna todas las rendiciones, tienen prioridad de ordenamiento las que están esperando reposicion
    public function listarJefeAdmin(){
        $listaRendiciones = RendicionGastos::where('codEstadoRendicion','>','0')
            ->orderby('codEstadoRendicion','ASC')
            ->get();

        $buscarpor = '';
        $empleado = Empleado::getEmpleadoLogeado();
        return view('vigo.jefe.listarRendiciones',compact('listaRendiciones','empleado','buscarpor'));
        
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

        return view('vigo.gerente.listarRendiciones',compact('listaRendiciones','empleado','buscarpor'));
        
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
        return view('vigo.empleado.listarRendiciones',
            compact('listaRendiciones','empleado','buscarpor'));
        
    }


    




    //del empleado
    public function ver($id){ //le pasamos la id de la solicitud de fondos a la que está enlazada
        $listaRend = RendicionGastos::where('codSolicitud','=',$id)->get();
        $rend = $listaRend[0];

        $solicitud = SolicitudFondos::findOrFail($id);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rend->codRendicionGastos)->get();

        return view('vigo.empleado.verRend',compact('rend','solicitud','empleado','detallesRend'));
    }

    //despliuega vista de  rendicion, del admiin
    public function verAdmin($id){ //le pasamos la id de la solicitud de fondos a la que está enlazada
        $listaRend = RendicionGastos::where('codSolicitud','=',$id)->get();
        $rend = $listaRend[0];

        $solicitud = SolicitudFondos::findOrFail($id);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rend->codRendicionGastos)->get();

        return view('vigo.jefe.verRend',compact('rend','solicitud','empleado','detallesRend'));
    }


    //despliuega vista de  rendicion,
    public function verGerente($id){ //le pasamos la id de la solicitud de fondos a la que está enlazada
        $listaRend = RendicionGastos::where('codSolicitud','=',$id)->get();
        $rend = $listaRend[0];

        $solicitud = SolicitudFondos::findOrFail($id);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rend->codRendicionGastos)->get();

        return view('vigo.gerente.verRend',compact('rend','solicitud','empleado','detallesRend'));
    }


    public function verReponer($id){ //le pasamos la id de la solicitud de fondos a la que está enlazada
        $listaRend = RendicionGastos::where('codSolicitud','=',$id)->get();
        $rend = $listaRend[0];

        $solicitud = SolicitudFondos::findOrFail($id);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rend->codRendicionGastos)->get();
        
        return view('vigo.jefe.verReponer',compact('rend','solicitud','empleado','detallesRend'));
    }



    //despliega vista de edicion
    public function editar($idRendicion){
        $rendicion = RendicionGastos::findOrFail($idRendicion);
        $solicitud = SolicitudFondos::findOrFail($rendicion->codSolicitud);
        $listaCDP = CDP::All();
        return view('vigo.empleado.editRendFondos',compact('rendicion','solicitud','listaCDP'));

    }


    public function revisar($id){ //le pasamos la id de la rendicion de gastos
        $rend = RendicionGastos::findOrFail($id);

        $solicitud = SolicitudFondos::findOrFail($rend->codSolicitud);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rend->codRendicionGastos)->get();
        
        return view('vigo.gerente.revisarRend',compact('rend','solicitud','empleado','detallesRend'));
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
            return redirect()->route('rendicionGastos.listarSolicitudes')
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
    
    
    
    
    
    
    
    
    
    
    /* ALMACENAR LOS DATOS Y LOS ARCHIVOS DE DETALLES QUE ESTAN SUBIENDO
    CADA ARCHIVO ES UNA FOTO DE UN CDP, O SEA DE UN DETALLE
    */
    public function store( Request $request){
        try {
           
                DB::beginTransaction();   
            $solicitud = SolicitudFondos::findOrFail($request->codigoSolicitud);
            $rendicion = new RendicionGastos();
            $rendicion-> codSolicitud = $solicitud->codSolicitud;
            $rendicion-> codigoCedepas = $request->codRendicion; 
            $rendicion-> totalImporteRecibido = $solicitud->totalSolicitado; //ESTE ES EL DE LA SOLICITUD
            $rendicion-> totalImporteRendido = $request->totalRendido;
            $rendicion-> saldoAFavorDeEmpleado = $rendicion->totalImporteRendido - $rendicion->totalImporteRecibido;
            $rendicion-> resumenDeActividad = $request->resumen;
            $rendicion-> fechaRendicion = Carbon::now();
            $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Creada');
            
            $rendicion-> save();    
            
            $codRendRecienInsertada = (RendicionGastos::latest('codRendicionGastos')->first())->codRendicionGastos;
            
            $vec[] = '';
            
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
                
                
                
                //ESTA WEA ES PARA SACAR LA TERMINACIONDEL ARCHIVO
                $nombreImagen = $request->get('nombreImg'.$i);  //sacamos el nombre completo
                $vec = explode('.',$nombreImagen); //separamos con puntos en un vector 
                $terminacion = end( $vec); //ultimo elemento del vector
                
                $detalle->terminacionArchivo = $terminacion; //guardamos la terminacion para poder usarla luego

                
                //               CDP-   000002                           -   5   .  jpg
                $nombreImagen = $this::raizArchivo.$this->rellernarCerosIzq($detalle->codRendicionGastos,6).'-'.$this->rellernarCerosIzq($i+1,2).'.'.$terminacion  ;
                Debug::mensajeSimple('el nombre de la imagen es:'.$nombreImagen);
                $archivo =  $request->file('imagen'.$i);
                $fileget = \File::get( $archivo );
                Storage::disk('rendiciones')
                ->put($nombreImagen,$fileget );
               
                $vec[$i] = $detalle;
                $detalle->save();
                                   
                $i=$i+1;
            }    
            
            //cambiamos el estaod de la solicitud a rendida
            $solicitud ->codEstadoSolicitud = SolicitudFondos::getCodEstado('Rendida');
            $solicitud->save();

            DB::commit();  
            return redirect()
                ->route('solicitudFondos.listarEmp')
                ->with('datos','Se ha creado la rendicion N°'.$rendicion->codigoCedepas);
        }catch(Exception $e){

            error_log('\\n ---------------------- RENDICION FONDOS CONTROLLER STORE 
            Ocurrió el error:'.$e->getMessage().'
            
            
            ' );

            DB::rollback();
            return redirect()
                ->route('solicitudFondos.listarEmp')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }




















    public function prueba(){
        Storage::disk('rendiciones')->delete('hola.txt');

        $listaDetallesAnteriores = $this->getTerminacionesArchivoDetallesDeRendicion(215);       
        return $listaDetallesAnteriores;
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
            
            //en este vector guardaremos los cod de detalles que no hayan venido en el request (o sea los borraron)
            $vectorCodigosDetAnteriores = $this::getCodigosDetallesDeRendicion($rendicion->codRendicionGastos);
            //aqui lo mismo pero sus terminaciones de archivo
            $vectorTermDetAnteriores = $this::getTerminacionesArchivoDetallesDeRendicion($rendicion->codRendicionGastos);
            


            //si estaba observada, pasa a subsanada
            if($rendicion->verificarEstado('Observada'))
                $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Subsanada');
            else
                $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Creada');
            
            $rendicion-> save();    
            
           
            
            $i = 0;
            $cantidadFilas = $request->cantElementos; //cant filas en la tabla del form
         
            //RECORREMOS CADA FILA DE LA TABLA DEL FORMULARIO
            while ($i < $cantidadFilas ) 
            {
                Debug::mensajeSimple('ENTRÓ AL WHILE CON : '.implode('/',$vectorCodigosDetAnteriores)); 
                //Si es nuevo el detalle, que lo guarde, sino que ni lo toque
                if( str_contains($request->get('nombreImg'.$i),$this::raizArchivo) ){ 
                    //ya existe (no se modificó nada en este item)
                    Debug::mensajeSimple('ITEM '.$i.' YA EXISTE Y NO SE HIZO NADA  ');
                    $posicionAEliminar = array_search($request->get('codDetRend'.$i),$vectorCodigosDetAnteriores);
                     //eliminamos ese codDetalle de la lista de no encontrados porque ya lo encontramos
                    array_splice($vectorCodigosDetAnteriores,$posicionAEliminar ,1);
                }
                else
                {
                    

                    /*Ahora hay 2 casos, 
                     1. Este es un nuevo detalle creado de 0                ( request->codDetRend[$i] será 0 )
                     2. Este detalle ya existía pero se le cambió la imagen ( !=0)
                    */
                    if($request->get('codDetRend'.$i) == '0'){ //NUEVO
                        Debug::mensajeSimple('ITEM '.$i.' ES NUEVO Y LO VAMOS A ALMACENAR  ');
                            
                        $detalle=new DetalleRendicionGastos();
                        $detalle->codRendicionGastos=          $rendicion->codRendicionGastos ;//ultimo insertad
                        
                        $fechaDet = $request->get('colFecha'.$i);
                        //DAMOS VUELTA A LA FECHA  pq formato requerido por sql 2021-02-11   formato dado por mi calnedar 12/02/2020
                                                        // AÑO                  MES                 DIA
                        $detalle->fecha=                 substr($fechaDet,6,2).substr($fechaDet,3,2).substr($fechaDet,0,2);
                        $detalle->setTipoCDPPorNombre( $request->get('colTipo'.$i) );
                        $detalle->nroComprobante=        $request->get('colComprobante'.$i);
                        $detalle->concepto=              $request->get('colConcepto'.$i);
                        $detalle->importe=               $request->get('colImporte'.$i);    
                        $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);   
                        $detalle->nroEnRendicion = $i+1;
                    }
                    else
                    { //YA EXISTE Y SE LE CAMBIÓ EL ARCHIVO 
                        Debug::mensajeSimple('ITEM '.$i.' YA EXISTE Y LE CAMBIAREMOS EL ARCHIVO');

                        $detalle = DetalleRendicionGastos::findOrFail( $request->get('codDetRend'.$i)  );
                        //ahora debemos sobreescribir el archivo que ya tiene
                        $detalle->nroEnRendicion = $request->get('nroEnRendicion'.$i);  
                        
                        //eliminamos ese codDetalle porque ya lo encontramos
                        $posicionAEliminar = array_search($request->get('codDetRend'.$i),$vectorCodigosDetAnteriores); 
                        array_splice($vectorCodigosDetAnteriores,$posicionAEliminar ,1);

                        //BORRAMOS EL ARCHIVO QUE TENIA PORQUE INSERTAREMOS OTRO
                        $nombreDelArchivo = 
                                    $this::raizArchivo.
                                    $this->rellernarCerosIzq($detalle->codRendicionGastos,6).
                                    '-'.
                                    $this->rellernarCerosIzq($i+1,2).
                                    '.'.
                                    $detalle->terminacionArchivo; //anterior terminacion
                        Debug::mensajeSimple('toy borrando el archivo '.$nombreDelArchivo);
                        Storage::disk('rendiciones')->delete($nombreDelArchivo);

                    }
                    
                    //              Ahora almacenamos el archivo 
                    Debug::mensajeSimple('HASTA EL CUATRO ');

                    // PARA SACAR LA TERMINACIONDEL ARCHIVO
                    $nombreImagen = $request->get('nombreImg'.$i);  //sacamos el nombre completo
                    $vec = explode('.',$nombreImagen); //separamos con puntos en un vector 
                    $terminacion = end( $vec); //ultimo elemento del vector
                    
                    $detalle->terminacionArchivo = $terminacion; //guardamos la terminacion para poder usarla luego

                 
                    //               CDP-   000002                           -   5   .  jpg
                    $nombreImagen = $this::raizArchivo.$this->rellernarCerosIzq($detalle->codRendicionGastos,6).'-'.$this->rellernarCerosIzq($i+1,2).'.'.$terminacion ;
                    $archivo =  $request->file('imagen'.$i);
                    $fileget = \File::get( $archivo );
                   
                    Storage::disk('rendiciones')->put($nombreImagen,$fileget );
                    
                    $vec[$i] = $detalle;
                    $detalle->save();
               
                    

                } //fin if
                $i=$i+1;
            }//fin while

            Debug::mensajeSimple('SALE DEL WHILE CON vectorDetallesAnt=: '.implode(',',$vectorCodigosDetAnteriores));

            //AHORA BORRAMOS TODOS LOS ELEMENTOS DE vectorCodigosDetAnteriores pq fueron eliminados
            
            $j = 0;
            foreach ($vectorCodigosDetAnteriores as $det) {
                Debug::mensajeSimple('ESTOY BORRANDO EL DETALLE REND: '.$det);
                $detalle = DetalleRendicionGastos::findOrFail($det);
                $detalle->delete();

                //BORRAMOS EL ARCHIVO QUE TENIA
                $nombreDelArchivo = 
                                    $this::raizArchivo.
                                    $this->rellernarCerosIzq($detalle->codRendicionGastos,6).
                                    '-'.
                                    $this->rellernarCerosIzq($i+1,2).
                                    '.'.
                                    $vectorTermDetAnteriores[$j];
                Debug::mensajeSimple('toy borrando el archivo '.$nombreDelArchivo);
                Storage::disk('rendiciones')->delete($nombreDelArchivo);
                $j++;
            }


            DB::commit();  
            return redirect()
                ->route('rendicionGastos.listarRendiciones')
                ->with('datos','Se ha Editado la rendicion N°'.$rendicion->codigoCedepas);
        }catch(\Throwable $th){

            error_log('\\n ---------------------- RENDICION GASTOS CONTROLLER STORE 
            Ocurrió el error:'.$th.'
            
            
            ' );

            DB::rollback();
            return redirect()
                ->route('rendicionGastos.listarRendiciones')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }


    



    function rellernarCerosIzq($numero, $nDigitos){
       return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);

    }


    //se le pasa el codigo del detalle rendicion
    function descargarCDPDetalle($id ){
        $rend = DetalleRendicionGastos::findOrFail($id);
        $nombreArchivo = $this::raizArchivo.
            $this->rellernarCerosIzq( $rend->codRendicionGastos,6 )
            .'-'.
            $this->rellernarCerosIzq($rend->nroEnRendicion,2).'.'.$rend->terminacionArchivo;
        return Storage::download("/comprobantes/rendiciones/".$nombreArchivo);

    }



    //descarga el archivo que subió el empleado pq le sobró dinero  
    // o tambien el archivo de reposicion de cedepas hacia el empleado
    //DEPRECATO
    /* function descargarArchivoRendicion($id){
        
        $rend = RendicionGastos::findOrFail($id);
        if($rend->codEstadoRendicion== RendicionGastos::getCodEstado('Repuesta a Favor') )
            $prefijo = 'Repos';
        if($rend->codEstadoRendicion== RendicionGastos::getCodEstado('Rendida en contra')    )
            $prefijo = 'Devol';
        
        $nombreArchivo = $this::raizArchivo.$this->rellernarCerosIzq($id,6).'.'.$rend->terminacionArchivo ;
        
        
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
                    
                    return view('vigo.jefe.reportes.reporteSedes',compact('listaX','fechaI','fechaF'));
                    


                    break;
                case '2': //POR EMPLEADOS
                    //Reporte de las sumas acumuladas de los gastos de cada empleado, con fecha inicio y fecha final

                    $listaX = RendicionGastos::reportePorEmpleados($fechaI,$fechaF);
                    
                    return view('vigo.jefe.reportes.reporteEmpleado',compact('listaX','fechaI','fechaF'));
                    break;
                case '3':

                    $listaX = RendicionGastos::reportePorProyectos($fechaI,$fechaF);
                    return view('vigo.jefe.reportes.reporteProyectos',compact('listaX','fechaI','fechaF'));
                
                    break;
                
                case '4':
                    $sede  = Sede::findOrFail($request->ComboBoxSede);
                    $listaX = RendicionGastos::reportePorSedeYEmpleados($fechaI,$fechaF,$sede->codSede);

                return view('vigo.jefe.reportes.reporteEmpleadoXSede',compact('listaX','fechaI','fechaF','sede'));
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
                $nombreVista = 'vigo.jefe.reportes.reporteSedes';
                $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);


                    break;
                case '2': //POR EMPLEADOS
                    //Reporte de las sumas acumuladas de los gastos de cada empleado, con fecha inicio y fecha final

                    $listaX = RendicionGastos::reportePorEmpleados($fechaI,$fechaF);
                    

                    $nombreVista = 'vigo.jefe.reportes.reporteEmpleado';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);
                    
                    break;
                case '3':

                    $listaX = RendicionGastos::reportePorProyectos($fechaI,$fechaF);
                    

                    $nombreVista = 'vigo.jefe.reportes.reporteProyectos';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);
                    
                    
                break;
                case '4':
                    $sede = Sede::findOrFail($codSede);
                    $listaX = RendicionGastos::reportePorSedeYEmpleados($fechaI,$fechaF,$codSede);


                    $nombreVista = 'vigo.jefe.reportes.reporteEmpleadoXSede';
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
