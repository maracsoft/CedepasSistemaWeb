<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = "mesa";
    protected $primaryKey ="codMesa";

    public $timestamps = false;  //para que no trabaje con los campos fecha 


    // le indicamos los campos de la tabla 
    protected $fillable = ['codSala','nroSillas','nroEnSala','estado'];

    public function sala(){
        return $this->hasOne('App\Sala','codSala','codSala');

}
    
    
}
