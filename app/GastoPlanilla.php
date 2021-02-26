<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GastoPlanilla extends Model
{
    protected $table = "gasto_planilla";
    protected $primaryKey ="codGastoPlanilla";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['fechaGeneracion','mes','año','montoTotal','codEmpleadoCreador'];
    
    public function getNroEmpleados(){
        $lista = DetalleGastoPlanilla::where('codGastoPlanilla','=',$this->codGastoPlanilla)->get();
        return count($lista);

    }

    public function getEmpleadoCreador(){
        return Empleado::findOrFail($this->codEmpleadoCreador);

    }

    public function getMes(){

        switch ($this->mes) {
            case 'value':
                case "1": return "ENERO"; break;
                case "2": return "FEBRERO"; break;
                case "3": return "MARZO"; break;
                case "4": return "ABRIL"; break;
                case "5": return "MAYO"; break;
                case "6": return "JUNIO"; break;
         
                case "7": return "JULIO"; break;
                case "8": return "AGOSTO"; break;
                case "9": return "SEPTIEMBRE"; break;
                case "10": return "OCTUBRE"; break;
                case "11": return "NOVIEMBRE"; break;
                case "12": return "DICIEMBRE"; break;
         
            
        }


       

    }

}
