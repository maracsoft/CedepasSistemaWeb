<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvanceEntregable extends Model
{
    public $timestamps = false;

    protected $table = 'avance_entregable';

    protected $primaryKey = 'codAvanceEntregable';

    protected $fillable = [
        'descripcion','fechaEntrega','porcentaje','monto','codPeriodoEmpleado'
    ];
}
