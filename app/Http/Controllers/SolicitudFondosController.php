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

class SolicitudFondosController extends Controller

{

    const PAGINATION = '20';

    
    public function listarSolicitudesDeEmpleado(Request $request){
        
        $codUsuario = Auth::id(); //este es el idSolicitante 

        
        $empleados = Empleado::where('codUsuario','=',$codUsuario)->get();
        $empleado = $empleados[0];

        
        $listaSolicitudesFondos = SolicitudFondos::
        where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
        ->paginate();

        $buscarpor = "";

        $listaBancos = Banco::All();

        return view('modulos.empleado.index',compact('buscarpor','listaSolicitudesFondos','listaBancos'));
    }











    public function listarSolicitudesParaJefe(Request $request){
        
        $codUsuario = Auth::id(); //este es el idSolicitante 

        
        $empleados = Empleado::where('codUsuario','=',$codUsuario)
        ->get();
        $empleado = $empleados[0];

        
        $listaSolicitudesFondos = SolicitudFondos::
        where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
        ->orderBy('codEstadoSolicitud','ASC')
        ->paginate();

        $buscarpor = "";

        $listaBancos = Banco::All();

        return view('modulos.jefeAdmin.index',compact('buscarpor','listaSolicitudesFondos','listaBancos'));
    }


    public function revisar($id){
        return "aaaaaaaa";
        

    }
    




    public function create(){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        $listaEmpleadosDeSede  = Empleado::All();
        return view ('modulos.empleado.crearSoliFondos',compact('empleadoLogeado','listaBancos','listaProyectos','listaSedes','listaEmpleadosDeSede'));

    }

    public function store( Request $request){

        try {
                DB::beginTransaction();   
            $solicitud = new SolicitudFondos();
            $solicitud->codProyecto = $request->ComboBoxProyecto;
            $solicitud->codigoCedepas = $request->codSolicitud;

            $usuarioLogeado = Auth::id();
            $LempleadoLogeado = Empleado::where('codUsuario','=',$usuarioLogeado)->get();
            $empleadoLogeado = $LempleadoLogeado[0];

            $solicitud->codEmpleadoSolicitante = $empleadoLogeado->codEmpleado;

            $solicitud->fechaEmision =  Carbon::now()->subHours(5);
            $solicitud->totalSolicitado = $request->total;
            $solicitud->girarAOrdenDe = $request->girarAOrden;
            $solicitud->numeroCuentaBanco = $request->nroCuenta;
            $solicitud->codBanco = $request->ComboBoxBanco;
            $solicitud->justificacion = $request->justificacion;
            $solicitud->codEstadoSolicitud = '1';
            $solicitud->codSede = $request->ComboBoxSede;
            
            $vec[] = '';
            $solicitud->save();
                
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            while ($i< $cantidadFilas ) {
                $detalle=new DetalleSolicitudFondos();
                $detalle->codSolicitud=          (SolicitudFondos::latest('codSolicitud')->first())->codSolicitud; //ultimo insertad
                $detalle->nroItem=               $i+1;
                $detalle->concepto=              $request->get('colConcepto'.$i);
                $detalle->importe=               $request->get('colImporte'.$i);    
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);    

                $vec[$i] = $detalle;
                $detalle->save();
                    /* Actualizar stock */
                //roducto::ActualizarStock($detalle->productoid,$detalle->cantidad);                         
                $i=$i+1;
            }    
            
            DB::commit();  
        }catch(Exception $e){

            DB::rollback();
        }

        return redirect()->route('solicitudFondos.listarEmp');

    }

}
