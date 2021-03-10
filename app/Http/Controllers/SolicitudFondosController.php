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
        

        //Debe listar con prioridad las CREADAS y las SUBSANADAS 

        $query = DB::select('
        SELECT * FROM `solicitud_fondos`
            WHERE codProyecto = '.$empleado->codProyecto.' 
            order by MOD(codEstadoSolicitud-1,5)
        '); //residuo de 5 para que me priorice las 6 y 1 (residuo 0 )

        $listaSolicitudesFondos = new Collection();
        for ($i=0; $i < count($query); $i++) { 
            $itemSol = SolicitudFondos::findOrFail($query[$i]->codSolicitud);
            $listaSolicitudesFondos->add($itemSol);
        }
        //PARA PODER PAGINAR EL COLECTTION USE https://gist.github.com/iamsajidjaved/4bd59517e4364ecec98436debdc51ecc#file-appserviceprovider-php-L23
        $listaSolicitudesFondos=$listaSolicitudesFondos->paginate($this::PAGINATION);
        
        
        
        /*  
        DEPRECATED 
        $listaSolicitudesFondos = SolicitudFondos::
            where('codProyecto','=',$empleado->codProyecto)
            ->orderBy('MOD(codEstadoSolicitud,5)','ASC')
            ->orderBy('fechaHoraEmision','DESC')
        ->paginate(); */

        


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
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Aprobada');
            $solicitud->observacion = '';
            $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
            $empleadoLogeado = $LempleadoLogeado[0];
            $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $solicitud->fechaHoraRevisado = Carbon::now();

            $solicitud->save();

            DB::commit();
            return redirect()->route('solicitudFondos.listarSolicitudes')
                ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Aprobada! ');
        } catch (\Throwable $th) {
            error_log('
            
                OCURRIO UN ERROR EN SOLICITUD FONDOS CONTROLLER : APROBAR
                '.$th.'




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
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Abonada');

            $solicitud->fechaHoraAbonado = Carbon::now();
            $solicitud->save();
            

            //$codSolRecienInsertada = (SolicitudFondos::latest('codSolicitud')->first())->codSolicitud;
            
            /* 
            //YA NO GUARDAREMOS LOS COMPROBANTES DE ABONOS DE LAS SOLICITUDES 

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
            */
            
          

            DB::commit();
        return redirect()->route('solicitudFondos.listarSolicitudes')
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
 

    
    public function observar($cadena){


        
        
        try{

            $vector = explode('*',$cadena);
            if(count($vector)<2)
                throw new Exception('El argumento cadena no es valido');


            $codSolicitud = $vector[0];
            $textoObs = $vector[1];




            DB::beginTransaction();
            error_log('cod sol = '.$codSolicitud);
            $solicitud = SolicitudFondos::findOrFail($codSolicitud);
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Observada');
            $solicitud->observacion = $textoObs;
            error_log('
            
            
            
            razon request:'.$textoObs);
            $LempleadoLogeado = Empleado::where('codUsuario','=', Auth::id())->get();
            $empleadoLogeado = $LempleadoLogeado[0];
            $solicitud->codEmpleadoEvaluador = $empleadoLogeado->codEmpleado;
            $solicitud->fechaHoraRevisado = Carbon::now();


            $solicitud->save();
            DB::commit();
            return redirect()->route('solicitudFondos.listarSolicitudes')
            ->with('datos','Solicitud '.$solicitud->codigoCedepas.' Observada');

        } catch (\Throwable $th) {
            error_log('
            
                OCURRIO UN ERROR EN SOLICITUD FONDOS CONTROLLER : OBSERVAR
            
                '.$th.'


            ');

            DB::rollBack();
            return redirect()->route('solicitudFondos.listarGerente')
            ->with('datos','Ha ocurrido un error');
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

            $solicitud->fechaHoraEmision =  Carbon::now();
            $solicitud->totalSolicitado = $request->total;
            $solicitud->girarAOrdenDe = $request->girarAOrden;
            $solicitud->numeroCuentaBanco = $request->nroCuenta;
            $solicitud->codBanco = $request->ComboBoxBanco;
            $solicitud->justificacion = $request->justificacion;
            $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Creada');
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

            //Si está siendo editada porque la observaron, pasa de OBSERVADA a SUBSANADA
            if ($solicitud->codEstadoSolicitud == SolicitudFondos::getCodEstado('Observada')) {
                $solicitud->codEstadoSolicitud = SolicitudFondos::getCodEstado('Subsanada');;
            }
            //Si no, que siga en su estado CREADA


            $solicitud->codProyecto = $request->ComboBoxProyecto;
            $solicitud->codigoCedepas = $request->codSolicitud;

            
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
            error_log('\\n ----------------------  SOLICITUD FONDOS CONTROLLER UPDATE
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
