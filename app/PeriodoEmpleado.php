<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoEmpleado extends Model
{
    public $timestamps = false;

    protected $table = 'periodo_empleado';

    protected $primaryKey = 'codPeriodoEmpleado';

    protected $fillable = [
        'fechaInicio','fechaFin','fechaContrato','codTurno','codEmpleado','sueldoFijo','activo','valorPorHora','diasRestantes','codPuesto','codTipoContrato','nombreFinanciador','codAFP','asistencia','nombreProyecto','movito'
    ];

    public function turno(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\Turno','codTurno','codTurno');//el tercer parametro es de Producto
    }

    public function empleado(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\Empleado','codEmpleado','codEmpleado');//el tercer parametro es de Producto
    }

    public function puesto(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\Puesto','codPuesto','codPuesto');//el tercer parametro es de Producto
    }

    public function tipoContrato(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\TipoContrato','codTipoContrato','codTipoContrato');//el tercer parametro es de Producto
    }

    public function registroAsistencia(){//singular pq un producto es de una cateoria
        return $this->hasMany('App\RegistroAsistencia','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }

    public function registroSolicitud(){//singular pq un producto es de una cateoria
        return $this->hasMany('App\RegistroSolicitud','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }

    public function avances(){//singular pq un producto es de una cateoria
        return $this->hasMany('App\AvanceEntregable','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }
}
