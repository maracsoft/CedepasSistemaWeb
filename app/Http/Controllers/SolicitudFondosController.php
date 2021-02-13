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
use App\EstadoOrden;
use App\EstadoSolicitudFondos;

class SolicitudFondosController extends Controller

{

    const PAGINATION = '20';
    
    
    public function listarSolicitudesDeEmpleado(Request $request){
        
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

        return view('modulos.empleado.index',compact('buscarpor','listaSolicitudesFondos','listaBancos'));
    }











    public function listarSolicitudesParaJefe(Request $request){
        
        $codUsuario = Auth::id(); 

        
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

    //funcion del jefe, despliega la vista de revision
    public function revisar($id){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
       
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];    

        return view('modulos.JefeAdmin.revSoliFondos',compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos','listaProyectos','listaSedes'));
    }

    public function aprobar( $id){
        $solicitud = SolicitudFondos::findOrFail($id);
        $solicitud->codEstadoSolicitud = '2';

        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];
        $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
        $solicitud->fechaRevisado = Carbon::now()->subHours(5);

        $solicitud->save();


        return redirect()->route('solicitudFondos.listarJefe')
        ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Aprobada');
    }

    public function rechazar( $id){
        $solicitud = SolicitudFondos::findOrFail($id);
        $solicitud->codEstadoSolicitud = '3';

        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];
        $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
        $solicitud->fechaRevisado = Carbon::now()->subHours(5);


        $solicitud->save();

        return redirect()->route('solicitudFondos.listarJefe')
        ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Rechazada');
    }

    //Despliega la vista de rendir esta solciitud. ES LO MISMO QUE UN CREATE EN EL RendicionFondosController
    public function rendir($id){ //le pasamos id de la sol fondos
        $solicitud = SolicitudFondos::findOrFail($id);
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        $listaCDP = CDP::All();
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        $listaEmpleadosDeSede  = Empleado::All();
        return view ('modulos.empleado.crearRendFondos',compact('empleadoLogeado','listaBancos'
        ,'listaProyectos','listaSedes','listaEmpleadosDeSede','solicitud','listaCDP'));



    }





    public function edit($id){ //id de la solicidu codSolicitud

        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
        //return $detallesSolicitud;
        
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        return view('modulos.empleado.editSoliFondos',
            compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos','listaProyectos','listaSedes'));
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
            return redirect()
                ->route('solicitudFondos.listarEmp')
                ->with('datos','Se ha creado la solicitud'.$solicitud->codigoCedepas);
        }catch(Exception $e){

            DB::rollback();
            return redirect()
                ->route('solicitudFondos.listarEmp')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }




    //actualiza el contenido de una solicitud
    public function update( Request $request,$id){

        try {
                DB::beginTransaction();   
            $solicitud = SolicitudFondos::findOrFail($id);
            $solicitud->codProyecto = $request->ComboBoxProyecto;
            $solicitud->codigoCedepas = $request->codSolicitud;

            /* $usuarioLogeado = Auth::id();
            $LempleadoLogeado = Empleado::where('codUsuario','=',$usuarioLogeado)->get();
            $empleadoLogeado = $LempleadoLogeado[0];

            $solicitud->codEmpleadoSolicitante = $empleadoLogeado->codEmpleado;
 */
            //$solicitud->fechaEmision =  Carbon::now()->subHours(5);
            $solicitud->totalSolicitado = $request->total;
            $solicitud->girarAOrdenDe = $request->girarAOrden;
            $solicitud->numeroCuentaBanco = $request->nroCuenta;
            $solicitud->codBanco = $request->ComboBoxBanco;
            $solicitud->justificacion = $request->justificacion;
            //$solicitud->codEstadoSolicitud = '1';
            $solicitud->codSede = $request->ComboBoxSede;
            
            $vec[] = '';
            $solicitud->save();
                
            $i = 0;
            $cantidadFilas = $request->cantElementos;
            
            //borramos todas las solicitudes puesto que las ingresaremos desde 0 again
            DetalleSolicitudFondos::where('codSolicitud','=',$id)->delete();
            

            while ($i< $cantidadFilas ) {
                $detalle=new DetalleSolicitudFondos();
                $detalle->codSolicitud=          $id;
                $detalle->nroItem=               $i+1;
                $detalle->concepto=              $request->get('colConcepto'.$i);
                $detalle->importe=               $request->get('colImporte'.$i);    
                $detalle->codigoPresupuestal  =  $request->get('colCodigoPresupuestal'.$i);    

                $vec[$i] = $detalle;
                $detalle->save();
                                    
                $i=$i+1;
            }    
            
            DB::commit();  
            return redirect()->route('solicitudFondos.listarEmp')->with('datos','Registro '.$solicitud->codigoCedepas.' actualizado');
            
        }catch(Exception $e){
            DB::rollback();
            error_log('\\n ---------------------- 
            Ocurrió el error:'.$e->getMessage().'
            
            
            ' );
            
            return redirect()->route('solicitudFondos.listarEmp')->with('datos','Ocurrió un error.');
        }
    }

    public function delete($id){ //para borrar una solicitud desde el index
        $sol = SolicitudFondos::findOrFail($id);
        $cod = $sol->codigoCedepas;
        $sol->delete();

        return redirect()->route('solicitudFondos.listarEmp')->with('datos','Se eliminó el registro'.$cod);
    }


    public function reportes(){
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
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        $listaEmpleados = Empleado::All();
        $listaEstados = EstadoSolicitudFondos::All();

        return view('modulos.JefeAdmin.reportesIndex',compact('buscarpor','listaSolicitudesFondos'
        ,'listaBancos','listaSedes','listaProyectos','listaEmpleados','listaEstados'));

    }

}
