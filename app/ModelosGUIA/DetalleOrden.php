<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    protected $table = "detalle_orden";
    protected $primaryKey ="codDetalleOrden";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codOrden','codProducto','cantidad','precio'];

}
