<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\DB;
class Parametro extends Model
{
    protected $table = "parametros";
    protected $primaryKey ="tipo_id";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['numeracion','serie'];

    public static function ActualizarNumero($tipo_id, $numeracion){
        try{
            DB::table('parametros')
                ->where('tipo_id', '=', $tipo_id)                
                ->update([
                    'numeracion' => $numeracion]);
            return true;
        }catch(Exception $ex){
            error_log('HA OCURRIDO UN ERROR EN Parametro::ActualizarNumero. Msj error:'.$ex);
            return false;
        }
    } 

}
