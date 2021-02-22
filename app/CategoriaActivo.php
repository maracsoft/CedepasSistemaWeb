<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaActivo extends Model
{
    public $timestamps = false;

    protected $table = 'categoria_activo';

    protected $primaryKey = 'codCategoriaActivo';

    protected $fillable = [
        'nombre'
    ];
}
