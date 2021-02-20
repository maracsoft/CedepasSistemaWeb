<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoLicencia extends Model
{
    public $timestamps = false;

    protected $table = 'licencia_tipo';

    protected $primaryKey = 'codTipoSolicitud';

    protected $fillable = [
        'descripcion'
    ];
}
