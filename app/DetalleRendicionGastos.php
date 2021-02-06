<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRendicionGastos extends Model
{
    protected $table = "detalle_rendicion_gastos";
    protected $primaryKey ="codDetalleRendicion";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codRendicionGastos','fecha','nroComprobante',
    'concepto','importe',
    'codigoPresupuestal','codTipoCDP'];

}
