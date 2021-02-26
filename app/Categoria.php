<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table='categoria';

    protected $primaryKey = 'codCategoria';
    public $timestamps = false;

    protected $fillable = [
        'codCategoria',
        'nombre'
    ];

    public function existencia(){
        return $this->hasMany('App\Existencia');
    }
}
