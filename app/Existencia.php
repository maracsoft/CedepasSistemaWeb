<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Existencia extends Model
{
    //

    protected $table='existencia';

    protected $primaryKey = 'codExistencia';
    // public $incrementing = false;
    // protected $keyType = 'string';
    public $timestamps = false;  //para que no trabaje con los campos fecha 
    
    protected $fillable = [
        'codExistencia',
        'stock',
        'nombre',
        'marca',
        'unidad',
        'codCategoria',
        'modelo',
        'codigoInterno'
    ];

    public function categoria(){
        return $this->belongsTo('App\Categoria','codCategoria');
    }
}
