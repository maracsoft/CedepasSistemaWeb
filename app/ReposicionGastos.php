<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReposicionGastos extends Model
{
    protected $table = "reposicion_gastos";
    protected $primaryKey ="codReposicionGastos";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codEstadoReposicion','codEmpleadoSolicitante','codEmpleadoEvaluador','codEmpleadoAdmin','codEmpleadoConta',
    'codProyecto','codMoneda',
    'fechaEmision','codigoCedepas','girarAOrdenDe','codBanco','resumen','fechaHoraRevisionGerente','fechaHoraRevisionAdmin','fechaHoraRevisionConta','observacion'];


    public function getNombreEstado(){ 
        $estado = EstadoReposicionGastos::findOrFail($this->codEstadoReposicion);
        return $estado->nombre;
    }

    public function getColorEstado(){ //BACKGROUND
        $color = '';
        switch($this->codEstadoReposicion){
            case 1: 
                $color = 'rgb(215,208,239)';
                break;
            case 2:
                $color = 'rgb(91,79,148)';
                break;
            case 3:
                $color = 'rgb(195,186,230)';
                break;
            case 4:
                $color ='rgb(35,28,85)';
                break;
            case 5:
                $color ='rgb(35,28,85)';
                break;
            case 6:
                $color ='rgb(35,28,85)';
                break;
            case 7:
                $color ='red';
                break;
        }
        return $color;
    }

    public function getColorLetrasEstado(){
        $color = '';
        switch($this->codEstadoReposicion){
            case 1: 
                $color = 'black';
                break;
            case 2:
                $color = 'white';
                break;
            case 3:
                $color = 'black';
                break;
            case 4:
                $color = 'white';
                break;
            case 5:
                $color ='white';
                break;
            case 6:
                $color ='white';
                break;
            case 7:
                $color ='white';
                break;
        }
        return $color;
    }

    public function evaluador(){
        $empleado=Empleado::find($this->codEmpleadoEvaluador);
        return $empleado;
    }
    public function getProyecto(){
        $proyecto=Proyecto::find($this->codProyecto);
        return $proyecto;
    }
    public function getBanco(){
        $banco=Banco::find($this->codBanco);
        return $banco;
    }
    public function getMoneda(){
        return Moneda::find($this->codMoneda);
    }
    
    public function detalles(){
        return DetalleReposicionGastos::where('codReposicionGastos','=',$this->codReposicionGastos)->get();
    }
    public function monto(){
        $total=0;
        foreach ($this->detalles() as $itemdetalle) {
            $total+=$itemdetalle->importe;
        }
        return $total;
    }
}
