<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SueldoMes extends Model
{
    public $timestamps = false;

    protected $table = 'sueldo_mes';

    protected $primaryKey = 'codSueldoMes';

    protected $fillable = [
        'codPeriodoEmpleado','anio','mes','diaInicio','sueldoMensual'
    ];

    public function periodoEmpleado(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\PeriodoEmpleado','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }
}
