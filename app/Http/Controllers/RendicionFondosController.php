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

class RendicionFondosController extends Controller
{
    
    public function ver($id){ //le pasamos la id de la solicitud de fondos a la que está enlazada
        $listaRend = RendicionGastos::where('codSolicitud','=',$id)->get();
        $rend = $listaRend[0];

        $solicitud = SolicitudFondos::findOrFail($id);
        $empleado = Empleado::findOrFail($solicitud->codEmpleadoSolicitante);
        $detallesRend = DetalleRendicionGastos::where('codRendicionGastos','=',$rend->codRendicionGastos)->get();

        return view('modulos.empleado.verRend',compact('rend','solicitud','empleado','detallesRend'));
    }

    public function store( Request $request){

        try {
                DB::beginTransaction();   
            $solicitud = SolicitudFondos::findOrFail($request->codigoSolicitud);
            $rendicion = new RendicionGastos();

            $rendicion-> codSolicitud = $solicitud->codSolicitud;
            $rendicion-> codigoCedepas = $request->codRendicion; 
            $rendicion-> totalImporteRecibido = $solicitud->totalSolicitado; //ESTE ES EL DE LA SOLICITUD
            $rendicion-> totalImporteRendido = $request->total;
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

    public function reportes(Request $request){

        $fechaInicial = $request->fechaI;
        $fechaFinal = $request->fechaF;
        $tipoInforme = $request->tipoInforme;
        
        //CONVERTIMOS 13/02/2021 A 2021-02-11
        $fechaI = substr($fechaInicial,6,4).'/'.substr($fechaInicial,3,2).'/'.substr($fechaInicial,0,2);
        $fechaF = substr($fechaFinal,6,4).'/'.substr($fechaFinal,3,2).'/'.substr($fechaFinal,0,2);

        switch ($tipoInforme) {
            case '1': //POR SEDES
                //Reporte de las sumas acumuladas de los gastos de cada sede, con fecha inicio y fecha final

                                            /* 
            
                                            */

                $listaX = DB::select('
                    select sede.nombre as "Sede", SUM(RG.totalImporteRendido) as "Suma_Sede"
                    from rendicion_gastos RG
                        inner join solicitud_fondos USING(codSolicitud)
                        inner join Sede USING(codSede)
                        GROUP BY sede.nombre;
                ');
                return view('modulos.JefeAdmin.reporteSedes',$listaX);
                


                break;
            case '2': //POR EMPLEADOS
            
                break;
           

                        
            default:
                # code...
                break;
        }



    }

}
