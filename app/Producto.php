<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Categoria;
use App\Unidad;
use Illuminate\Support\Facades\DB;

class Producto extends Model
{
    protected $table = "producto";
    protected $primaryKey ="codProducto";

    public $timestamps = false;  //para que no trabaje con los campos fecha 

        
    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre','codCategoria','estado','precioActual'];

    public function categoria(){
            return $this->hasOne('App\Categoria','codCategoria','codCategoria');

    }


}
