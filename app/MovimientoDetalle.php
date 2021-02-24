<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoDetalle extends Model
{
    //
    protected $table='movimiento_detalle';

    protected $primaryKey = 'codMovimientoDetalle';

    protected $fillable = [
        'codMovimientoDetalle',
        'codMovimiento',
        'codExistencia',
        'cantidadMovida'
    ];

    public function movimiento(){
        return $this->belongsTo('App\Movimiento','codMovimiento');
    }

    public function existencia(){
        return $this->belongsTo('App\Existencia','codExistencia');
    }

}
