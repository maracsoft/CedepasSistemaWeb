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
use Illuminate\Support\Collection;
use PhpParser\Node\Expr\Throw_;
use App\Moneda;
use App\Debug;
use App\Numeracion;
class SolicitudFondosController extends Controller


{

    const PAGINATION = '20';
    
    
    public function listarDetalles($id){
        $listaDetalles = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();

        return $listaDetalles;
    }


    //funcion cuello de botella para volver al index desde el VER SOLICITUD (pq estoy usando la misma vista)
    /* DEPRECATED */
    public function listarSolicitudes(){
        $empleado = Empleado::getEmpleadoLogeado();
        $msj = session('datos');
        $datos='';
        if($msj!='')
            $datos = 'datos';

        if($empleado->esGerente()){
            //lo enrutamos hacia su index
            return redirect()->route('solicitudFondos.listarGerente')->with($datos,$msj);
        }

        if($empleado->esJefeAdmin())//si es jefe de administracion
        {
            return redirect()->route('solicitudFondos.listarJefeAdmin')->with($datos,$msj);

        }

        return redirect()->route('solicitudFondos.listarEmp')->with($datos,$msj);

    }





    public function listarSolicitudesDeEmpleado(Request $request){
        $codProyectoBuscar=$request->codProyectoBuscar;
        $empleado = Empleado::getEmpleadoLogeado();

        if($codProyectoBuscar==0){
            $listaSolicitudesFondos = SolicitudFondos::
            where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
            ->orderBy('codEstadoSolicitud','ASC')
            ->orderBy('fechaHoraEmision','DESC')
            ->paginate($this::PAGINATION);
        }else
            $listaSolicitudesFondos = SolicitudFondos::
            where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
            ->orderBy('codEstadoSolicitud','ASC')
            ->orderBy('fechaHoraEmision','DESC')->where('codProyecto','=',$codProyectoBuscar)
            ->paginate($this::PAGINATION);
        $proyectos=Proyecto::all();




        
        /*
        $listaSolicitudesFondos = SolicitudFondos::
        where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
        ->orderBy('codEstadoSolicitud','ASC')
        ->orderBy('fechaHoraEmision','DESC')
        ->paginate($this::PAGINATION);

        $buscarpor = "";*/

        $listaBancos = Banco::All();

        return view('SolicitudFondos.empleado.listarSolic',compact('proyectos','listaSolicitudesFondos','listaBancos','empleado','codProyectoBuscar'));
    }










