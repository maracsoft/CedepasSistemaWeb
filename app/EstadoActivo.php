<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoActivo extends Model
{
    public $timestamps = false;

    protected $table = 'estado_activo';

    protected $primaryKey = 'codEstado';

    protected $fillable = [
        'nombre'
    ];
}
