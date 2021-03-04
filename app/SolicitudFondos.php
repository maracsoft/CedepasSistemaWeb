<?php

namespace App;



use Illuminate\Database\Eloquent\Model;

class SolicitudFondos extends Model
{
    protected $table = "solicitud_fondos";
    protected $primaryKey ="codSolicitud";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    
    // le indicamos los campos de la tabla 
    protected $fillable = ['codProyecto','codigoCedepas','codEmpleadoSolicitante','fechaHoraEmision',
    'totalSolicitado','girarAOrdenDe','numeroCuentaBanco','codBanco','justificacion',
    'codEmpleadoEvaluador','fechaHoraRevisado','codEstadoSolicitud','codSede','observacion'];

    public function getNombreSede(){
        $sede = Sede::findOrFail($this->codSede);
        return $sede->nombre;

    }

    public function getNombreProyecto(){
        $proyecto = Proyecto::findOrFail($this->codProyecto);
        return $proyecto->nombre;
    } 

    public function getNombreEstado(){
        $estado = EstadoSolicitudFondos::findOrFail($this->codEstadoSolicitud);
        return $estado->nombre;

    }

    public function getNombreBanco(){
        $banco = Banco::findOrFail($this->codBanco);
        return $banco->nombreBanco;

    }


    /* Retorna el codigo del estado indicado por el str parametro */
    public static function getCodEstado($nombreEstado){
        $lista = EstadoSolicitudFondos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return 'Nombre no valido';
        
        return $lista[0]->codEstadoSolicitud;

    }


    /* Retorna TRUE or FALSE cuando le mandamos el nombre de un estado */
    public function verificarEstado($nombreEstado){
        $lista = EstadoSolicitudFondos::where('nombre','=',$nombreEstado)->get();
        if(count($lista)==0)
            return false;
        
        $estado = $lista[0];
        if($estado->codEstadoSolicitud == $this->codEstadoSolicitud)
            return true;
        
        return false;
        

    }


    
    public function getFechaRevision(){
        if($this->fechaHoraRevisado == null )
        {
            return "---";
        }
        else{
            $stringFecha =$this->fechaHoraRevisado; 
            $stringFecha =   str_replace('-','/',$stringFecha);
            return $stringFecha;
        }

    }

    //MODIFICA EL VALOR PARA QUE SEA / en lugar de - 
    public function getFechaHoraEmision(){
        $stringFecha =$this->fechaHoraEmision; 
            $stringFecha =   str_replace('-','/',$stringFecha);
            return $stringFecha;

    }

    public function getNombreSolicitante(){
        $emp = Empleado::findOrFail($this->codEmpleadoSolicitante);
        return $emp->nombres.' '.$emp->apellidos;
    }

    public function getRendicion(){

        
        $rend = (RendicionGastos::where('codSolicitud','=',$this->codSolicitud)->get()) [0];
        return $rend;
    
    
    }

    //retorna el objeto empleado del que lo revisó (su director / gerente)
    public function getEvaluador(){
        $e = Empleado::findOrFail($this->codEmpleadoEvaluador);
        return $e;
    }

    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->codEstadoSolicitud){
            case '1': //CREADO
                $color = 'rgb(215,208,239)';
                break;
            case '2': //aprobado
                $color = 'rgb(91,79,148)';
                break;
            case '3': //abonado
                $color = 'rgb(195,186,230)';
                break;
            case '4': //rendida
                $color ='rgb(35,28,85)';
                break;
            case '5': //rechazada
                $color = 'rgb(248,18,8)';
                break;
            
        }
        return $color;
    }

    public function getColorLetrasEstado(){
        $color = '';
        switch($this->codEstadoSolicitud){
            case '1': //creada
                $color = 'black';
                break;
            case '2': //aprobada
                $color = 'white';
                break;
            case '3': //abonada
                $color = 'black';
                break;
            case '4': //rendida
                $color = 'white';
                break;
            case '5': //rechazada
                $color = 'white';
                break;
            
        }
        return $color;
    }
    public function getNombreEvaluador(){
        $ev = Empleado::findOrFail($this->codEmpleadoEvaluador);
        return $ev->getNombreCompleto();
    }

}
