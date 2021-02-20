<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTurno extends Model
{
    public $timestamps = false;

    protected $table = 'turno_tipo';

    protected $primaryKey = 'codTipoTurno';

    protected $fillable = [
        'nombre'
    ];
}
