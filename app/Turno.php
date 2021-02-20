<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    public $timestamps = false;

    protected $table = 'turno';

    protected $primaryKey = 'codTurno';

    protected $fillable = [
        'horaInicio','horaFin','horaInicio2','horaFin2','codTipoTurno'
    ];

    public function tipoTurno(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\TipoTurno','codTipoTurno','codTipoTurno');//el tercer parametro es de Producto
    }

    public function periodoEmpleado(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\PeriodoEmpleado','codTurno','codTurno');//el tercer parametro es de Producto
    }
}
