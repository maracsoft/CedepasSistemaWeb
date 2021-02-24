<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Caja;
class Proyecto extends Model
{
    protected $table = "proyecto";
    protected $primaryKey ="codProyecto";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre','codEmpleadoDirector'];
    

    //retorna 1 si el proyecto tiene una caja chica, 0 si no
    public function tieneCaja(){
        $caja = Caja::where('codProyecto','=',$this->codProyecto)->where('activa','=','1')->get();
        if(count($caja)>0)
            return 1;
        
        return 0;
    }

}
