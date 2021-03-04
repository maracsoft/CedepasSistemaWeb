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
use App\SolicitudFalta;
use Illuminate\Support\Facades\Storage;
class SolicitudFondosController extends Controller

{

    const PAGINATION = '20';
    
    
    public function listarDetalles($id){
        $listaDetalles = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();

        return $listaDetalles;
    }


    //funcion cuello de botella para volver al index desde el VER SOLICITUD (pq estoy usando la misma vista)
    public function listarSolicitudes(){
        $empleado = Empleado::getEmpleadoLogeado();
        if($empleado->esgerente()){
            //lo enrutamos hacia su index
            return redirect()->route('solicitudFondos.listarGerente');
        }

        if($empleado->esJefeAdmin())//si es jefe de administracion
        {
            return redirect()->route('solicitudFondos.listarJefeAdmin');

        }

        return redirect()->route('solicitudFondos.listarEmp');

    }





    public function listarSolicitudesDeEmpleado(Request $request){
        
        $empleado = Empleado::getEmpleadoLogeado();
        
        $listaSolicitudesFondos = SolicitudFondos::
        where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
        ->orderBy('codEstadoSolicitud','ASC')
        ->orderBy('fechaHoraEmision','DESC')
        ->paginate($this::PAGINATION);

        $buscarpor = "";

        $listaBancos = Banco::All();

        return view('vigo.empleado.listarSolic',compact('buscarpor','listaSolicitudesFondos','listaBancos','empleado'));
    }










    /* FUNCION ACTIVADA POR UN gerente */
    public function listarSolicitudesParaGerente(Request $request){
        
        $empleado = Empleado::getEmpleadoLogeado();
        $codProyecto = $empleado->codProyecto;
        
        $listaSolicitudesFondos = SolicitudFondos::
        where('codProyecto','=',$empleado->codProyecto)
        ->orderBy('codEstadoSolicitud','ASC')
        ->orderBy('fechaHoraEmision','DESC')
        
        ->paginate();

        $buscarpor = "";

        $listaBancos = Banco::All();

        return view('vigo.gerente.index',compact('buscarpor','listaSolicitudesFondos','listaBancos','empleado'));
    }



/* DEBE LISTARLE 
    LAS QUE ESTÁN APROBADAS (Para que las abone)
    Las que están rendidas (para que las registre)
*/
    public function listarSolicitudesParaJefe(Request $request){
        
        $codUsuario = Auth::id(); 

        $empleado = Empleado::getEmpleadoLogeado();
        /* $empleados = Empleado::where('codUsuario','=',$codUsuario)
        ->get();
        $empleado = $empleados[0]; */
        
        $listaSolicitudesFondos = SolicitudFondos::
        where('codEstadoSolicitud','=','2') //aprobadas
        ->orwhere('codEstadoSolicitud','=','4') //rendidas
        ->orderBy('fechaHoraEmision','DESC')
        ->paginate();

        $buscarpor = "";

        $listaBancos = Banco::All();

        return view('vigo.jefe.listarSolicitudes',compact('buscarpor','listaSolicitudesFondos','listaBancos','empleado'));
    }



    //DESPLIEGA LA VISTA PARA VER LA SOLICITUD (VERLA NOMASSS). ES DEL EMPLEAOD ESTA
    public function ver($id){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
       
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];    

        return view('vigo.empleado.verSoliFondos',compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos','listaProyectos','listaSedes'));
    }







    //funcion del gerente, despliega la vista de revision. Si ya la revisó, esta tambien hace funcion de ver 
    public function revisar($id){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
       
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];    

        return view('vigo.gerente.revSoliFondos',compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos','listaProyectos','listaSedes'));
    }

