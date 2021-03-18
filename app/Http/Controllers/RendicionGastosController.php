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

use Barryvdh\DomPDF\PDF;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;




use PhpOffice\PhpWord;
use PhpOffice\PhpWord\Element\Cell;
use PhpOffice\PhpWord\Style\Font;



class RendicionGastosController extends Controller
{
    




    //retorna todas las rendiciones, tienen prioridad de ordenamiento las que están esperando reposicion
    public function listarJefeAdmin(){
        $listaRendiciones = RendicionGastos::where('codEstadoRendicion','>','0')
            ->orderby('codEstadoRendicion','ASC')
            ->get();

        $buscarpor = '';
        $empleado = Empleado::getEmpleadoLogeado();
        return view('vigo.jefe.listarRendiciones',compact('listaRendiciones','empleado','buscarpor'));
        
    }


    //lista todas las rendiciones del gerente (pertenecientes al proyecto que este lidera)
    public function listarDelGerente(){
        $empleado = Empleado::getEmpleadoLogeado();
        /* if(!$empleado->esGerente())
            return 'Error: no eres gerente';
         */ 
        
        $proyecto = $empleado->getProyectoGerencia();
        if($proyecto->nombre=='')
            return "ERROR: NO TIENE NINGUN PROYECTO ASIGNADO.";
        $listaSolicitudes = SolicitudFondos::where('codProyecto','=',$proyecto->codProyecto)->get();
         

        
        //ahora agarramos de cada solicitud, su rendicion (si la tiene)
        $listaRendiciones= new Collection();
        for ($i=0; $i < count($listaSolicitudes); $i++) { //recorremos cada solicitud
            $itemSol = $listaSolicitudes[$i];
            if(!is_null($itemSol->codSolicitud)){ 
                $itemRend = RendicionGastos::where('codSolicitud','=',$itemSol->codSolicitud)->first();
                if(!is_null($itemRend))
                    $listaRendiciones->push($itemRend);
            }
            
        }

        //ordena la coleccion ascendentemente
        $listaRendiciones=$listaRendiciones->sortBy('codEstadoRendicion');

        $buscarpor = '';

        return view('vigo.gerente.listarRendiciones',compact('listaRendiciones','empleado','buscarpor','proyecto'));
        
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



    //en este caso el terminacionArchivo se llena con la terminacion del cbte de abono del pago de cedepas al empleado
    // se le devuelve al empleado los gastos que hizo en exceso
    public function reponer(Request $request){ //id de la rendicion

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

            return redirect()->route('rendicionGastos.listarJefeAdmin')->with('datos','Gastos repuestos efectivamente');
        }catch(Exception $e){

            error_log('\\n ---------------------- RENDICION FONDOS CONTROLLER REPONER 
            Ocurrió el error:'.$e->getMessage().'
            
            
            ' );

            DB::rollback();
            /* return redirect()
                ->route('solicitudFondos.listarEmp')
                ->with('datos','Ha ocurrido un error.'); */
        }


    }
    
    
    
    
    
    
    
    
    
    
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
            $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Momentaneo');
            $rendicion-> save();    
            
            $codRendRecienInsertada = (RendicionGastos::latest('codRendicionGastos')->first())->codRendicionGastos;
            if($rendicion->saldoAFavorDeEmpleado > 0 ){ //cedepas debe depositarle al empleado, estado 1
                $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Rendida a Favor');

            }else{ //el empleado debe depositar a cedepas, estado 2. Se adjunta comprobante de transferencia
                
                

                $rendicion-> codEstadoRendicion = RendicionGastos::getCodEstado('Rendida a Favor');
            }

            $rendicion-> save(); //para guardar la terminacion y el estado
            


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
                $nombreImagen = 'RF-CDP-'.$this->rellernarCerosIzq($detalle->codRendicionGastos,6).'-'.$this->rellernarCerosIzq($i+1,2).'.'.$terminacion  ;
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

    function rellernarCerosIzq($numero, $nDigitos){
       return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);

    }


    //se le pasa el codigo del detalle rendicion
    function descargarCDPDetalle($id ){
        $rend = DetalleRendicionGastos::findOrFail($id);
        $nombreArchivo = 'RF-CDP-'.
            $this->rellernarCerosIzq( $rend->codRendicionGastos,6 )
            .'-'.
            $this->rellernarCerosIzq($rend->nroEnRendicion,2).'.'.$rend->terminacionArchivo;
        return Storage::download("comprobantes/".$nombreArchivo);

    }

    function descargarSapito(){
        return Storage::download("comprobantes/rendiciones/buenas.m4v");
    }

    //descarga el archivo que subió el empleado pq le sobró dinero  
    // o tambien el archivo de reposicion de cedepas hacia el empleado
    function descargarArchivoRendicion($id){
        
        $rend = RendicionGastos::findOrFail($id);
        if($rend->codEstadoRendicion== RendicionGastos::getCodEstado('Repuesta a Favor') )
            $prefijo = 'Repos';
        if($rend->codEstadoRendicion== RendicionGastos::getCodEstado('Rendida en contra')    )
            $prefijo = 'Devol';
        
        $nombreArchivo = 'RF-'.$prefijo.'-'.$this->rellernarCerosIzq($id,6).'.'.$rend->terminacionArchivo ;
        
        
        return Storage::download("comprobantesAbono/".$nombreArchivo);

    }













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
            $pdf = PDF::loadView();


            
            $pdf = PDF::loadView($nombreVista,$argumentosVista)->setPaper('a4','landscape');
            return $pdf->download('informeMiau.pdf');

        } catch (\Throwable $th) {
        
            error_log('\\n ----------------------  RENDICIONGASTOS: DESCARGAR REPORTES
            Ocurrió el error:'.$th->getMessage().'


            ' );

        }
    }

}
