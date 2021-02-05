<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $table = "categoria";
    protected $primaryKey ="codCategoria";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['nombre','estado','codMacroCategoria'];

    public function macroCategoria(){
        return $this->hasOne('App\MacroCategoria','codMacroCategoria','codMacroCategoria');

}


}