    public function aprobar( $id){

        try 
        {
            DB::beginTransaction();
            $solicitud = SolicitudFondos::findOrFail($id);
            $solicitud->codEstadoSolicitud = '2';

            $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
            $empleadoLogeado = $LempleadoLogeado[0];
            $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $solicitud->fechaHoraRevisado = Carbon::now()->subHours(5);

            $solicitud->save();

            DB::commit();
            return redirect()->route('solicitudFondos.listarGerente')
                ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Aprobada! ');
        } catch (\Throwable $th) {
            error_log('
            
                OCURRIO UN ERROR EN SOLICITUD FONDOS CONTROLLER : APROBAR
            
            ');

            DB::rollBack();
        }

    }


    public function vistaAbonar($id){ 
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
        return view('vigo.jefe.vistaAbonar',compact('solicitud','detallesSolicitud'));

    }

    //CAMBIA EL ESTADO DE LA SOLICITUD A ABONADA, Y GUARDA LA FECHA HORA ABONADO
    public function abonar(Request $request){
        $id = $request->codSolicitud;
        try {
           DB::beginTransaction();
            $solicitud = SolicitudFondos::findOrFail($id);
            $solicitud->codEstadoSolicitud = '3';

            $solicitud->fechaHoraAbonado = Carbon::now()->subHours(5);
            $solicitud->save();
            

            $codSolRecienInsertada = (SolicitudFondos::latest('codSolicitud')->first())->codSolicitud;
            //ESTA WEA ES PARA SACAR LA TERMINACIONDEL ARCHIVO
            $nombreImagen = $request->get('nombreImgImagenEnvio');  //sacamos el nombre completo
            $vec = explode('.',$nombreImagen); //separamos con puntos en un vector 
            $terminacion = end( $vec); //ultimo elemento del vector

            error_log('la terminacion para el archivo guardado es: '.$terminacion);

            $solicitud->terminacionArchivo = $terminacion; //guardamos la terminacion para poder usarla luego
            //               RF-Devol-                           -   5   .  jpg
            $nombreImagen = 'SF-Abono-'.$this->rellernarCerosIzq($codSolRecienInsertada,6).'.'.$terminacion;
            $archivo =  $request->file('imagenEnvio');
            $fileget = \File::get( $archivo );
            Storage::disk('comprobantesAbono')
            ->put($nombreImagen, $fileget );
            
            $solicitud->save();

            DB::commit();
        return redirect()->route('solicitudFondos.listarJefeAdmin')
            ->with('datos','¡Solicitud '.$solicitud->codigoCedepas.' Abonada!');


        } catch (\Throwable $th) {
            error_log('
            
                OCURRIO UN ERROR EN SOLICITUD FONDOS CONTROLLER : ABONAR
            
                '.$th.'


            ');
            DB::rollBack();
        }

    }

    function descargarComprobanteAbono($id){

        $solicitud = SolicitudFondos::findOrFail($id);

        $nombreArchivo = 'SF-Abono-'.
            $this->rellernarCerosIzq($id,6).
            '.'.$solicitud->terminacionArchivo;
        return Storage::download("comprobantesAbono/".$nombreArchivo);




    }


    function rellernarCerosIzq($numero, $nDigitos){
        return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
 
     }
 
    public function rechazar(Request $request){
        try{
            DB::beginTransaction();
            error_log('cod sol = '.$request->codSolicitud);
            $solicitud = SolicitudFondos::findOrFail($request->codSolicitud);
            $solicitud->codEstadoSolicitud = '5';
            $solicitud->razonRechazo = $request->razonRechazo;
            error_log('
            
            
            
            razon request:'.$request->razonRechazo);
            $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
            $empleadoLogeado = $LempleadoLogeado[0];
            $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $solicitud->fechaHoraRevisado = Carbon::now()->subHours(5);


            $solicitud->save();
            DB::commit();
            return redirect()->route('solicitudFondos.listarGerente')
            ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Rechazada');

        } catch (\Throwable $th) {
            error_log('
            
                OCURRIO UN ERROR EN SOLICITUD FONDOS CONTROLLER : RECHAZAR
            
                '.$th.'


            ');

            DB::rollBack();
            return redirect()->route('solicitudFondos.listarGerente')
            ->with('datos','Ha ocurrido un error');
        }

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
        return view ('vigo.empleado.crearRendFondos',compact('empleadoLogeado','listaBancos'
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

        return view('vigo.empleado.editSoliFondos',
            compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos','listaProyectos','listaSedes'));
    }




    public function create(){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        
        $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
        $empleadoLogeado = $LempleadoLogeado[0];

        $listaEmpleadosDeSede  = Empleado::All();
        return view('vigo.empleado.crearSoliFondos',compact('empleadoLogeado','listaBancos','listaProyectos','listaSedes','listaEmpleadosDeSede'));

    }


    /* CREAR UNA SOLICITUD DE FONDOS */
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

            $solicitud->fechaHoraEmision =  Carbon::now()->subHours(5);
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
                ->with('datos','Se ha creado la solicitud '.$solicitud->codigoCedepas);
        }catch(Exception $e){
            error_log('\\n ---------------------- SOLICITUD FONDOS  CONTROLLER STORE 
            Ocurrió el error:'.$e->getMessage().'
            
            
            ' );

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
            
            $solicitud->totalSolicitado = $request->total;

            error_log('&&&&&&&&&&&&&&&&&&&&&& '.$request->total);
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

        return view('vigo.jefe.reportes.reportesIndex',compact('buscarpor','listaSolicitudesFondos'
        ,'listaBancos','listaSedes','listaProyectos','listaEmpleados','listaEstados'));

    }

}
