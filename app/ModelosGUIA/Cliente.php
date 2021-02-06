<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "clientes";
    protected $primaryKey ="codcliente";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombres','direccion','ruc_dni','email','estado'];

    public function ventas(){

        return $this->hasMany('App\CabeceraVenta','codcliente','codcliente');
    }

}
