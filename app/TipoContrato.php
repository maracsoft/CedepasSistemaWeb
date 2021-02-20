<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    public $timestamps = false;

    protected $table = 'contrato_tipo';

    protected $primaryKey = 'codTipoContrato';

    protected $fillable = [
        'nombre'
    ];
}
