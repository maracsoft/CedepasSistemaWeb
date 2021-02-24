<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExistenciaPerdida extends Model
{
    //
    protected $table='existencias_perdidas';

    protected $primaryKey = 'codExistenciaPerdida';

    protected $fillable = [
        'codExistenciaPerdida',
        'fecha',
        'codEmpleadoEncargadoAlmacen',
        'codExistencia',
        'cantidad',
        'descripcion'
    ];

    public function existencia(){
        return $this->belongsTo('App\Existencia','codExistencia');
    }

    public function empleadoAlmacen(){
        return $this->belongsTo('App\Empleado','codEmpleadoEncargadoAlmacen','codEmpleado');
    }
}
