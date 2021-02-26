<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    public $timestamps = false;

    protected $table = 'asistencia';

    protected $primaryKey = 'codRegistroAsistencia';

    protected $fillable = [
        'codPeriodoEmpleado','fechaHoraEntrada','fechaHoraSalida','fechaHoraEntrada2',
        'fechaHoraSalida2','estado','fecha'
    ];

    public function periodoEmpleado(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\PeriodoEmpleado','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }
}
