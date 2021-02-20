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

use Illuminate\Support\Facades\Storage;




use PhpOffice\PhpWord;
use PhpOffice\PhpWord\Element\Cell;
use PhpOffice\PhpWord\Style\Font;



class RendicionFondosController extends Controller
{
    
    public function ver($id){ //le pasamos la id de la solicitud de fondos a la que está enlazada
        $listaRend = RendicionGastos::where('codSolicitud','=',$id)->get();
        $rend = $listaRend[0];

        $solicitud = SolicitudFondos::findOrFail($id);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rend->codRendicionGastos)->get();

        return view('vigo.empleado.verRend',compact('rend','solicitud','empleado','detallesRend'));
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
            $rendicion-> estadoDeReposicion = '1';
            $rendicion-> fechaRendicion = Carbon::now()->subHours(5);
            $rendicion-> save();
            


            $vec[] = '';
            
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleRendicionGastos();
                $detalle->codRendicionGastos=          (RendicionGastos::latest('codRendicionGastos')->first())->codRendicionGastos; //ultimo insertad
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
                $nombreImagen = 'CDP-'.$this->rellernarCerosIzq($detalle->codRendicionGastos,6).'-'.$this->rellernarCerosIzq($i+1,2).'.'.$terminacion  ;
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
            $solicitud ->codEstadoSolicitud = '4';
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
        $nombreArchivo = 'CDP-'.
            $this->rellernarCerosIzq( $rend->codRendicionGastos,6 )
            .'-'.
            $this->rellernarCerosIzq($rend->nroEnRendicion,2).'.'.$rend->terminacionArchivo;
        return Storage::download("comprobantes/".$nombreArchivo);

    }


















    public function reportes(Request $request){

        try 
        {
                //code...
            

            $fechaI = $request->fechaI;
            $fechaF = $request->fechaF;
            
            $tipoInforme = $request->tipoInforme;

           
            switch ($tipoInforme) {
                case '1': //POR SEDES
                    //Reporte de las sumas acumuladas de los gastos de cada sede, con fecha inicio y fecha final

                                                /* 
                
                                                */
                    //return $fechaI;
                    //return $fechaF;
                    $listaX = DB::select('
                        select sede.nombre as "Sede", SUM(RG.totalImporteRendido) as "Suma_Sede"
                        from rendicion_gastos RG
                            inner join solicitud_fondos USING(codSolicitud)
                            inner join Sede USING(codSede)
                            where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                            GROUP BY sede.nombre;
                    ');
                // return  $listaX;
                    return view('vigo.jefe.reportes.reporteSedes',compact('listaX','fechaI','fechaF'));
                    


                    break;
                case '2': //POR EMPLEADOS
                    //Reporte de las sumas acumuladas de los gastos de cada empleado, con fecha inicio y fecha final

                    $listaX = DB::select('
                    select E.nombres as "NombreEmp", SUM(RG.totalImporteRendido) as "Suma_Empleado"
                        from rendicion_gastos RG
                            inner join solicitud_fondos SF USING(codSolicitud)
                            inner join Empleado E on E.codEmpleado = SF.codEmpleadoSolicitante 
                            where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                            GROUP BY E.nombres;
                            ');
                    
                    return view('vigo.jefe.reportes.reporteEmpleado',compact('listaX','fechaI','fechaF'));
                    break;
                case '3':

                    $listaX = DB::select('
                    select P.nombre as "NombreProy", SUM(RG.totalImporteRendido) as "Suma_Proyecto"
                    from rendicion_gastos RG
                        inner join solicitud_fondos SF USING(codSolicitud)
                        inner join Proyecto P on P.codProyecto = SF.codProyecto 
                        where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                        GROUP BY P.nombre;
                        ');
                    return view('vigo.jefe.reportes.reporteProyectos',compact('listaX','fechaI','fechaF'));
                        break;

                break;
                
                case '4':
                    $sede = Sede::findOrFail($request->ComboBoxSede);
                    $listaX = DB::select('
                    select E.nombres as "NombreEmp", SUM(RG.totalImporteRendido) as "Suma_Empleado"
                        from rendicion_gastos RG
                            inner join solicitud_fondos SF USING(codSolicitud)
                            inner join Empleado E on E.codEmpleado = SF.codEmpleadoSolicitante 
                            where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                            and SF.codSede = "'.$sede->codSede.'"
                            GROUP BY E.nombres;
                            ');

                return view('vigo.jefe.reportes.reporteEmpleadoXSede',compact('listaX','fechaI','fechaF','sede'));
                    break;

                            
                default:
                    # code...
                    break;
            }

        } catch (\Throwable $th) {
        
            error_log('\\n ---------------------- 
            Ocurrió el error:'.$th->getMessage().'


            ' );

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
                    $listaX = DB::select('
                        select sede.nombre as "Sede", SUM(RG.totalImporteRendido) as "Suma_Sede"
                        from rendicion_gastos RG
                            inner join solicitud_fondos USING(codSolicitud)
                            inner join Sede USING(codSede)
                            where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                            GROUP BY sede.nombre;
                    ');
                // return  $listaX;
                $nombreVista = 'vigo.jefe.reportes.reporteSedes';
                $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);


                    break;
                case '2': //POR EMPLEADOS
                    //Reporte de las sumas acumuladas de los gastos de cada empleado, con fecha inicio y fecha final

                    $listaX = DB::select('
                    select E.nombres as "NombreEmp", SUM(RG.totalImporteRendido) as "Suma_Empleado"
                        from rendicion_gastos RG
                            inner join solicitud_fondos SF USING(codSolicitud)
                            inner join Empleado E on E.codEmpleado = SF.codEmpleadoSolicitante 
                            where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                            GROUP BY E.nombres;
                            ');

                    $nombreVista = 'vigo.jefe.reportes.reporteEmpleado';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);
                    
                    break;
                case '3':

                    $listaX = DB::select('
                    select P.nombre as "NombreProy", SUM(RG.totalImporteRendido) as "Suma_Proyecto"
                    from rendicion_gastos RG
                        inner join solicitud_fondos SF USING(codSolicitud)
                        inner join Proyecto P on P.codProyecto = SF.codProyecto 
                        where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                        GROUP BY P.nombre;
                        ');

                    $nombreVista = 'vigo.jefe.reportes.reporteProyectos';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI);
                    
                    
                break;

            
                
                case '4':
                    $sede = Sede::findOrFail($codSede);
                    

                    $listaX = DB::select('
                    select E.nombres as "NombreEmp", SUM(RG.totalImporteRendido) as "Suma_Empleado"
                        from rendicion_gastos RG
                            inner join solicitud_fondos SF USING(codSolicitud)
                            inner join Empleado E on E.codEmpleado = SF.codEmpleadoSolicitante 
                            where RG.fechaRendicion > "'.$fechaI.'" and RG.fechaRendicion < "'.$fechaF.'" 
                            and SF.codSede = "'.$sede->codSede.'"
                            GROUP BY E.nombres;
                            ');
                    $nombreVista = 'vigo.jefe.reportes.reporteEmpleadoXSede';
                    $argumentosVista = array('listaX'=> $listaX,'fechaI' =>$fechaI,'fechaF' =>$fechaI,'sede'=>$sede);
                            
                    
                    break;

                            
                default:
                    # code...
                    break;
            }
            error_log('\\n ---------------------- 
:
            LLEGAMOS
            
            ' );

            $pdf = new PDF();
            $pdf = PDF::loadView();


            
            $pdf = PDF::loadView($nombreVista,$argumentosVista)->setPaper('a4','landscape');
            return $pdf->download('informeMiau.pdf');

        } catch (\Throwable $th) {
        
            error_log('\\n ---------------------- 
            Ocurrió el error:'.$th->getMessage().'


            ' );

        }
    }

}
