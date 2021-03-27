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
use App\ProyectoContador;

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
            return redirect()->route('SolicitudFondos.Gerente.listar')->with($datos,$msj);
        }

        if($empleado->esJefeAdmin())//si es jefe de administracion
        {
            return redirect()->route('SolicitudFondos.Administracion.listar')->with($datos,$msj);

        }

        return redirect()->route('SolicitudFondos.empleado.listar')->with($datos,$msj);

    }





    public function listarSolicitudesDeEmpleado(Request $request){
        $codProyectoBuscar=$request->codProyectoBuscar;
        $empleado = Empleado::getEmpleadoLogeado();

        if($codProyectoBuscar==0){
            $listaSolicitudesFondos = SolicitudFondos::
            where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
            ->orderBy('codEstadoSolicitud','ASC')
            ->orderBy('fechaHoraEmision','DESC')->get();
       
        }else
            $listaSolicitudesFondos = SolicitudFondos::
            where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
            ->orderBy('codEstadoSolicitud','ASC')
            ->orderBy('fechaHoraEmision','DESC')
            ->where('codProyecto','=',$codProyectoBuscar)->get();
          
        $proyectos=Proyecto::getProyectosActivos();


        $listaSolicitudesFondos = SolicitudFondos::ordenarParaEmpleado($listaSolicitudesFondos)
        ->paginate($this::PAGINATION);
        
        //return $listaSolicitudesFondos->paginate($this::PAGINATION);

        $listaBancos = Banco::All();

        return view('SolicitudFondos.empleado.listarSolicitudes',compact('proyectos','listaSolicitudesFondos','listaBancos','empleado','codProyectoBuscar'));
    }










    /* FUNCION ACTIVADA POR UN gerente */
    public function listarSolicitudesParaGerente(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;


        $empleado = Empleado::getEmpleadoLogeado();

        
        if(count($empleado->getListaProyectos())==0)
            return "ERROR: NO TIENE NINGUN PROYECTO ASIGNADO.";
        

        $listaSolicitudesFondos = $empleado->getListaSolicitudesDeGerente2();
        if($codProyectoBuscar!=0){
            $listaSolicitudesFondos=$listaSolicitudesFondos->where('codProyecto','=',$codProyectoBuscar);
        }
        if($codEmpleadoBuscar!=0){
            $listaSolicitudesFondos=$listaSolicitudesFondos->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        //PARA PODER PAGINAR EL COLECTTION USE https://gist.github.com/iamsajidjaved/4bd59517e4364ecec98436debdc51ecc#file-appserviceprovider-php-L23
        

        $listaSolicitudesFondos = SolicitudFondos::ordenarParaGerente($listaSolicitudesFondos->get())
        ->paginate($this::PAGINATION);

        $proyectos=Proyecto::getProyectosActivos();
        $empleados=Empleado::getEmpleadosActivos();
        //$buscarpor = "";

        $listaBancos = Banco::All();

        return view('SolicitudFondos.gerente.listarSolicitudes',compact('codEmpleadoBuscar','codProyectoBuscar',
            'listaSolicitudesFondos','listaBancos','empleado','proyectos','empleados'));
    }

/*         //$listaSolicitudesFondos = $listaSolicitudesFondos->paginate($this::PAGINATION);
        $listaSolicitudesFondos = SolicitudFondos::ordenarParaGerente($listaSolicitudesFondos)
        ->paginate($this::PAGINATION);
 */

/* DEBE LISTARLE 
    LAS QUE ESTÁN APROBADAS (Para que las abone)
    Las que están rendidas (para que las registre)
*/
    public function listarSolicitudesParaJefe(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;
        
        $empleado = Empleado::getEmpleadoLogeado();
        /* $empleados = Empleado::where('codUsuario','=',$codUsuario)
        ->get();
        $empleado = $empleados[0]; */
        $estados =[];
        array_push($estados,SolicitudFondos::getCodEstado('Aprobada') );
        array_push($estados,SolicitudFondos::getCodEstado('Abonada') );
        array_push($estados,SolicitudFondos::getCodEstado('Contabilizada') );
        
      
        $listaSolicitudesFondos = SolicitudFondos::whereIn('codEstadoSolicitud',$estados);
        if($codProyectoBuscar!=0){
            $listaSolicitudesFondos=$listaSolicitudesFondos->where('codProyecto','=',$codProyectoBuscar);
        }
        if($codEmpleadoBuscar!=0){
            $listaSolicitudesFondos=$listaSolicitudesFondos->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        //PARA PODER PAGINAR EL COLECTTION USE https://gist.github.com/iamsajidjaved/4bd59517e4364ecec98436debdc51ecc#file-appserviceprovider-php-L23
        $listaSolicitudesFondos=$listaSolicitudesFondos->orderBy('codEstadoSolicitud')->get();

        $listaSolicitudesFondos = SolicitudFondos::ordenarParaAdministrador($listaSolicitudesFondos)
        ->paginate($this::PAGINATION);

        $proyectos=Proyecto::getProyectosActivos();
        $empleados=Empleado::getEmpleadosActivos();

        $listaBancos = Banco::All();

        return view('SolicitudFondos.administracion.listarSolicitudes',compact('empleados','proyectos','codEmpleadoBuscar','codProyectoBuscar','listaSolicitudesFondos','listaBancos','empleado'));
    }

    public function listarSolicitudesParaContador(Request $request){
        //filtros
        $codEmpleadoBuscar=$request->codEmpleadoBuscar;
        $codProyectoBuscar=$request->codProyectoBuscar;

        $empleado = Empleado::getEmpleadoLogeado();

        $estados =[];
        array_push($estados,SolicitudFondos::getCodEstado('Abonada') );
        array_push($estados,SolicitudFondos::getCodEstado('Contabilizada') );

        //para ver que proyectos tiene el contador
        $detalles=ProyectoContador::where('codEmpleadoContador','=',$empleado->codEmpleado)->get();
        $arr2=[];
        foreach ($detalles as $itemproyecto) {
            $arr2[]=$itemproyecto->codProyecto;
        }


        $listaSolicitudesFondos = SolicitudFondos::whereIn('codEstadoSolicitud',$estados);
        if($codProyectoBuscar==0){
            $listaSolicitudesFondos=$listaSolicitudesFondos->whereIn('codProyecto',$arr2);
        }else{
            $listaSolicitudesFondos=$listaSolicitudesFondos->where('codProyecto','=',$codProyectoBuscar);
        }
        if($codEmpleadoBuscar!=0){
            $listaSolicitudesFondos=$listaSolicitudesFondos->where('codEmpleadoSolicitante','=',$codEmpleadoBuscar);
        }
        $listaSolicitudesFondos=$listaSolicitudesFondos->orderBy('codEstadoSolicitud')->get();
    
        $listaSolicitudesFondos = SolicitudFondos::ordenarParaContador($listaSolicitudesFondos)
        ->paginate($this::PAGINATION);

        $proyectos=Proyecto::whereIn('codProyecto',$arr2)->get();
        $empleados=Empleado::getEmpleadosActivos();

        
        $listaBancos = Banco::All();

        return view('SolicitudFondos.contador.listarSolicitudes',
            compact('listaSolicitudesFondos','listaBancos','empleado','empleados','proyectos','codEmpleadoBuscar','codProyectoBuscar'));
    
    }


    //DESPLIEGA LA VISTA PARA VER LA SOLICITUD (VERLA NOMASSS). ES DEL EMPLEAOD ESTA
    public function ver($id){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
       
        $empleadoLogeado = Empleado::getEmpleadoLogeado();  

        return view('SolicitudFondos.empleado.verSolicitudFondos',compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos','listaProyectos','listaSedes'));
    }







    //funcion del gerente, despliega la vista de revision. Si ya la revisó, esta tambien hace funcion de ver 
    public function revisar($id){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
       
        $empleadoLogeado = Empleado::getEmpleadoLogeado();  

        return view('SolicitudFondos.gerente.revisarSolicitudFondos',compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos','listaProyectos','listaSedes'));
    }

    public function aprobar(Request $request){

        try 
        {
            DB::beginTransaction();
            $solicitud = SolicitudFondos::findOrFail($request->codSolicitud);


            if(!$solicitud->listaParaAprobar())
                return redirect()->route('solicitudFondos.listarSolicitudes')
                    ->with('datos','ERROR: La solicitud ya fue aprobada o no está apta para serlo.');

            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Aprobada');
            $solicitud->observacion = '';
            $empleadoLogeado = Empleado::getEmpleadoLogeado();  

            $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $solicitud->fechaHoraRevisado = Carbon::now();
            $solicitud->justificacion = $request->justificacion;
            $solicitud->save();

            $listaDetalles = DetalleSolicitudFondos::where('codSolicitud','=',$solicitud->codSolicitud)->get();
            foreach($listaDetalles as $itemDetalle){
                $itemDetalle->codigoPresupuestal = $request->get('CodigoPresupuestal'.$itemDetalle->codDetalleSolicitud);
                $itemDetalle->save();
                
            }


            DB::commit();
            return redirect()->route('SolicitudFondos.Gerente.listar')
                ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Aprobada! ');
        } catch (\Throwable $th) {
           Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : APROBAR',$th);
           DB::rollBack();
           return redirect()->route('SolicitudFondos.Gerente.listar')
           ->with('datos','Ha ocurrido un error');

        }

    }


    public function contabilizar($id){
        try 
        {
            DB::beginTransaction();
            $solicitud = SolicitudFondos::findOrFail($id);
            
            if(!$solicitud->listaParaContabilizar())
                return redirect()->route('solicitudFondos.listarSolicitudes')
                    ->with('datos','ERROR: La solicitud ya fue contabilizada o no está apta para serlo.');

            
            
            
            
            
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Contabilizada');
            $empleadoLogeado = Empleado::getEmpleadoLogeado();  

            $solicitud->codEmpleadoContador = $empleadoLogeado->codEmpleado;
            
            $solicitud->save();
            DB::commit();

            return redirect()->route('SolicitudFondos.Contador.listar')
                ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Contabilizada! ');
        } catch (\Throwable $th) {
           Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : CONTABILIZAR',$th);
           DB::rollBack();

           return redirect()->route('SolicitudFondos.Contador.listar')
                ->with('datos','Ha ocurrido un error.');
        }





    }

    public function vistaAbonar($id){ 
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
        return view('SolicitudFondos.administracion.abonarSolicitudFondos',compact('solicitud','detallesSolicitud'));

    }

    //CAMBIA EL ESTADO DE LA SOLICITUD A ABONADA, Y GUARDA LA FECHA HORA ABONADO
    public function abonar(Request $request){
        $id = $request->codSolicitud;
        try {
           DB::beginTransaction();
            $solicitud = SolicitudFondos::findOrFail($id);

            if(!$solicitud->listaParaAbonar())
                return redirect()->route('solicitudFondos.listarSolicitudes')
                    ->with('datos','ERROR: La solicitud ya fue abonada o no está apta para serlo.');



            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Abonada');
            $solicitud->codEmpleadoAbonador = Empleado::getEmpleadoLogeado()->codEmpleado;

            $solicitud->fechaHoraAbonado = Carbon::now();
            $solicitud->save();
            
            

            DB::commit();
        return redirect()->route('SolicitudFondos.Administracion.listar')
            ->with('datos','¡Solicitud '.$solicitud->codigoCedepas.' Abonada!');


        } catch (\Throwable $th) {
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : ABONAR',$th);
            DB::rollBack();
            return redirect()->route('SolicitudFondos.Administracion.listar')
            ->with('datos','Ha ocurrido un error.');

        }

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
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaSedes = Sede::All();
        $listaCDP = CDP::All();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        $objNumeracion = Numeracion::getNumeracionREN();

        $listaEmpleadosDeSede  = Empleado::getEmpleadosActivos();
        return view ('RendicionGastos.empleado.crearRendicionGastos',
                    compact('empleadoLogeado','listaBancos'
                    ,'listaProyectos','listaSedes','listaEmpleadosDeSede','solicitud',
                    'listaCDP','detallesSolicitud','objNumeracion'));
    }





    public function edit($id){ //id de la solicidu codSolicitud

        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaSedes = Sede::All();
        $listaMonedas = Moneda::All();
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
        //return $detallesSolicitud;
        
        $empleadoLogeado = Empleado::getEmpleadoLogeado();

        return view('SolicitudFondos.empleado.editarSolicitudFondos',
            compact('solicitud','detallesSolicitud','empleadoLogeado','listaBancos',
                'listaMonedas','listaProyectos','listaSedes'));
    }




    public function create(){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaSedes = Sede::All();
        $listaMonedas = Moneda::All();
        $empleadoLogeado = Empleado::getEmpleadoLogeado();
        $objNumeracion = Numeracion::getNumeracionSOF();
        $listaEmpleadosDeSede  = Empleado::getEmpleadosActivos();
        return view('SolicitudFondos.empleado.crearSolicitudFondos',
            compact('empleadoLogeado','listaBancos','listaProyectos',
                'listaMonedas','listaSedes','listaEmpleadosDeSede','objNumeracion'));

    }

    //funcion servicio a ser consumida por javascript 
    public function getNumeracionLibre(){
        return Numeracion::getNumeracionSOF()->numeroLibreActual;
    }



    public function prueba(){
        $lista = SolicitudFondos::All();
        $lista = SolicitudFondos::ordenarParaEmpleado($lista);

        return $lista;
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
                ->route('SolicitudFondos.empleado.listar')
                ->with('datos','Se ha creado la solicitud '.$solicitud->codigoCedepas);
        }catch(\Throwable $th){
            
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : STORE',$th);
            
            DB::rollback();
            return redirect()
                ->route('SolicitudFondos.empleado.listar')
                ->with('datos','Ha ocurrido un error.');
        }

        

    }

    public function verContabilizar($id){
        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaSedes = Sede::All();
        
        $solicitud = SolicitudFondos::findOrFail($id);
        $detallesSolicitud = DetalleSolicitudFondos::where('codSolicitud','=',$id)->get();
       
        $empleadoLogeado = Empleado::getEmpleadoLogeado();  

        return view('SolicitudFondos.contador.contabilizarSolicitudFondos',
            compact('solicitud','detallesSolicitud','empleadoLogeado',
                    'listaBancos','listaProyectos','listaSedes'));
    }


    //actualiza el contenido de una solicitud
    public function update( Request $request,$id){

        try {
                DB::beginTransaction();   
            $solicitud = SolicitudFondos::findOrFail($id);


            if(!$solicitud->listaParaUpdate())
                return redirect()->route('solicitudFondos.listarSolicitudes')
                    ->with('datos','ERROR: La solicitud no puede ser actualizada.');

            if(Empleado::getEmpleadoLogeado()->codEmpleado != $solicitud->codEmpleadoSolicitante)
                return redirect()->route('solicitudFondos.listarSolicitudes')
                    ->with('datos','ERROR: La solicitud no puede ser actualizada por un empleado que no la creó.');



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
            return redirect()->route('SolicitudFondos.empleado.listar')
                ->with('datos','Registro '.$solicitud->codigoCedepas.' actualizado');
            
        }catch(\Throwable $th){
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER : UPDATE',$th);
            
            DB::rollback();
            return redirect()->route('SolicitudFondos.empleado.listar')
                ->with('datos','Ocurrió un error.');
        }
    }


    public function cancelar($id){ //para cancelar una solicitud desde el index

        try {
            DB::beginTransaction();
            $solicitud = SolicitudFondos::findOrFail($id);

            if(!$solicitud->listaParaCancelar())
            return redirect()->route('solicitudFondos.listarSolicitudes')
                ->with('datos','ERROR: La solicitud no puede cancelada puesto que ya fue ABONADA.');
            


            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Cancelada');
            $solicitud->save();
            DB::commit();

            return redirect()->route('SolicitudFondos.empleado.listar')
                ->with('datos','Se ha cancelado la solicitud '.$solicitud->codigoCedepas);
            
        } catch (\Throwable $th) {
            Debug::mensajeError('SOLICITUD FONDOS CONTROLLER DELETE',$th);

            return redirect()->route('SolicitudFondos.empleado.listar')
                ->with('datos','Ha ocurrido un error: ');
            
        }

    }


    public function reportes(){
        
        $empleado = Empleado::getEmpleadoLogeado();


        
        $listaSolicitudesFondos = SolicitudFondos::
        where('codEmpleadoSolicitante','=',$empleado->codEmpleado)
            ->orderBy('codEstadoSolicitud','ASC')
            ->paginate();

        $buscarpor = "";

        $listaBancos = Banco::All();
        $listaProyectos = Proyecto::getProyectosActivos();
        $listaSedes = Sede::All();
        $listaEmpleados = Empleado::getEmpleadosActivos();
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
