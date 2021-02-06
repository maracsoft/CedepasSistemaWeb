<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MacroCategoria extends Model
{
    protected $table = "macro_categoria";
    protected $primaryKey ="codMacroCategoria";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre'];


    public function categoria(){
        return $this->hasMany('App\Categoria','codMacroCategoria','codMacroCategoria');
    }
}
