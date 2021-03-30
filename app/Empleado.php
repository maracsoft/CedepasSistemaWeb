<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\User;

class Empleado extends Model
{
    protected $table = "empleado";
    protected $primaryKey ="codEmpleado";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    
    // le indicamos los campos de la tabla 
    protected $fillable = ['codUsuario','nombres','apellidos','activo','codigoCedepas','dni','codPuesto','fechaRegistro','fechaDeBaja','codSede'];




    public function getSolicitudesPorRendir(){
        $vector = [SolicitudFondos::getCodEstado('Abonada'),SolicitudFondos::getCodEstado('Contabilizada')];

        return SolicitudFondos::whereIn('codEstadoSolicitud',$vector)
            
        ->where('estaRendida','=',0)
        ->get();


    }

    
    public function getSolicitudesObservadas(){
        return SolicitudFondos::
            where('codEstadoSolicitud','=',SolicitudFondos::getCodEstado('Observada'))
            ->where('codEmpleadoSolicitante','=',$this->codEmpleado)
            ->get();


    }


    public function getReposicionesObservadas(){

        return ReposicionGastos::where('codEmpleadoSolicitante','=',$this->codEmpleado)
            ->where('codEstadoReposicion','=',ReposicionGastos::getCodEstado('Observada'))
            ->get();


    }

    public function getRendicionesObservadas(){

        return RendicionGastos::where('codEmpleadoSolicitante','=',$this->codEmpleado)
            ->where('codEstadoRendicion','=',RendicionGastos::getCodEstado('Observada'))
            ->get();


    }


    public function getNombrePuesto(){
        $cad = $this->getPuestoActual()->nombre;
        if($cad == 'Empleado')
            $cad = "Colaborador";

        return $cad;

    }

    //le pasamos la id del usuario y te retorna el codigo cedepas del empleado
    public function getNombrePorUser( $idAuth){
        $lista = Empleado::where('codUsuario','=',$idAuth)->get();
        return $lista[0]->nombres;

    } 

    public function esGerente(){
        $puesto = Puesto::findOrFail($this->codPuesto);
        if($puesto->nombre=='Gerente')//si es gerente
            return true;

        return false;

    }

    public function esContador(){
        $puesto = Puesto::findOrFail($this->codPuesto);
        if($puesto->nombre=='Contador')//si es gerente
            return true;

        return false;

    }

    public function esAdminSistema(){
        $usuario = User::findOrFail($this->codUsuario);
        return $usuario->isAdmin=='1';

    }
    
    /* REFACTORIZAR ESTO PARA LA NUEVA CONFIGURACION DEL A BASE DE DATOOOOOOOOOOOOOOOOOOOOOOOOOS */
    //para modulo ProvisionFondos. 
    public function esJefeAdmin(){
        $puesto = Puesto::findOrFail($this->codPuesto);
        if($puesto->nombre=='Administrador')
            return true;
        
        return false;
        
    }
    public function getPuestoActual(){
        return Puesto::findOrFail($this->codPuesto);

    }


    //solo se aplica a los gerentes, retorna el proyecto que este gerente lidera
    /* public function getProyectoGerencia(){
        $proy = Proyecto::where('codEmpleadoDirector','=',$this->codEmpleado)->get();
        if(count($proy) == 0 )
            return new Proyecto();

        return $proy[0];
        
    } */


    public static function getListaGerentesActivos(){
        $lista = Empleado::
            where('codPuesto','=',Puesto::getCodigo('Gerente'))
            ->where('activo','=','1')->get();
        return $lista;

    }

    public static function getListaContadoresActivos(){
        $lista = Empleado::
            where('codPuesto','=','11')
            ->where('activo','=','1')->get();
        return $lista;

    }

    //solo se aplica a los gerentes, retorna lista de proyectos que este gerente lidera
    public function getListaProyectos(){
        $proy = Proyecto::where('codEmpleadoDirector','=',$this->codEmpleado)->get();
        //retornamos el Collection
        return $proy;
    }

    // solo para gerente
    public function getListaSolicitudesDeGerente(){
        /*
        //Construimos primero la busqueda de todos los proyectos que tenga este gerente
        $listaProyectos = $this->getListaProyectos();
        $vecProy=[];
        foreach ($listaProyectos as $itemProyecto ) {
           array_push($vecProy,$itemProyecto->codProyecto );
        }
    
        $listaSolicitudesFondos = SolicitudFondos::whereIn('codProyecto',$vecProy)
        ->orderBy('codEstadoSolicitud')
        ->get();
        */
        $listaSolicitudesFondos = $this->getListaSolicitudesDeGerente2()->get();
        return $listaSolicitudesFondos;

    }

    public function getListaSolicitudesDeGerente2(){
        //Construimos primero la busqueda de todos los proyectos que tenga este gerente
        $listaProyectos = $this->getListaProyectos();
        $vecProy=[];
        foreach ($listaProyectos as $itemProyecto ) {
           array_push($vecProy,$itemProyecto->codProyecto );
        }
    
        $listaSolicitudesFondos = SolicitudFondos::whereIn('codProyecto',$vecProy)
        ->orderBy('codEstadoSolicitud');

        return $listaSolicitudesFondos;

    }

    //solo para gerente
    public function getListaRendicionesGerente(){

        $listaSolicitudes = $this->getListaSolicitudesDeGerente();
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
        return $listaRendiciones;


    }

    //retorna -1 si no tiene un periodo actual
    /* public function getPeriodoEmpleadoActual(){
        $periodos=PeriodoEmpleado::where('codEmpleado','=',$this->codEmpleado)
        ->where('activo','=',1)->get();
        if(count($periodos)==0)
            return '-1';

        return $periodos[0];   


    } */

    public static function getEmpleadoLogeado(){
        $codUsuario = Auth::id();         
        $empleados = Empleado::where('codUsuario','=',$codUsuario)->get();

        if(is_null(Auth::id())){
            return false;
        }


        if(count($empleados)<0) //si no encontró el empleado de este user 
        {
            error_log('
            
            ERROR : 
            EMPLEADO->getEmpleadoLogeado()
            
            ');
            return false;
        }
        return $empleados[0]; 
    }


    
    public function usuario(){

        try{
        $usuario = User::findOrFail($this->codUsuario);
        
        }catch(Throwable $th){
            error_log('
            
                HA OCURRIDO UN ERROR EN EL MODELO EMPLEADO: 

                usuario no encontrato

                '.$th.'
            
            ');
            return "usuario no encontrado.";


        }
        
        return $usuario;
        
    }

    
    public function getNombreCompleto(){
        return $this->nombres.' '.$this->apellidos;

    }

    public static function getEmpleadosActivos(){ //FALTA METER EN PROYECTO EL int ACTIVO
        return Empleado::where('activo','=','1')->get();
    }

    
    public static function getMesActual(){
        date_default_timezone_set('America/Lima');
        return (int)date('m');
    }

    
    
    



    public function reposicion(){
        $reposiciones=ReposicionGastos::where('codEmpleadoSolicitante','=',$this->codEmpleado)->get();
        return $reposiciones;
    }
}