    /* FUNCION ACTIVADA POR UN gerente */
    public function listarSolicitudesParaGerente(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;


        $empleado = Empleado::getEmpleadoLogeado();

        
        if(count($empleado->getListaProyectos())==0)
            return "ERROR: NO TIENE NINGUN PROYECTO ASIGNADO.";
        

        $listaSolicitudesFondos = $empleado->getListaSolicitudesDeGerente();
        if($codProyectoBuscar!=0){
            $listaSolicitudesFondos=$listaSolicitudesFondos->where('codProyecto','=',$codProyectoBuscar);
        }
        if($codEmpleadoBuscar!=0){
            $listaSolicitudesFondos=$listaSolicitudesFondos->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        //PARA PODER PAGINAR EL COLECTTION USE https://gist.github.com/iamsajidjaved/4bd59517e4364ecec98436debdc51ecc#file-appserviceprovider-php-L23
        $listaSolicitudesFondos=$listaSolicitudesFondos->paginate($this::PAGINATION);


        $proyectos=Proyecto::all();
        $empleados=Empleado::all();
        //$buscarpor = "";

        $listaBancos = Banco::All();

        return view('SolicitudFondos.gerente.index',compact('codEmpleadoBuscar','codProyectoBuscar','listaSolicitudesFondos','listaBancos','empleado','proyectos','empleados'));
    }



/* DEBE LISTARLE 
    LAS QUE ESTÁN APROBADAS (Para que las abone)
    Las que están rendidas (para que las registre)
*/
    public function listarSolicitudesParaJefe(Request $request){
        
        
        $empleado = Empleado::getEmpleadoLogeado();
        /* $empleados = Empleado::where('codUsuario','=',$codUsuario)
        ->get();
        $empleado = $empleados[0]; */
        $estados =[];
        array_push($estados,SolicitudFondos::getCodEstado('Aprobada') );
        array_push($estados,SolicitudFondos::getCodEstado('Abonada') );
        array_push($estados,SolicitudFondos::getCodEstado('Contabilizada') );
        
      
        //error_log($array);

        $listaSolicitudesFondos = SolicitudFondos::
            whereIn('codEstadoSolicitud',$estados)
            ->orderBy('fechaHoraEmision','DESC')
            ->paginate()
            ;


        $buscarpor = "";

        $listaBancos = Banco::All();

        return view('SolicitudFondos.administracion.listarSolicitudes',compact('buscarpor','listaSolicitudesFondos','listaBancos','empleado'));
    }

    public function listarSolicitudesParaContador(){
        
        $empleado = Empleado::getEmpleadoLogeado();

        $estados =[];
        array_push($estados,SolicitudFondos::getCodEstado('Abonada') );
        array_push($estados,SolicitudFondos::getCodEstado('Contabilizada') );
     

        $listaSolicitudesFondos = SolicitudFondos::
            whereIn('codEstadoSolicitud',$estados)
            ->orderBy('fechaHoraEmision','DESC')
            ->paginate()
            ;


        $buscarpor = "";
        $listaBancos = Banco::All();

        return view('SolicitudFondos.contador.listarSolicitudes',
            compact('buscarpor','listaSolicitudesFondos','listaBancos','empleado'));
    
    }


    //DESPLIEGA LA VISTA PARA VER LA SOLICITUD (VERLA NOMASSS). ES DEL EMPLEAOD ESTA
    public function ver($id){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
       
        $empleadoLogeado = Empleado::getEmpleadoLogeado();  

        return view('SolicitudFondos.empleado.verSoliFondos',compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos','listaProyectos','listaSedes'));
    }







    //funcion del gerente, despliega la vista de revision. Si ya la revisó, esta tambien hace funcion de ver 
    public function revisar($id){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
       
        $empleadoLogeado = Empleado::getEmpleadoLogeado();  

        return view('SolicitudFondos.gerente.revSoliFondos',compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos','listaProyectos','listaSedes'));
    }

    public function aprobar( $id){

        try 
        {
            DB::beginTransaction();
            $solicitud = SolicitudFondos::findOrFail($id);
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Aprobada');
            $solicitud->observacion = '';
            $empleadoLogeado = Empleado::getEmpleadoLogeado();  

            $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $solicitud->fechaHoraRevisado = Carbon::now();

            $solicitud->save();

            DB::commit();
            return redirect()->route('solicitudFondos.listarSolicitudes')
                ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Aprobada! ');
        } catch (\Throwable $th) {
           Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : APROBAR',$th);
           DB::rollBack();
           return redirect()->route('solicitudFondos.listarSolicitudes')
           ->with('datos','Ha ocurrido un error');

        }

    }


    public function contabilizar($id){
        try 
        {
            DB::beginTransaction();
            $solicitud = SolicitudFondos::findOrFail($id);
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Contabilizada');
            $empleadoLogeado = Empleado::getEmpleadoLogeado();  

            $solicitud->codEmpleadoContador = $empleadoLogeado->codEmpleado;
            
            $solicitud->save();
            DB::commit();
            return redirect()->route('solicitudFondos.listarSolicitudes')
                ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Contabilizada! ');
        } catch (\Throwable $th) {
           Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : CONTABILIZAR',$th);
           DB::rollBack();

           return redirect()->route('solicitudFondos.listarSolicitudes')
                ->with('datos','Ha ocurrido un error.');
        }





    }

    public function vistaAbonar($id){ 
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
        return view('SolicitudFondos.administracion.vistaAbonar',compact('solicitud','detallesSolicitud'));

    }

    //CAMBIA EL ESTADO DE LA SOLICITUD A ABONADA, Y GUARDA LA FECHA HORA ABONADO
    public function abonar(Request $request){
        $id = $request->codSolicitud;
        try {
           DB::beginTransaction();
            $solicitud = SolicitudFondos::findOrFail($id);
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Abonada');
            $solicitud->codEmpleadoAbonador = Empleado::getEmpleadoLogeado()->codEmpleado;

            $solicitud->fechaHoraAbonado = Carbon::now();
            $solicitud->save();
            
            

            DB::commit();
        return redirect()->route('solicitudFondos.listarSolicitudes')
            ->with('datos','¡Solicitud '.$solicitud->codigoCedepas.' Abonada!');


        } catch (\Throwable $th) {
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : ABONAR',$th);
            DB::rollBack();
            return redirect()->route('solicitudFondos.listarSolicitudes')
            ->with('datos','Ha ocurrido un error.');

        }

    }


    //DEPRECADO
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
 

    
    public function observar($cadena){

        try{

            $vector = explode('*',$cadena);
            if(count($vector)<2)
                throw new Exception('El argumento cadena no es valido');


            $codSolicitud = $vector[0];
            $textoObs = $vector[1];




            DB::beginTransaction();
          
            $solicitud = SolicitudFondos::findOrFail($codSolicitud);
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Observada');
            $solicitud->observacion = $textoObs;
           
            $empleadoLogeado = Empleado::getEmpleadoLogeado();  

            $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $solicitud->fechaHoraRevisado = Carbon::now();


            $solicitud->save();
            DB::commit();
            return redirect()->route('solicitudFondos.listarSolicitudes')
            ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Observada');

        } catch (\Throwable $th) {
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : OBSERVAR',$th);
           
            DB::rollBack();
            return redirect()->route('solicitudFondos.listarSolicitudes')
            ->with('datos','Ha ocurrido un error ');
        }

    }




    public function rechazar($codSolicitud){
        try{

            DB::beginTransaction();
            error_log('cod sol = '.$codSolicitud);
            $solicitud = SolicitudFondos::findOrFail($codSolicitud);
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Rechazada');
            
            $empleadoLogeado = Empleado::getEmpleadoLogeado();
            $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $solicitud->fechaHoraRevisado = Carbon::now();


            $solicitud->save();
            DB::commit();
            return redirect()->route('solicitudFondos.listarSolicitudes')
            ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Rechazada');

        } catch (\Throwable $th) {
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : RECHAZAR',$th);
          
            DB::rollBack();
            return redirect()->route('solicitudFondos.listarSolicitudes')
            ->with('datos','Ha ocurrido un error');
        }

    }










    //Despliega la vista de rendir esta solciitud. ES LO MISMO QUE UN CREATE EN EL RendicionFondosController
    public function rendir($id){ //le pasamos id de la sol fondos

        $solicitud = SolicitudFondos::findOrFail($id);

        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$solicitud->codSolicitud)->get();
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        $listaCDP = CDP::All();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        $objNumeracion = Numeracion::getNumeracionREN();

        $listaEmpleadosDeSede  = Empleado::All();
        return view ('RendicionGastos.empleado.crearRendFondos',
                    compact('empleadoLogeado','listaBancos'
                    ,'listaProyectos','listaSedes','listaEmpleadosDeSede','solicitud',
                    'listaCDP','detallesSolicitud','objNumeracion'));
    }





    public function edit($id){ //id de la solicidu codSolicitud

        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        $listaMonedas = Moneda::All();
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
        //return $detallesSolicitud;
        
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('SolicitudFondos.empleado.editSoliFondos',
            compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos',
                'listaMonedas','listaProyectos','listaSedes'));
    }




    public function create(){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        $listaMonedas = Moneda::All();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        $objNumeracion = Numeracion::getNumeracionSOF();
        $listaEmpleadosDeSede  = Empleado::All();
        return view('SolicitudFondos.empleado.crearSoliFondos',
            compact('empleadoLogeado','listaBancos','listaProyectos',
                'listaMonedas','listaSedes','listaEmpleadosDeSede','objNumeracion'));

    }

    //funcion servicio a ser consumida por javascript 
    public function getNumeracionLibre(){
        return Numeracion::getNumeracionSOF()->numeroLibreActual;
    }


    /* CREAR UNA SOLICITUD DE FONDOS */
    public function store( Request $request){

        try {
                DB::beginTransaction();   
            $solicitud = new SolicitudFondos();
            $solicitud->codProyecto = $request->ComboBoxProyecto;
            $empleadoLogeado = Empleado::getEmpleadoLogeado();

            $solicitud->codEmpleadoSolicitante = $empleadoLogeado->codEmpleado;

            $solicitud->fechaHoraEmision =  Carbon::now();
            $solicitud->totalSolicitado = $request->total;
            $solicitud->girarAOrdenDe = $request->girarAOrden;
            $solicitud->numeroCuentaBanco = $request->nroCuenta;
            $solicitud->codBanco = $request->ComboBoxBanco;
            $solicitud->justificacion = $request->justificacion;
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Creada');
            
            $solicitud->codMoneda = $request->ComboBoxMoneda;

            $vec[] = '';

            $solicitud->codigoCedepas = SolicitudFondos::calcularCodigoCedepas(Numeracion::getNumeracionSOF());
            Numeracion::aumentarNumeracionSOF();
            
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
        }catch(\Throwable $th){
            
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : STORE',$th);
            
            DB::rollback();
            return redirect()
                ->route('solicitudFondos.listarEmp')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }

    public function verContabilizar($id){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::All();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
       
        $empleadoLogeado = Empleado::getEmpleadoLogeado();  

        return view('SolicitudFondos.contador.contabilizarSoliFondos',
            compact('solicitud','detallesSolicitud','empleadoLogeado',
                    'listaBancos','listaProyectos','listaSedes'));
    }


    //actualiza el contenido de una solicitud
    public function update( Request $request,$id){

        try {
                DB::beginTransaction();   
            $solicitud = SolicitudFondos::findOrFail($id);

            //Si está siendo editada porque la observaron, pasa de OBSERVADA a SUBSANADA
            if ($solicitud->codEstadoSolicitud == SolicitudFondos::getCodEstado('Observada')) {
                $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Subsanada');
            }
            //Si no, que siga en su estado CREADA


            $solicitud->codProyecto = $request->ComboBoxProyecto;
            $solicitud->codigoCedepas = $request->codSolicitud;

            
            $solicitud->totalSolicitado = $request->total;

            
            $solicitud->girarAOrdenDe = $request->girarAOrden;
            $solicitud->numeroCuentaBanco = $request->nroCuenta;
            $solicitud->codBanco = $request->ComboBoxBanco;
            $solicitud->justificacion = $request->justificacion;
            //$solicitud->codEstadoSolicitud = '1';
            
            $solicitud->codMoneda = $request->ComboBoxMoneda;
            
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
            return redirect()->route('solicitudFondos.listarEmp')
                ->with('datos','Registro '.$solicitud->codigoCedepas.' actualizado');
            
        }catch(\Throwable $th){
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : UPDATE',$th);
            
            DB::rollback();
            return redirect()->route('solicitudFondos.listarEmp')
                ->with('datos','Ocurrió un error.');
        }
    }

    public function delete($id){ //para borrar una solicitud desde el index
        $sol = SolicitudFondos::findOrFail($id);
        $cod = $sol->codigoCedepas;
        $sol->delete();

        return redirect()->route('solicitudFondos.listarEmp')->with('datos','Se eliminó el registro'.$cod);
    }


    public function reportes(){
        
        $empleado = Empleado::getEmpleadoLogeado();


        
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

        return view('RendicionGastos.administracion.reportes.reportesIndex',compact('buscarpor','listaSolicitudesFondos'
        ,'listaBancos','listaSedes','listaProyectos','listaEmpleados','listaEstados'));

    }


    public function descargarPDF($codSolicitud){
        $solicitud = SolicitudFondos::findOrFail($codSolicitud);
        $pdf = $solicitud->getPDF();
        return $pdf->download('Solicitud de Fondos '.$solicitud->codigoCedepas.'.pdf');
    }   
    
    public function verPDF($codSolicitud){
        $solicitud = SolicitudFondos::findOrFail($codSolicitud);
        $pdf = $solicitud->getPDF();
        return $pdf->stream();
    }



}
