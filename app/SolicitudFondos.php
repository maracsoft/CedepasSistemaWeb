<?php

namespace App;



use Illuminate\Database\Eloquent\Model;

class SolicitudFondos extends Model
{
    protected $table = "solicitud_fondos";
    protected $primaryKey ="codSolicitud";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    
    // le indicamos los campos de la tabla 
    protected $fillable = ['codProyecto','codigoCedepas','codEmpleadoSolicitante','fechaEmision',
    'totalSolicitado','girarAOrdenDe','numeroCuentaBanco','codBanco','justificacion',
    'codEmpleadoEvaluador','fechaRevisado','codEstadoSolicitud','codSede'];

    public function getNombreSede(){
        $sede = Sede::findOrFail($this->codSede);
        return $sede->nombre;

    }

    public function getNombreProyecto(){
        $proyecto = Proyecto::findOrFail($this->codProyecto);
        return $proyecto->nombreProyecto;
    } 

    public function getNombreEstado(){
        $estado = EstadoSolicitudFondos::findOrFail($this->codEstadoSolicitud);
        return $estado->nombreEstado;

    }

    public function getNombreBanco(){
        $banco = Banco::findOrFail($this->codBanco);
        return $banco->nombreBanco;

    }

    
    public function getFechaRevision(){
        if($this->fechaRevisado == null )
        {
            return "---";
        }
        else{
            $stringFecha =$this->fechaRevisado; 
            $stringFecha =   str_replace('-','/',$stringFecha);
            return $stringFecha;
        }

    }

    //MODIFICA EL VALOR PARA QUE SEA / en lugar de - 
    public function getFechaEmision(){
        $stringFecha =$this->fechaEmision; 
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


}