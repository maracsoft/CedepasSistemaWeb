<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroJustificacion extends Model
{
    public $timestamps = false;

    protected $table = 'registro_justificacion';

    protected $primaryKey = 'codRegistroJustificacion';

    protected $fillable = [
        'codPeriodoEmpleado','fechaInicio','fechaFin','descripcion','estado','fechaHoraRegistro','documentoPrueba'
    ];

    public function periodoEmpleado(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\PeriodoEmpleado','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }
}
