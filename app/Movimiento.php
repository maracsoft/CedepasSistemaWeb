<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    //
    protected $table='movimiento';

    protected $primaryKey = 'codMovimiento';

    protected $fillable = [
        'codMovimiento',
        'tipoMovimiento',
        'fecha',
        'observaciones',
        'descripcion',
        'codEmpleadoResponsable',
        'codEmpleadoEncargadoAlmacen'
    ];

    public function empleadoResponsable(){
        return $this->belongsTo('App\Empleado','codEmpleadoResponsable','codEmpleado');
    }

    public function empleadoAlmacen(){
        return $this->belongsTo('App\Empleado','codEmpleadoEncargadoAlmacen','codEmpleado');
    }
}
