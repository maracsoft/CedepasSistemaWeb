<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroSolicitud extends Model
{
    public $timestamps = false;

    protected $table = 'registro_solicitud';

    protected $primaryKey = 'codRegistroSolicitud';

    protected $fillable = [
        'codPeriodoEmpleado','fechaInicio','fechaFin','descripcion','estado','fechaHoraRegistro','codTipoSolicitud','documentoPrueba'
    ];

    public function periodoEmpleado(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\PeriodoEmpleado','codPeriodoEmpleado','codPeriodoEmpleado');//el tercer parametro es de Producto
    }
    public function tipoLicencia(){//singular pq un producto es de una cateoria
        return $this->hasOne('App\TipoLicencia','codTipoSolicitud','codTipoSolicitud');//el tercer parametro es de Producto
    }
}
