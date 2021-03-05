<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Throwable;

class Empleado extends Model
{
    protected $table = "empleado";
    protected $primaryKey ="codEmpleado";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    
    // le indicamos los campos de la tabla 
    protected $fillable = ['codUsuario','nombres','apellidos',
    'fechaNacimiento','codEmpleadoTipo','sexo','activo',
    'codigoEmpleadoCedepas','codProyecto','dni'];


    //le pasamos la id del usuario y te retorna el codigo cedepas del empleado
    public function getNombrePorUser( $idAuth){
        $lista = Empleado::where('codUsuario','=',$idAuth)->get();
        return $lista[0]->nombres;

    } 

    public function esGerente(){
        $listaProyectos = Proyecto::where('codEmpleadoDirector','=',$this->codEmpleado)->get();
        if(count($listaProyectos)>0)//si es director
            return true;

        return false;

    }

    
    /* REFACTORIZAR ESTO PARA LA NUEVA CONFIGURACION DEL A BASE DE DATOOOOOOOOOOOOOOOOOOOOOOOOOS */
    //para modulo vigo. 
    public function esJefeAdmin(){

        $periodo = $this->getPeriodoEmpleadoActual();
        if($periodo=='-1') return false;

        $puesto = $periodo->getPuesto();
        if($puesto->nombre=='Jefe de Administración')
            return true;
        return false;
        
    }
    public function getPuestoActual(){
        $periodo = $this->getPeriodoEmpleadoActual();
        if($periodo=='-1')
            return new Puesto();


        return $periodo->getPuesto();

    }


    //retorna -1 si no tiene un periodo actual
    public function getPeriodoEmpleadoActual(){
        $periodos=PeriodoEmpleado::where('codEmpleado','=',$this->codEmpleado)
        ->where('activo','=',1)->get();
        if(count($periodos)==0)
            return '-1';

        return $periodos[0];   


    }

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
        return $this->hasOne('App\User','codUsuario','codUsuario');
    }

    
    public function periodoEmpleado(){//
        return $this->hasMany('App\PeriodoEmpleado','codEmpleado','codEmpleado');


    }

    public function getNombreCompleto(){
        return $this->nombres.' '.$this->apellidos;

    }

    public function getProyecto(){
        $proy = Proyecto::findOrFail($this->codProyecto);
        return $proy;
    }

    public function tieneCaja(){
        if($this->getCaja()=='-1') //si no tiene caja
            return '0'; //retornamos false
        
        return '1'; //retornamos true

    }
    
    //si es encargado de una caja, retorna el objeto de esa caja. Si no, retorna -1
    public function getCaja(){
        $cajas = Caja::where('codEmpleadoCajeroActual','=',$this->codEmpleado)->get();
        if(count($cajas)==0) //no tiene caja
            return '-1';

        $caja = $cajas[0];
        return $caja;

    }


    /* Retorna el ultimo periodo de ese emp cajero, no importa su estado */
    public function getPeriodoCaja(){
        
        
        $listaPeriodos = PeriodoCaja::where('codEmpleadoCajero','=',$this->codEmpleado)
        ->orderBy('codPeriodoCaja','DESC')
        //->where('codEstado','=','1')
        ->get();
        
        
        if(count($listaPeriodos)==0){
            return '-1';
           
        }
        $periodo = $listaPeriodos[0];
        return $periodo;


    }

    public function getContratoHabil($codigo){
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$codigo)->where('activo','=',1)->get();
        return $contratos[0];
    }


    public static function getEmpleadosModalidadPlazoFijo(){
        $vector=array();
        $contratos=PeriodoEmpleado::where('codTipoContrato','=',1)->where('activo','=',1)->get();
        foreach ($contratos as $itemcontrato) {
            $empleado=Empleado::find($itemcontrato->codEmpleado);
            $vector[]=$empleado;
        }
        return $vector;
    }

    public static function getMesActual(){
        date_default_timezone_set('America/Lima');
        return (int)date('m');
    }

    //pa modulo de mari
    public function getSueldoContrato(){
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$this->codEmpleado)->where('activo','=',1)->get();
        if(count($contratos)==0)
            return '';
        
        return $contratos[0]->sueldoFijo;
    }
    public function getAFP(){
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$this->codEmpleado)->where('activo','=',1)->get();
        if(count($contratos)==0)
            return new AFP();
        
        $AFP=AFP::find($contratos[0]->codAFP);
        return $AFP;
    }
    public function cantDiasVacacionesEnElMes($mes){
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$this->codEmpleado)->where('activo','=',1)->get();
        $solicitudesAprobadas=SolicitudFalta::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->where('estado','=',2)->get();

        $cont=0;
        foreach ($solicitudesAprobadas as $itemsolicitud) {
            $fechaTemporal=$itemsolicitud->fechaInicio;
            if((int)date('m',strtotime($fechaTemporal))==$mes){
                while ((int)date('m',strtotime($fechaTemporal))==$mes) {
                    $cont+=1;
                    $fechaTemporal=date("Y-m-d",strtotime($fechaTemporal."+ 1 days"));
                }
            }
        }

        return $cont;
    }

    public function cantFaltasEnElMes($mes){
        $contratos=PeriodoEmpleado::where('codEmpleado','=',$this->codEmpleado)->where('activo','=',1)->get();
        $asistencias=Asistencia::where('codPeriodoEmpleado','=',$contratos[0]->codPeriodoEmpleado)->get();


        $contTotal=0;
        $contAsistencias=0;
        //$contTardanzas=0;

        foreach ($asistencias as $itemasistencia) {
            if((int)date('m',strtotime($itemasistencia->fecha))==$mes){
                if(!is_null($itemasistencia->fechaHoraEntrada)){
                    $contAsistencias++;
                }
                if(!is_null($itemasistencia->fechaHoraEntrada2)){
                    $contAsistencias++;
                }

                if($itemasistencia->periodoEmpleado->turno->codTipoTurno==3){
                    $contTotal+=2;
                }else{
                    $contTotal+=1;
                }
            }
        }

        $contFaltas=$contTotal-$contAsistencias;
        return $contFaltas;
    }

    
}
