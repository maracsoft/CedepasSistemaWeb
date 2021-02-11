<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = "empleado";
    protected $primaryKey ="codEmpleado";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

    
    // le indicamos los campos de la tabla 
    protected $fillable = ['codUsuario','nombres','apellidos',
    'fechaNacimiento','codEmpleadoTipo','sexo','activo','codigoEmpleadoCedepas'];


    //le pasamos la id del usuario y te retorna el codigo cedepas del empleado
    public function getNombrePorUser( $idAuth){
        $lista = Empleado::where('codUsuario','=',$idAuth)->get();
        return $lista[0]->nombres;

    } 

    


}
